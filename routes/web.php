<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CASController;


Route::get('login', [\App\Http\Controllers\AuthController::class, 'auth']);

Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

// TODO maybe prefer to use "create" instead of "register"
Route::get('orders/new', [\App\Http\Controllers\OrderController::class, 'newOrder']);
Route::post('orders/new', [\App\Http\Controllers\OrderController::class, 'submitNewOrder']);

Route::get('/cas/login', [CASController::class, 'casLogin'])
    ->name('cas.login');
Route::get('suppliers', [\App\Http\Controllers\OrderController::class, 'viewSuppliers']);

Route::get('/about', [\App\Http\Controllers\AboutController::class, 'about']);
// Only for tests:
// Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);
Route::get('/Supplier', [\App\Http\Controllers\SupplierController::class, 'Supplier']);