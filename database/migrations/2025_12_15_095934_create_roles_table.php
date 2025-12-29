<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Roles
        // Service financier, Département, Info, GEA, CJ, GEII, RT, SD, Responsable colis, Administrateur BD

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyText('description');
        });

        DB::table('roles')->insert([
            ['name' => 'Administrateur BD', 'description' => 'Accès total à la base de données.'],
            ['name' => 'Responsable colis', 'description' => 'S\'occupe de livrer les colis aux départements respectifs.'],
            ['name' => 'Service financier', 'description' => 'S\'occupe de la liste des fournisseurs valides, des bons de commandes et de payer le fournisseur.'],
            ['name' => 'Département', 'description' => 'Membre d\'un département pouvant créer des commandes à l\'état de devis'],
            ['name' => 'Info', 'description' => 'Membre du département informatique.'],
            ['name' => 'GEA', 'description' => 'Membre du département GEA.'],
            ['name' => 'CJ', 'description' => 'Membre du département CJ.'],
            ['name' => 'GEII', 'description' => 'Membre du département GEII.'],
            ['name' => 'RT', 'description' => 'Membre du département réseaux et télécommunications.'],
            ['name' => 'SD', 'description' => 'Membre du département sciences des données.'],
        ]);

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('role_id')->constrained('roles', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['user_id', 'role_id']);
        });

        // Permission

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
        });

        // Consulter toutes les commandes      => Pouvoir voir et rechercher toutes les commandes dans le système.
        // Consulter ses commandes             => Pouvoir voir uniquement les commandes appartenant au même département/service.
        // Créer des commandes                 => Pouvoir créer des commandes à l'état de devis.
        // Modifier des commandes              => Pouvoir modifier les informations principales d'une commande.
        // Ajouter un bon de livraison         => Pouvoir marquer les colis respectifs comme livrés et ajouter un bon de livraison.
        // Notes et commentaires               => Pouvoir ajouter des commentaires et modifier la note pour les commandes et les fournisseurs.
        // Demander l'ajout d'un fournisseur   => Pouvoir demander l'ajout d'un fournisseur au service financier.
        // Consulter la liste des fournisseurs => Pouvoir consulter la liste des fournisseurs valides.
        // Gérer les fournisseurs              => Pouvoir ajouter, modifier et valider ou invalider les fournisseurs.
        // Gérer les bons de commande          => Pouvoir ajouter, refuser, modifier et supprimer des bons de commande.
        // Payer les fournisseurs              => Pouvoir marquer les commandes comme payées.
        // Admin                               => Avoir tous les accès et pouvoir gérer la base de données.

        DB::table('permissions')->insert([
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
        ]);

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('permission_id')->constrained('permissions', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');

        Schema::dropIfExists('role_utilisateur');
        Schema::dropIfExists('roles');

    }
};
