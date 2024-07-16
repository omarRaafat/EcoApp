<?php

use App\Http\Controllers\Api\TransactionControllers\TransactionStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('transactions')
    ->group(function () {
        Route::post('status', TransactionStatusController::class);
    });
