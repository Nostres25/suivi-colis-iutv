<?php

return [

    // Chemin vers Tesseract
    // TODO le chemin /usr/bin/... implique l'installation l'installation à côté du paquet sur la machine. Le paquet doit être installé par composer et utilisé comme tel
    'tesseract_path' => env('TESSERACT_PATH', '/usr/bin/tesseract'),

    // Langues OCR
    'tesseract_languages' => ['fra', 'eng'],

    // Dossier de stockage temporaire TODO créer le dossier automatiquement
    'temp_storage_path' => storage_path('framework/cache/data/ocr'),

    // Dossier des étiquettes uploadées TODO penser à créer les dossiers sinon ça ne marche pas (je crois)
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
