<?php
use App\Http\Controllers\CASController;

Route::get('/cas/login', [CASController::class, 'casLogin'])
    ->name('cas.login');