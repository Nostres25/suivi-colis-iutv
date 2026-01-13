<?php

use Illuminate\Support\Facades\Route;
use \App\Services\ImagePreprocessor;

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
    Route::get('/test-ocr', function () {
        $preprocessor = new ImagePreprocessor;
        $ocrService = new \App\Services\TesseractOcrService($preprocessor);

        // Accepte test.jpg ou test.png
        $testImage = public_path('test.jpg');
        if (! file_exists($testImage)) {
            $testImage = public_path('test.png');
        }

        if (! file_exists($testImage)) {
            return "<h2 style='color: orange;'>⚠️ Aucune image trouvée</h2>
                    <p>Placez une capture d'écran de votre devis dans <code>public/test.jpg</code> ou <code>public/test.png</code></p>
                    <p>Format recommandé : PNG pour meilleure qualité OCR</p>";
        }

        $result = $ocrService->extractTextFromEtiquette($testImage);

        // Affichage du résultat
        if ($result['success']) {
            $ex = $result['extracted'] ?? [];

            return '<h2>✅ Extraction réussie</h2>
        <p><strong>N° colis :</strong> '.($ex['numero_colis'] ?: '—').'</p>
        <p><strong>Réf client :</strong> '.($ex['reference_client'] ?: '—').'</p>
        <p><strong>Destinataire :</strong> '.($ex['destinataire_nom'] ?: '—').'</p>
        <p><strong>Adresse :</strong> '.($ex['destinataire_adresse'] ?: '—').'</p>
        <p><strong>Expéditeur :</strong> '.($ex['expediteur_nom'] ?: '—').'</p>
        <p><strong>Poids :</strong> '.($ex['poids'] ?: '—').' kg</p>
        <p><strong>Date :</strong> '.($ex['date_livraison'] ?: '—').'</p>
        <p><strong>Nombre colis :</strong> '.($ex['nombre_colis'] ?: '—').'</p>
        <p><strong>Confiance :</strong> '.$result['confidence'].'%</p>
        <p><strong>Temps :</strong> '.$result['processing_time'].' ms</p>';
        } else {
            return "<h1>❌ Erreur d'extraction</h1>
            <p><strong>Message :</strong> {$result['error']}</p>
            <p>Conseil : Essayez avec une image plus nette !</p>
            <a href='/test-ocr'>🔄 Réessayer</a>";
        }
    });
}
