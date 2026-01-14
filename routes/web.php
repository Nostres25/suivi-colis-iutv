<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'viewOrders']);
Route::get('suppliers', [\App\Http\Controllers\SupplierController::class, 'viewSuppliers']);

Route::get('/about', [\App\Http\Controllers\AboutController::class, 'about']);
// Only for tests:
// Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);
