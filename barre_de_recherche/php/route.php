<?php
use App\Http\Controllers\ColisController;

Route::get('/recherche-colis', [ColisController::class, 'rechercher']);
