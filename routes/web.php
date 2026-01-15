<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'viewOrders']);
Route::get('suppliers', [\App\Http\Controllers\SupplierController::class, 'viewSuppliers']);

Route::get('/about', [\App\Http\Controllers\AboutController::class, 'about']);
// Only for tests:
// Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);
Route::get('/Supplier', [\App\Http\Controllers\SupplierController::class, 'Supplier']);

Route::get('/service-financier', [OrderController::class, 'serviceFinancier'])->name('service.financier');


Route::put('/orders/{id}/state', [OrderController::class, 'changeState'])->name('orders.changeState');

Route::post('/orders/{id}/upload-quote', [OrderController::class, 'uploadQuote'])
    ->name('orders.uploadQuote');

// Seulement pour les tests sur le serveur de l'IUT
Route::get('/cookies', function (Request $request) {
    dd($request->cookie());
});

Route::get('/logout', function (Request $request) {

    // Cookies à supprimer pour se déconnecter² et rediriger automatiquement vers le CAS avec apache2
    Cookie::queue(Cookie::forget('MOD_AUTH_CAS'));
    Cookie::queue(Cookie::forget('MOD_AUTH_CAS_S'));

    // Oublier l'utilisateur ou/et la session du côté de l'application pour simuler une vraie connection
    Auth::forgetUser();

    dd($request->cookie());
});
