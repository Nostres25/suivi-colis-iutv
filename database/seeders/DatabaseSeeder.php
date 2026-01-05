<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

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
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                    PermissionValue::ADMIN,
                ],
                'is_department' => false,
            ],
            [
                'name' => 'Responsable colis',
                'id' => 2,
                'description' => 'S\'occupe de livrer les colis aux départements respectifs.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => false,
            ],
            [
                'name' => 'Service financier',
                'id' => 3,
                'description' => 'S\'occupe de la liste des fournisseurs valides, des bons de commandes et de payer le fournisseur.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => false,
            ],
            [
                'name' => 'Département Info',
                'id' => 4,
                'description' => 'Membre du département informatique.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => true,
            ],
            [
                'name' => 'Département GEA',
                'id' => 5,
                'description' => 'Membre du département GEA.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => true,
            ],
            [
                'name' => 'Département CJ',
                'id' => 6,
                'description' => 'Membre du département CJ.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => true,
            ],
            [
                'name' => 'Département GEII',
                'id' => 7,
                'description' => 'Membre du département GEII.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => true,
            ],
            [
                'name' => 'Département RT',
                'id' => 8,
                'description' => 'Membre du département réseaux et télécommunications.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => true,
            ],
            [
                'name' => 'Département SD',
                'id' => 9,
                'description' => 'Membre du département sciences des données.',
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => true,
            ],
            [
                'name' => 'Directeur IUT',
                'id' => 10,
                'description' => "Directeur de l'IUT. Son rôle est de signer les bons de commandes",
                'permissions' => [
                    PermissionValue::CONSULTER_TOUTES_COMMANDES,
                ],
                'is_department' => false,
            ],
        ]);

        $roles = $roles->sort(function ($role1, $role2) {
            return $role1['id'] - $role2['id'];
        });
        Role::upsert($roles->map(function ($role) {
            return ['name' => $role['name'], 'description' => $role['description'], 'is_department' => $role['is_department']];
        })->toArray(), uniqueBy: ['name'], update: ['description', 'is_department']);

        $permissions = PermissionValue::cases();
        sort($permissions);
        $permissionElements = [];
        foreach ($permissions as $permission) {
            $permissionElements[] = ['name' => $permission];
        }
        DB::table('permissions')->upsert($permissionElements, uniqueBy: ['name']);

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
