<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Log;

class TesseractOcrService
{
    protected ImagePreprocessor $preprocessor;
    
    public function __construct(ImagePreprocessor $preprocessor)
    {
        $this->preprocessor = $preprocessor;
    }
    
    /**
     * Extrait le texte d'une étiquette de colis
     */
    public function extractTextFromEtiquette(string $imagePath): array
    {
        $startTime = microtime(true);
        
        try {
            // Prétraitement de l'image
            if (config('ocr.enable_preprocessing')) {
                $processedPath = $this->preprocessor->prepareForOcr($imagePath);
                $processedPath = $this->preprocessor->autoRotate($processedPath);
            } else {
                $processedPath = $imagePath;
            }
            
            // OCR avec Tesseract
            $tesseract = new TesseractOCR($processedPath);
            $tesseract->executable(config('ocr.tesseract_path'));
            
            // Configuration optimale pour étiquettes
            $tesseract
                ->lang('fra', 'eng')                    // Français en priorité + anglais pour les codes/mots mixtes
                ->psm(6)                                // PSM 6 = Assume a single uniform block of text → très efficace pour les bons structurés
                ->oem(3)                                // Engine mode 3 = LSTM + legacy (meilleur équilibre précision/vitesse en 2025-2026)
                ->dpi(300)                              // Force la résolution à 300 DPI (essentiel pour les petites polices)
                ->config('preserve_interword_spaces', '1')  // Garde les espaces entre mots (important pour les adresses et références)
                ->config('tessedit_char_whitelist', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzÀÂÄÇÉÈÊËÎÏÔÖÙÛÜàâäçéèêëîïôöùûü -/.,:°()\'"')  // Liste français
                ->config('user_defined_dpi', '300')     // Renforce la détection DPI
                ->config('tessedit_do_invert', '0');    // Évite d’inverser les couleurs si binarisation déjà faite
            $text = $tesseract->run();
             
            // Nettoyage du texte
            $text = $this->cleanText($text);
            
            $confidence = $this->estimateConfidence($text);
            $processingTime = round((microtime(true) - $startTime) * 1000);
            
            // Nettoyage
            if ($processedPath !== $imagePath) {
                $this->preprocessor->cleanup($processedPath);
            }
            
            Log::info("OCR réussi", [
                'confidence' => $confidence,
                'time_ms' => $processingTime,
                'text_length' => strlen($text)
            ]);
            
        $extracted = $this->parseBonLivraison($text);

        return [
            'success' => true,
            'text' => $text,
            'extracted' => $extracted,
            'confidence' => $confidence,
            'processing_time' => $processingTime,
            'method' => 'tesseract'
        ];

            
        } catch (\Exception $e) {
            Log::error("Erreur OCR : " . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'text' => '',
                'confidence' => 0
            ];
        } 
    }
    
