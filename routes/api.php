<?php

use App\Http\Controllers\Gateway\CoraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('webhook-cora', [CoraController::class, 'webhook'])->name('webhook-cora');
