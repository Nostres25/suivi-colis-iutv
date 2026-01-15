<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'viewOrders']);
Route::get('suppliers', [\App\Http\Controllers\SupplierController::class, 'viewSuppliers']);

Route::get('/about', [\App\Http\Controllers\AboutController::class, 'about']);

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

Route::get('/director', [\App\Http\Controllers\DirectorController::class, 'dashboard'])->name('director.dashboard');
Route::post('/director/sign/{id}', [\App\Http\Controllers\DirectorController::class, 'signOrder'])->name('director.sign');
Route::post('/director/refuse/{id}', [\App\Http\Controllers\DirectorController::class, 'refuseOrder'])->name('director.refuse');
