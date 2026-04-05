<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CoraAuthService;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CoraController extends Controller {
    
    public function getToken() {
        return $token = app(CoraAuthService::class)->getToken();
    }
    
    public function createdCharge($customer, $value, $description, $dueDate = null) {

        $token = app(CoraAuthService::class)->getToken();
        try {
            $client = new Client([
                'cert'    => config('services.cora.certificate'),
                'ssl_key' => config('services.cora.key'),
                'verify'  => false,
            ]);

            $options = [
                'headers' => [
                    'Content-Type'     => 'application/json',
                    'Accept'           => 'application/json',
                    'Authorization'    => "Bearer {$token}",
                    'Idempotency-Key'  => Str::uuid()->toString(),
                    'User-Agent'       => env('APP_NAME'),
                ],
                'json' => [
                    'customer' => [
                        'name' => $customer->name,
                        'email' => $customer->email ?? null,
                        'document' => [
                            'identity' => preg_replace('/\D/', '', $customer->cpfcnpj),
                            'type'     => (strlen(preg_replace('/\D/', '', $customer->cpfcnpj)) == 11) ? 'CPF' : 'CNPJ',
                        ],
                    ],
                    'services' => [
                        [
                            'name'        => $description,
                            'description' => $description,
                            'amount'      => intval($value * 100),
                        ],
                    ],
                    'payment_terms' => [
                        'due_date' => $dueDate ?? now()->addDays(2)->format('Y-m-d'),
                    ],
                    'payment_forms' => [
                        "BANK_SLIP",
                        "PIX",
                    ]
                ],
            ];

            $response = $client->post(env('API_BANK_URL') . 'v2/invoices/', $options);
            $data = json_decode($response->getBody()->getContents(), true);

            return [
                    'status'     => 'success',
                    'id'         => $data['id'],
                    'invoiceUrl' => $data['payment_options']['bank_slip']['url'],
                    'qrCode'     => $data['pix']['emv'] ?? null,
                ];

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);

                return [
                    'status'  => 'error',
                    'message' => $responseBody['errors'][0]['description']
                                ?? 'Erro na geração da cobrança.'
                ];
            }

            return [
                'status'  => 'error',
                'message' => 'Falha na comunicação com a API Cora.'
            ];

        } catch (\Exception $e) {

            return [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function webhook(Request $request) {

        $headers = $request->headers->all();
        if (empty($headers)) {
            return response()->json(['message' => 'Headers vazios'], 400);
        }

        $eventType  = $request->header('webhook-event-type');
        $token      = $request->header('webhook-resource-id');

        Log::info('Cora Webhook Recebido:', [
            'eventType' => $eventType,
            'token'     => $token,
        ]);

        if ($eventType == 'invoice.PAID') {

            Log::info('Cora Webhook Event:', [
                'eventType' => 'Iniciando processamento de invoice.PAID',
                'token'     => $token,
            ]);

            $order = Order::where('payment_token', $token)->whereIn('payment_status', ['pending', 'canceled'])->first();
            if ($order) {

                $order->payment_status = 'paid';
                $order->payment_date   = now();
                if ($order->save()) {
                    return response()->json(['message' => 'Pedido aprovado via Cora!'], 200);
                } 

                return response()->json(['message' => 'Falha ao aprovar Pedido!'], 400);
            }

            return response()->json(['message' => 'Nenhuma venda/pedido elegível encontrado.'], 200);
        }

        if ($eventType == 'invoice.OVERDUE' || $eventType == 'invoice.CANCELED') {

            Log::info('Cora Webhook Event:', [
                'eventType' => 'Iniciando processamento de invoice.CANCELED ou invoice.OVERDUE',
                'token'     => $token,
            ]);

            $order = Order::where('payment_token', $token)->whereIn('payment_status', ['pending', 'canceled'])->first();
            if ($order) {

                $order->payment_status = 'canceled';
                $order->payment_date   = null;
                if ($order->save()) {
                    return response()->json(['message' => 'Pedido cancelado pelo Cora (expirada ou removida).'], 200);
                }

                return response()->json(['message' => 'Falha ao cancelar Pedido!'], 400);
            }

            return response()->json(['message' => 'Nenhum registro atualizado.'], 200);
        }

        if ($eventType == 'invoice.RESTORED' || ($eventType == 'invoice.UPDATED')) {

            Log::info('Cora Webhook Event:', [
                'eventType' => 'Iniciando processamento de invoice.RESTORED ou invoice.UPDATED',
                'token'     => $token,
            ]);

            $order = Order::where('payment_token', $token)->first();
            if ($order) {

                $order->payment_status = 'pending';
                $order->payment_date   = null;
                if ($order->save()) {
                    return response()->json(['message' => 'Pedido restaurada via Cora!'], 200);
                }

                return response()->json(['message' => 'Falha ao tentar restaurar o Pedido!'], 400);
            }

            return response()->json(['message' => 'Nenhum registro atualizado!'], 200);
        }

        return response()->json(['message' => 'Nenhum evento utilizado!'], 200);
    }
}
