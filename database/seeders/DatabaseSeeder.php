<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Données par défaut générales

        // ANCIEN CODE
        // // Rôles par défaut
        // $roles = [
        //     ['name' => 'Administrateur BD', 'description' => 'Accès total à la base de données.'],
        //     ['name' => 'Responsable colis', 'description' => 'S\'occupe de livrer les colis aux départements respectifs.'],
        //     ['name' => 'Service financier', 'description' => 'S\'occupe de la liste des fournisseurs valides, des bons de commandes et de payer le fournisseur.'],
        //     ['name' => 'Département Info', 'description' => 'Membre du département informatique.'],
        //     ['name' => 'Département GEA', 'description' => 'Membre du département GEA.'],
        //     ['name' => 'Département CJ', 'description' => 'Membre du département CJ.'],
        //     ['name' => 'Département GEII', 'description' => 'Membre du département GEII.'],
        //     ['name' => 'Département RT', 'description' => 'Membre du département réseaux et télécommunications.'],
        //     ['name' => 'Département SD', 'description' => 'Membre du département sciences des données.'],
        // ];
        // Role::upsert($roles, uniqueBy: ['name'], update: ['description']);

        // // Permissions par défaut:
        // // - Consulter toutes les commandes      => Pouvoir voir et rechercher toutes les commandes dans le système.
        // // - Consulter ses commandes             => Pouvoir voir uniquement les commandes appartenant au même département/service.
        // // - Créer des commandes                 => Pouvoir créer des commandes à l'état de devis.
        // // - Modifier des commandes              => Pouvoir modifier les informations principales d'une commande.
        // // - Ajouter un bon de livraison         => Pouvoir marquer les colis respectifs comme livrés et ajouter un bon de livraison.
        // // - Notes et commentaires               => Pouvoir ajouter des commentaires et modifier la note pour les commandes et les fournisseurs.
        // // - Demander l'ajout d'un fournisseur   => Pouvoir demander l'ajout d'un fournisseur au service financier.
        // // - Consulter la liste des fournisseurs => Pouvoir consulter la liste des fournisseurs valides.
        // // - Gérer les fournisseurs              => Pouvoir ajouter, modifier et valider ou invalider les fournisseurs.
        // // - Gérer les bons de commande          => Pouvoir ajouter, refuser, modifier et supprimer des bons de commande.
        // // - Payer les fournisseurs              => Pouvoir marquer les commandes comme payées.
        // // - Admin                               => Avoir tous les accès et pouvoir gérer la base de données.
        // $permissions = [
        //     ['label' => 'Consulter toutes les commandes'],
        //     ['label' => 'Consulter ses commandes'],
        //     ['label' => 'Créer des commandes'],
        //     ['label' => 'Modifier des commandes'],
        //     ['label' => 'Ajouter un bon de livraison'],

        //     ['label' => 'Notes et commentaires'],

        //     ['label' => 'Demander l\'ajout d\'un fournisseur'],
        //     ['label' => 'Consulter la liste des fournisseurs'],

        //     ['label' => 'Gérer les fournisseurs'],
        //     ['label' => 'Gérer les bons de commande'],
        //     ['label' => 'Payer les fournisseurs'],

        //     ['label' => 'Admin'],
        // ];

        // DB::table('permissions')->upsert($permissions);

        // // Attribution de permissions par défaut
        // DB::table('permission_role')->insert([
        //     ['role_id' => 1, 'permission_id' => 1],

        // ]);

        // Nouvelles données - TODO soit garder ce principe bizarre soit revenir comme avant carr là c'est galère
        // Rôles par défaut-
        $roles = [
            'Administrateur BD' => [
                'description' => 'Accès total à la base de données.',
                'permissions' => [],
            ],
            'Responsable colis' => [
                'description' => 'S\'occupe de livrer les colis aux départements respectifs.',
                'permissions' => [],
            ],
            'Service financier' => [
                'description' => 'S\'occupe de la liste des fournisseurs valides, des bons de commandes et de payer le fournisseur.',
                'permissions' => [],
            ],
            'Département Info' => [
                'description' => 'Membre du département informatique.',
                'permissions' => [],
            ],
            'Département GEA' => [
                'description' => 'Membre du département GEA.',
                'permissions' => [],
            ],
            'Département CJ' => [
                'description' => 'Membre du département CJ.',
                'permissions' => [],
            ],
            'Département GEII' => [
                'description' => 'Membre du département GEII.',
                'permissions' => [],
            ],
            'Département RT' => [
                'description' => 'Membre du département réseaux et télécommunications.',
                'permissions' => [],
            ],
            'Département SD' => [
                'description' => 'Membre du département sciences des données.',
                'permissions' => [],
            ],
        ];

        $roleElements = [];
        foreach ($roles as $role) {
            array_push($roleElements, ['label' => key($role), 'description' => $role['description']]);
        }
        Role::upsert($roleElements, uniqueBy: ['name'], update: ['description']);

        // Permissions par défaut:
        // - Consulter toutes les commandes      => Pouvoir voir et rechercher toutes les commandes dans le système.
        // - Consulter ses commandes             => Pouvoir voir uniquement les commandes appartenant au même département/service.
        // - Créer des commandes                 => Pouvoir créer des commandes à l'état de devis.
        // - Modifier des commandes              => Pouvoir modifier les informations principales d'une commande.
        // - Ajouter un bon de livraison         => Pouvoir marquer les colis respectifs comme livrés et ajouter un bon de livraison.
        // - Notes et commentaires               => Pouvoir ajouter des commentaires et modifier la note pour les commandes et les fournisseurs.
        // - Demander l'ajout d'un fournisseur   => Pouvoir demander l'ajout d'un fournisseur au service financier.
        // - Consulter la liste des fournisseurs => Pouvoir consulter la liste des fournisseurs valides.
        // - Gérer les fournisseurs              => Pouvoir ajouter, modifier et valider ou invalider les fournisseurs.
        // - Gérer les bons de commande          => Pouvoir ajouter, refuser, modifier et supprimer des bons de commande.
        // - Payer les fournisseurs              => Pouvoir marquer les commandes comme payées.
        // - Admin                               => Avoir tous les accès et pouvoir gérer la base de données.
        $permissions = [
            ['label' => 'Consulter toutes les commandes'],
            ['label' => 'Consulter ses commandes'],
            ['label' => 'Créer des commandes'],
            ['label' => 'Modifier des commandes'],
            ['label' => 'Ajouter un bon de livraison'],

            ['label' => 'Notes et commentaires'],

            ['label' => 'Demander l\'ajout d\'un fournisseur'],
            ['label' => 'Consulter la liste des fournisseurs'],

            ['label' => 'Gérer les fournisseurs'],
            ['label' => 'Gérer les bons de commande'],
            ['label' => 'Payer les fournisseurs'],

            ['label' => 'Admin'],
        ];

        DB::table('permissions')->upsert($permissions);

        // Attribution de permissions par défaut
        DB::table('permission_role')->insert([
            ['role_id' => $roles->filter, 'permission_id'],

        ]);

        if (App::environment('local', 'staging', 'testing')) {
            $this->call([
                LocalTestSeeder::class, // données de test
            ]);
        }

        if (App::environment('production')) {
            $this->call([
                ProductionOnlySeeder::class, // données nécessaires en prod seulement
            ]);
        }
    }
}
