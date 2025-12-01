<?php

use Illuminate\Support\Facades\Route;

Route::get('login', [\App\Http\Controllers\AuthController::class, 'auth']);

Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

// TODO maybe prefer to use "create" instead of "register"
Route::get('orders/new', [\App\Http\Controllers\OrderController::class, 'newOrder']);
Route::post('orders/new', [\App\Http\Controllers\OrderController::class, 'submitNewOrder']);

// Only for tests:
// Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);
