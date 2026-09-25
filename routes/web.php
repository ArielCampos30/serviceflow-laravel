<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/orders', [WorkOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [WorkOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [WorkOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/edit', [WorkOrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [WorkOrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [WorkOrderController::class, 'destroy'])->name('orders.destroy');

    Route::middleware('admin')->group(function () {
        Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::resource('services', ServiceController::class)->except(['show']);
    });
});
