<?php

use Illuminate\Support\Facades\Route;

Route::get('login', [\App\Http\Controllers\AuthController::class, 'auth']);

Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

// TODO maybe prefer to use "create" instead of "register"
Route::get('orders/new', [\App\Http\Controllers\OrderController::class, 'newOrder']);
Route::post('orders/new', [\App\Http\Controllers\OrderController::class, 'submitNewOrder']);
Route::get('/about', [\App\Http\Controllers\AboutController::class, 'about']);
// Only for tests:
// Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);
Route::get('/Supplier', [\App\Http\Controllers\SupplierController::class, 'Supplier']);


Route::get('/director', [\App\Http\Controllers\DirectorController::class, 'dashboard'])->name('director.dashboard');
Route::post('/director/sign/{id}', [\App\Http\Controllers\DirectorController::class, 'signOrder'])->name('director.sign');
Route::post('/director/refuse/{id}', [\App\Http\Controllers\DirectorController::class, 'refuseOrder'])->name('director.refuse');
