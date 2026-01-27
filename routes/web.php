<?php

use Illuminate\Support\Facades\Route;
use \App\Services\ImagePreprocessor;
use \App\Http\Controllers\OcrController;

// =============================================
// Routes principales de l'application
// =============================================

Route::get('login', [\App\Http\Controllers\AuthController::class, 'auth']);

Route::get('/', [\App\Http\Controllers\OrderController::class, 'viewOrders']);

// TODO maybe prefer to use "create" instead of "register"
Route::get('orders/new', [\App\Http\Controllers\OrderController::class, 'newOrder']);
Route::post('orders/new', [\App\Http\Controllers\OrderController::class, 'submitNewOrder']);

// =============================================
// Test OCR simple (uniquement en développement local)
// =============================================

if (app()->environment('local')) {
    Route::get('/test-ocr', [OcrController::class, 'show'])->name('ocr.show');
    Route::post('/test-ocr', [OcrController::class, 'extract'])->name('ocr.extract');

    // Ancien test automatique (public/test.jpg ou public/test.png)
    Route::get('/test-ocr-auto', [OcrController::class, 'auto'])->name('ocr.auto');
}
