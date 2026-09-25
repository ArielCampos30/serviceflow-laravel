<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\WorkOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('serviceflow.api')->group(function () {
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/orders', [WorkOrderController::class, 'index']);
    Route::get('/orders/{order}', [WorkOrderController::class, 'show']);
    Route::post('/orders', [WorkOrderController::class, 'store']);
    Route::put('/orders/{order}', [WorkOrderController::class, 'update']);
});
