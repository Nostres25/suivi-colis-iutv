<?php

return [
        
    // Chemin vers Tesseract
    'tesseract_path' => env('TESSERACT_PATH', '/usr/bin/tesseract'),
    
    // Langues OCR
    'tesseract_languages' => ['fra', 'eng'],
    
    // Dossier de stockage temporaire
    'temp_storage_path' => storage_path('app/ocr-temp'),
    
    // Dossier des étiquettes uploadées
    'etiquettes_storage_path' => public_path('uploads/etiquettes'),
    
    // Seuil de confiance minimum (%)
    'confidence_threshold' => 60,
    
    // Activer le prétraitement avancé
    'enable_preprocessing' => true,

    // Mots-clés pour détection
    'keywords' => [
        'numero_commande' => ['BC', 'Commande', 'N°', 'Numéro', 'Réf', 'Reference'],
        'destinataire' => ['Destinataire', 'À l\'attention de', 'DEST', 'Livraison à'],
        'fournisseur' => ['Expéditeur', 'Envoyé par', 'De la part de', 'From'],
        'service' => ['Service', 'Département', 'Dept', 'IUT'],
    ],
    
];