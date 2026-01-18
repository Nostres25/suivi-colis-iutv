<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Cookie;


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

// Affiche la page de profil et permet de modifier les informations de l'utilisateur
Route::get('/account/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/account/profile', [ProfileController::class, 'update'])->name('profile.update');
