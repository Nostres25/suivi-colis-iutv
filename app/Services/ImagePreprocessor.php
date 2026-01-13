<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;  // Nouveau namespace v3
use Intervention\Image\Laravel\Facades\Image;

class ImagePreprocessor
{
    /**
     * Prépare une image pour l'OCR
     */
    public function prepareForOcr(string $imagePath): string
    {
        try {
            $image = Image::read($imagePath);

            // Redimensionner si trop petite (min 1500px de largeur)
            if ($image->width() < 1500) {
                $image->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Convertir en niveaux de gris
            $image->greyscale();

            // Augmenter le contraste
            $image->contrast(40);

            // Améliorer la netteté
            $image->sharpen(20);

            // Sauvegarder l'image traitée
            $processedPath = config('ocr.temp_storage_path').'/'.uniqid('processed_').'.jpg';
            $image->save($processedPath, 95);


            Log::info("Image prétraitée : $processedPath");

            return $processedPath;

        } catch (\Exception $e) {
            Log::error('Erreur prétraitement image : '.$e->getMessage());
            dd($e);
            throw $e;
        }
    }

    /**
     * Détecte et corrige l'orientation de l'image
     */
    public function autoRotate(string $imagePath): string
    {
        try {
            // Utilise Tesseract pour détecter l'orientation
            $command = config('ocr.tesseract_path')." \"$imagePath\" - --psm 0 2>&1";
            $output = shell_exec($command);

            if (preg_match('/Rotate: (\d+)/', $output, $matches)) {
                $rotation = (int) $matches[1];

                if ($rotation !== 0) {
                    $image = Image::read($imagePath);
                    $image->rotate(-$rotation);
                    $image->save($imagePath);

                    Log::info("Image pivotée de $rotation degrés");
                }
            }

            return $imagePath;

        } catch (\Exception $e) {
            Log::warning('Rotation auto échouée : '.$e->getMessage());

            return $imagePath; // On continue quand même
        }
    }

    /**
     * Nettoie les fichiers temporaires
     */
    public function cleanup(string $filePath): void
    {
        if (file_exists($filePath) && strpos($filePath, 'ocr-temp') !== false) {
            @unlink($filePath);
        }
    }
}
