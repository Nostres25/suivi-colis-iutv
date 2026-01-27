<?php

namespace App\Http\Controllers;

use App\Services\TesseractOcrService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OcrController extends Controller
{
    public function show(): View
    {
        // Affiche juste la page avec le formulaire
        return view('ocr');
    }

    public function extract(Request $request, TesseractOcrService $ocrService): View
    {
        // 1) Validation upload (jpg/png uniquement)
        $validated = $request->validate([
            'document' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:10240'], // 10MB
        ]);

        // 2) Stockage temporaire (dans le dossier défini par config/ocr.php)
        $tempDir = config('ocr.temp_storage_path');
        if (!is_dir($tempDir)) {
            @mkdir($tempDir, 0775, true);
        }

        $file = $validated['document'];
        $ext = $file->getClientOriginalExtension();
        $uploadedPath = rtrim($tempDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . uniqid('ocr_upload_') . '.' . $ext;

        // move() => vrai fichier sur disque (pas storage disk)
        $file->move($tempDir, basename($uploadedPath));

        // 3) OCR
        $result = $ocrService->extractTextFromEtiquette($uploadedPath);

        // 4) Nettoyage du fichier uploadé (le service nettoie déjà le "processed" si preprocessing activé)
        if (file_exists($uploadedPath)) {
            @unlink($uploadedPath);
        }

        // 5) Retour vue avec résultat
        return view('ocr', [
            'result' => $result,
        ]);
    }

    public function auto(TesseractOcrService $ocrService)
    {
        // Ancien mode de test : prend public/test.jpg ou public/test.png
        $testImage = public_path('test.jpg');
        if (!file_exists($testImage)) {
            $testImage = public_path('test.png');
        }

        if (!file_exists($testImage)) {
            return view('ocr', [
                'result' => [
                    'success' => false,
                    'error' => "Aucune image trouvée. Ajoutez public/test.jpg ou public/test.png",
                    'text' => '',
                    'confidence' => 0,
                ],
            ]);
        }

        $result = $ocrService->extractTextFromEtiquette($testImage);

        return view('ocr', [
            'result' => $result,
        ]);
    }
}
