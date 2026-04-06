<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\CoraController;
use App\Models\Order;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller {

    public function getToken () {

        if (env('APP_ENV') == 'local') {

            $coraController = new CoraController();
            return $coraController->getToken();
        }

        return "Acesso negado!";
    }

    public function getWebhook () {

        if (env('APP_ENV') == 'local') {

            $coraController = new CoraController();
            return $coraController->getWebhook();
        }

        return "Acesso negado!";
    }
    
    public function store (Request $request) {

        $user           = new User();
        $user->uuid     = Str::uuid();
        $user->name     = $request->name;
        $user->cpfcnpj  = preg_replace('/\D/', '', $request->cpfcnpj);
        $user->email    = $request->email;
        $user->phone    = preg_replace('/\D/', '', $request->phone);
        $user->password = bcrypt(preg_replace('/\D/', '', $request->cpfcnpj));
        if ($user->save()) {

            $coraController = new CoraController();
            $payment        = $coraController->createdCharge($user, $request->package, 'MaisEduc Cursos Profissionalizates');
            if ($payment['status'] == 'success') {

                $order                  = new Order();
                $order->uuid            = Str::uuid();
                $order->user_id         = $user->id;
                $order->payment_value   = $this->formatValue($request->package);
                $order->save();

                $qrSvg = QrCode::format('svg')->size(300)->generate($payment['qrCode']);
                return redirect()->back()->with([
                    'qrCodeImg'   => 'data:image/svg+xml;base64,' . base64_encode($qrSvg),
                    'qrCode'      => $payment['qrCode'],
                    'invoiceUrl'  => $payment['invoiceUrl'],
                ]);
            }
        }

        return redirect()->back()->with('infor', 'Dados inválidos, verifique seus dados e tente novamente!');
    }

    private function formatValue ($valor) {
        
        $valor = preg_replace('/[^0-9,]/', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valorFloat = floatval($valor);
    
        return number_format($valorFloat, 2, '.', '');
    }
}
