<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;  // Nouveau namespace v3
use Illuminate\Support\Facades\Log;

class ImagePreprocessor
{
    /**
     * Prépare une image pour l'OCR avec PHP GD natif
     *
     * CETTE MÉTHODE FAIT LE PRÉTRAITEMENT :
     * - Niveaux de gris
     * - Augmentation du contraste
     * - Amélioration de la netteté
     */
    public function prepareForOcr(string $imagePath): string
    {
        try {
            $image = Image::read($imagePath);

            // Redimensionner si trop petit
            if ($image->width() < 1500) {
                $image->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Convertir en niveaux de gris
            $image->greyscale();

            // Augmenter le contraste
            $image->contrast(60);

            // Améliorer la netteté
            $image->sharpen(30);
            $image->blur(1);

            // Sauvegarder l'image traitée
            $processedPath = config('ocr.temp_storage_path') . '/' . uniqid('processed_') . '.jpg';
            $image->save($processedPath, 95);

            Log::info("Image prétraitée : $processedPath");

            return $processedPath;

        } catch (\Exception $e) {
            Log::error("Erreur prétraitement image : " . $e->getMessage());
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
            $command = config('ocr.tesseract_path') . " \"$imagePath\" - --psm 0 2>&1";
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
            Log::warning("Rotation auto échouée : " . $e->getMessage());
            return $imagePath; // On continue quand même
        }
    }


    public function convertPdfToImages(string $pdfPath): array
    {
    $images = [];
    $imagick = new \Imagick();
    $imagick->setResolution(300, 300);  // Haute qualité OCR
    $imagick->readImage($pdfPath);

    foreach ($imagick as $index => $frame) {
        $tempPath = config('ocr.temp_storage_path') . '/' . uniqid('pdf_page_') . '.jpg';
        $frame->setImageFormat('jpg');
        $frame->writeImage($tempPath);
        $images[] = $tempPath;
    }

    $imagick->clear();
    $imagick->destroy();

    return $images;
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
