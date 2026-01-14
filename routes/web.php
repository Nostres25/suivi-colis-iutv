<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CASController;
use App\Http\Controllers\OrderController;


Route::get('login', [\App\Http\Controllers\AuthController::class, 'auth']);

Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

// TODO maybe prefer to use "create" instead of "register"
Route::get('orders/new', [\App\Http\Controllers\OrderController::class, 'newOrder']);
Route::post('orders/new', [\App\Http\Controllers\OrderController::class, 'submitNewOrder']);

Route::get('/cas/login', [CASController::class, 'casLogin']);

Route::get('suppliers', [\App\Http\Controllers\OrderController::class, 'viewSuppliers']);

Route::get('/about', [\App\Http\Controllers\AboutController::class, 'about']);
// Only for tests:
// Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);
Route::get('/Supplier', [\App\Http\Controllers\SupplierController::class, 'Supplier']);

Route::get('/service-financier', [OrderController::class, 'serviceFinancier'])->name('service.financier');


Route::put('/orders/{id}/state', [OrderController::class, 'changeState'])->name('orders.changeState');

Route::post('/orders/{id}/upload-quote', [OrderController::class, 'uploadQuote'])
    ->name('orders.uploadQuote');