    /**
     * Nettoie le texte extrait
     */
    protected function cleanText(string $text): string
    {
        $text = preg_replace('/\s+/', ' ', $text);
        $text = preg_replace('/[\x00-\x1F\x7F]/', '', $text);
        return trim($text);
    }
    
private function parseBonLivraison(string $text): array
{
    $data = [
        'numero_colis' => '',
        'reference_client' => '', //Optionnel 
        'destinataire_nom'=> '',
        'destinataire_adresse' => '',
        'destinataire_cp_ville' => '',
        'destinataire_telephone' => '',
        'expediteur_nom' => '',
        'expediteur_adresse' => '',
        'expediteur_telephone' => '',
        'poids' => '',
        'date_livraison' => '',
        'nombre_colis' => '',
    ];

    // N° de colis (formats courants : 6M..., 13M..., 01..., GM..., etc.)
    if (preg_match('/(?:N°\s*(?:de\s*)?colis\s*[:=]?\s*|Référence\s*du\s*colis\s*[:=]?\s*)([A-Z0-9]{11,30})/i', $text, $m)) {
        $data['numero_colis'] = trim($m[1]);
    } elseif (preg_match('/\b(?:6M|GM|01|13M)[A-Z0-9]{8,}\b/', $text, $m)) {
        $data['numero_colis'] = $m[0];
    }

    // Référence client / Réf client
    if (preg_match('/(?:Réf\s*(?:client|cli|clientèle)\s*[:=]?\s*|R[ée]f[ée]rence\s*client\s*[:=]?\s*)([A-Z0-9\-]{6,20})/i', $text, $m)) {
        $data['reference_client'] = trim($m[1]);
    }

    // Destinataire nom + adresse (multi-lignes)
    if (preg_match('/Destinataire\s*:\s*([\w\s\.\'-]+?)\s*(\d{1,4}\s+[^,]+?,\s*\d{5}\s+[A-Z][a-zA-Z\s\-]+)/i', $text, $m)) {
        $data['destinataire_nom']     = trim($m[1]);
        $data['destinataire_adresse'] = trim($m[2]);
    }

    // Téléphone destinataire si présent
    if (preg_match('/(?:T[ée]l\.?|Portable|Tél\s*:\s*)(\+33\s?\d{1}\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}|0[1-9]\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2})/i', $text, $m)) {
        $tel = trim($m[1]);
        // On considère que le tel le plus bas dans le document est souvent destinataire
        if (stripos($text, 'Destinataire') < stripos($text, 'Exp') || stripos($text, 'Destinataire') === false) {
            $data['destinataire_telephone'] = $tel;
        } else {
            $data['expediteur_telephone'] = $tel;
        }
    }

    // Expéditeur (nom + adresse + tél) 
    if (preg_match('/Exp[ée]diteur\s*[:=]?\s*([^:]+?)(?:\s*(?:Adresse|Tél|Tel|Portable)\s*[:=]?\s*)?([\w\s\.,\-]+(?:\d{5}\s+[A-Z][a-zA-Z\s\-]+)?)(?:\s*T[ée]l\.?\s*:\s*)?(\+33\s?\d{1}\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}|0[1-9]\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2})?/is', $text, $m)) {
    $data['expediteur_nom']     = trim($m[1]);
    $data['expediteur_adresse'] = trim($m[2]);
    if (!empty($m[3])) { 
        $data['expediteur_telephone'] = trim($m[3]);
    }
    } elseif (preg_match('/(Building|Site|Comptoir|Maison|Company)[^:]+?(?:\s*Tél\s*\.?\s*:\s*)?(\+33\s?\d{1}\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}|0[6-7]\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2})/i', $text, $m)) {
    $data['expediteur_nom']       = trim($m[1]);
    $data['expediteur_telephone'] = trim($m[2]);
    }

    // Poids (formats : 3,5 kg, 35 kg, 1,00 kg...)
    if (preg_match('/Poids\s*[:=]?\s*(\d{1,3}(?:,\d{1,2})?)\s*kg/i', $text, $m)) {
        $data['poids'] = $m[1];
    }

    // Date de livraison / édition
    if (preg_match('/Date\s*[:=]?\s*(\d{4}-\d{2}-\d{2}|\d{2}\/\d{2}\/\d{4})/i', $text, $m)) {
        $data['date_livraison'] = $m[1];
    }

    // Nombre de colis
    if (preg_match('/Nombre\s*(?:de\s*)?colis\s*[:=]?\s*(\d+)/i', $text, $m)) {
        $data['nombre_colis'] = $m[1];
    }

    return $data;
}

    /**
     * Estime la confiance du résultat OCR, si lecture fiable ou non
     */
protected function estimateConfidence(string $text): int
    {
        $confidence = 100;
        
        if (strlen($text) < 20) $confidence -= 40;
        if (preg_match('/[^\x20-\x7E\xC0-\xFF]/', $text)) $confidence -= 25;
        
        $wordCount = str_word_count($text);
        if ($wordCount < 5) $confidence -= 30;
        
        // Bonus si mots-clés trouvés
        $keywords = ['commande', 'destinataire', 'adresse', 'livraison', 'colis'];
        foreach ($keywords as $keyword) {
            if (stripos($text, $keyword) !== false) $confidence += 5;
        }
        
        return max(0, min(100, $confidence));
    }
}