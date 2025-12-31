<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

// Permissions
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
enum Permission: int
{
    case CONSULTER_COMMANDES = 2;
    case CONSULTER_SES_COMMANDES = 3;
    case CREER_COMMANDES = 4;
    case MODIFIER_COMMANDES = 5;
    case AJOUTER_BON_DE_LIVRAISON = 6;

    case NOTES_ET_COMMENTAIRES = 7;
    case DEMANDER_AJOUT_FOURNISSEUR = 8;
    case CONSULTER_LISTE_FOURNISSEURS = 9;
    case GERER_FOURNISSEUR = 10;
    case GERER_BONS_DE_COMMANDES = 11;
    case PAYER_FOURNISSEUR = 12;

    case ADMIN = 1;
}
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Données par défaut générales

        // Rôles par défaut-
        $roles = collect([
            [
                'name' => 'Administrateur BD',
                'id' => 1,
                'description' => 'Accès total à la base de données.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Responsable colis',
                'id' => 2,
                'description' => 'S\'occupe de livrer les colis aux départements respectifs.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Service financier',
                'id' => 3,
                'description' => 'S\'occupe de la liste des fournisseurs valides, des bons de commandes et de payer le fournisseur.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Département Info',
                'id' => 4,
                'description' => 'Membre du département informatique.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Département GEA',
                'id' => 5,
                'description' => 'Membre du département GEA.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Département CJ',
                'id' => 6,
                'description' => 'Membre du département CJ.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Département GEII',
                'id' => 7,
                'description' => 'Membre du département GEII.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Département RT',
                'id' => 8,
                'description' => 'Membre du département réseaux et télécommunications.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
            [
                'name' => 'Département SD',
                'id' => 9,
                'description' => 'Membre du département sciences des données.',
                'permissions' => [
                    Permission::CONSULTER_COMMANDES,
                ],
            ],
        ]);

        $roles = $roles->sort(function ($role1, $role2) {
            return $role1['id'] - $role2['id'];
        });

        //        $roles = [
        //            'Administrateur BD' => [
        //                'description' => 'Accès total à la base de données.',
        //                'permissions' => [],
        //            ],
        //            'Responsable colis' => [
        //                'description' => 'S\'occupe de livrer les colis aux départements respectifs.',
        //                'permissions' => [],
        //            ],
        //            'Service financier' => [
        //                'description' => 'S\'occupe de la liste des fournisseurs valides, des bons de commandes et de payer le fournisseur.',
        //                'permissions' => [],
        //            ],
        //            'Département Info' => [
        //                'description' => 'Membre du département informatique.',
        //                'permissions' => [],
        //            ],
        //            'Département GEA' => [
        //                'description' => 'Membre du département GEA.',
        //                'permissions' => [],
        //            ],
        //            'Département CJ' => [
        //                'description' => 'Membre du département CJ.',
        //                'permissions' => [],
        //            ],
        //            'Département GEII' => [
        //                'description' => 'Membre du département GEII.',
        //                'permissions' => [],
        //            ],
        //            'Département RT' => [
        //                'description' => 'Membre du département réseaux et télécommunications.',
        //                'permissions' => [],
        //            ],
        //            'Département SD' => [
        //                'description' => 'Membre du département sciences des données.',
        //                'permissions' => [],
        //            ],
        //        ];

        //        $roleElements = [];
        //        foreach ($roles as $role) {
        //            $roleElements[] = ['label' => key($role), 'description' => $role['description']];
        //        }
        Role::upsert($roles->map(function ($role) {
            return ['name' => $role['name'], 'description' => $role['description']];
        })->toArray(), uniqueBy: ['name'], update: ['description']);

        //        $permissions = [
        //            ['label' => 'Consulter toutes les commandes'],
        //            ['label' => 'Consulter ses commandes'],
        //            ['label' => 'Créer des commandes'],
        //            ['label' => 'Modifier des commandes'],
        //            ['label' => 'Ajouter un bon de livraison'],
        //
        //            ['label' => 'Notes et commentaires'],
        //
        //            ['label' => 'Demander l\'ajout d\'un fournisseur'],
        //            ['label' => 'Consulter la liste des fournisseurs'],
        //
        //            ['label' => 'Gérer les fournisseurs'],
        //            ['label' => 'Gérer les bons de commande'],
        //            ['label' => 'Payer les fournisseurs'],
        //
        //            ['label' => 'Admin'],
        //        ];

        $permissions = Permission::cases();
        sort($permissions);
        $permissionElements = [];
        foreach ($permissions as $permission) {
            $permissionElements[] = ['label' => $permission];
        }
        DB::table('permissions')->upsert($permissionElements, uniqueBy: ['label']);

        // Attribution de permissions par défaut
        $permission_roleElements = [];
        $i = 1;
        foreach ($roles as $role) {
            foreach ($role['permissions'] as $permission) {

                $permission_roleElements[] = ['permission_id' => $permission, 'role_id' => $i];
            }
            $i++;
        }

        if (! empty($permission_roleElements)) {
            DB::table('permission_role')->upsert($permission_roleElements, uniqueBy: ['permission_id', 'role_id']);
        }

        // Addition seeders

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
