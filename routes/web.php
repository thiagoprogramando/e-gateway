<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AppController::class, 'index'])->name('home');
Route::post('created-order', [OrderController::class, 'store'])->name('created-order');