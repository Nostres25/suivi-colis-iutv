<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function Supplier(): View
    {
        // Liste d'exemples de suppliers
        $suppliers = [
            [
                'id' => 1,
                'company_name' => 'Bureau Vallée',
                'siret' => '41234567890123',
                'email' => 'contact@bureau-vallee.fr',
                'phone_number' => '0145678901',
                'contact_name' => 'Marie Dubois',
                'specialite' => 'Papier, Cahiers, Fournitures de bureau',
                'note' => 'Fournisseur fiable, livraison rapide',
                'is_valid' => true,
            ],
            [
                'id' => 2,
                'company_name' => 'Mobilier Pro',
                'siret' => '52345678901234',
                'email' => 'info@mobilier-pro.fr',
                'phone_number' => '0156789012',
                'contact_name' => 'Jean Martin',
                'specialite' => 'Tables, Chaises, Mobilier de bureau',
                'note' => 'Excellent rapport qualité-prix',
                'is_valid' => true,
            ],
            [
                'id' => 3,
                'company_name' => 'TechnoStore',
                'siret' => '63456789012345',
                'email' => 'ventes@technostore.fr',
                'phone_number' => '0167890123',
                'contact_name' => 'Sophie Lambert',
                'specialite' => 'Ordinateurs, Composants informatiques',
                'note' => 'Spécialiste en matériel informatique professionnel',
                'is_valid' => true,
            ],
            [
                'id' => 4,
                'company_name' => 'Data Solutions',
                'siret' => '74567890123456',
                'email' => 'contact@data-solutions.fr',
                'phone_number' => '0178901234',
                'contact_name' => 'Pierre Rousseau',
                'specialite' => 'Disques durs, Stockage, Serveurs',
                'note' => 'Prix compétitifs, bon SAV',
                'is_valid' => true,
            ],
            [
                'id' => 5,
                'company_name' => 'Lumina Électrique',
                'siret' => '85678901234567',
                'email' => 'commandes@lumina-elec.fr',
                'phone_number' => '0189012345',
                'contact_name' => 'Claire Moreau',
                'specialite' => 'Ampoules, Éclairage LED, Matériel électrique',
                'note' => 'Large choix d\'ampoules professionnelles',
                'is_valid' => true,
            ],
            [
                'id' => 6,
                'company_name' => 'Librairie Universitaire',
                'siret' => '96789012345678',
                'email' => 'info@librairie-univ.fr',
                'phone_number' => '0190123456',
                'contact_name' => 'Thomas Bernard',
                'specialite' => 'Livres techniques, Manuels, Documentation',
                'note' => 'Spécialisé dans les ouvrages universitaires',
                'is_valid' => true,
            ],
            [
                'id' => 7,
                'company_name' => 'Office Supplies France',
                'siret' => '12345098765432',
                'email' => 'service@officesupplies.fr',
                'phone_number' => '0145321098',
                'contact_name' => 'Isabelle Petit',
                'specialite' => 'Cahiers, Stylos, Accessoires de bureau',
                'note' => 'Livraison sous 48h, stock important',
                'is_valid' => false,
            ],
        ];

        return view('Supplier', [
            'suppliers' => $suppliers,
        ]);
    }
}