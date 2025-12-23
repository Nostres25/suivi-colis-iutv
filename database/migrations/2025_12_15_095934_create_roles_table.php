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

        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nom')->unique();
            $table->tinyText('description');
        });

        DB::table('role')->insert([
            ['nom' => 'Administrateur BD', 'description' => 'Accès total à la base de données.'],
            ['nom' => 'Responsable colis', 'description' => 'S\'occupe de livrer les colis aux départements respectifs.'],
            ['nom' => 'Service financier', 'description' => 'S\'occupe de la liste des fournisseurs valides, des bons de commandes et de payer le fournisseur.'],
            ['nom' => 'Département', 'description' => 'Membre d\'un département pouvant créer des commandes à l\'état de devis'],
            ['nom' => 'Info', 'description' => 'Membre du département informatique.'],
            ['nom' => 'GEA', 'description' => 'Membre du département GEA.'],
            ['nom' => 'CJ', 'description' => 'Membre du département CJ.'],
            ['nom' => 'GEII', 'description' => 'Membre du département GEII.'],
            ['nom' => 'RT', 'description' => 'Membre du département réseaux et télécommunications.'],
            ['nom' => 'SD', 'description' => 'Membre du département sciences des données.'],
        ]);

        Schema::create('role_utilisateur', function (Blueprint $table) {
            $table->foreignId('id_utilisateur')->constrained('utilisateur', 'id_utilisateur')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_role')->constrained('role', 'id_role')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['id_utilisateur', 'id_role']);
        });

        // Permission

        Schema::create('permission', function (Blueprint $table) {
            $table->id('id_permission');
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

        DB::table('permission')->insert([
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
            $table->foreignId('id_role')->constrained('role', 'id_role')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_permission')->constrained('permission', 'id_permission')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['id_role', 'id_permission']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permission');

        Schema::dropIfExists('role_utilisateur');
        Schema::dropIfExists('role');

    }
};
