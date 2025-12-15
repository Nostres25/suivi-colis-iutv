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
        // Get values of ENUM column (ex: etats) with app:
        // SELECT COLUMN_TYPE
        // FROM information_schema.COLUMNS
        // WHERE TABLE_SCHEMA = 'nom_de_votre_base'
        //   AND TABLE_NAME = 'nom_de_votre_table'
        //   AND COLUMN_NAME = 'nom_de_votre_colonne';
        //
        // Get values of ENUM column (ex: etats) with terminal:
        // SELECT
        //     SUBSTRING(COLUMN_TYPE, 6, LENGTH(COLUMN_TYPE) - 6) AS valeurs_enum
        // FROM information_schema.COLUMNS
        // WHERE TABLE_SCHEMA = 'nom_de_votre_base'
        //     AND TABLE_NAME = 'nom_de_votre_table'
        //     AND COLUMN_NAME = 'nom_de_votre_colonne';
        Schema::create('commande', function (Blueprint $table) {
            $table->id('id_commande');
            $table->string('num_commande')->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->foreignId('id_fournisseur')->nullable()->constrained('fournisseur', 'id_fournisseur')->nullOnDelete();
            $table->decimal('cout', 12, 2)->nullable();
            $table->string('num_devis')->unique();
            $table->string('chemin_devis')->nullable();
            $table->string('chemin_bon_de_commande')->nullable();
            $table->string('chemin_de_livraison')->nullable();
            $table->enum('etat', [ // états possibles de la commande (triés dans l'ordre) :

                'BROUILLON', // enregistré à l'état de brouillon. Affiché seulement pour le demandeur

                'DEVIS', // à l'état de devis ; en attente d'un bon de commande (première étape)

                'DEVIS_REFUSE', // à l'état de devis ; l'éditeur de bon de commande a refusé de faire un bon de commande

                'BON_DE_COMMANDE_NON_SIGNE', // à l'état de bon de commande ; doit être signé par le directeur

                'BON_DE_COMMANDE_REFUSE', // à l'état de bon de commande ; le directeur a refusé de signer

                'BON_DE_COMMANDE_SIGNE', // à l'état de bon de commande signé ; en attente d'envoi du bon signé de commande au fournisseur

                'COMMANDE', // à l'état de bon de commande signé ; commmandé sans réponse, en attente de réponse du fournisseur

                'COMMANDE_REFUSEE', // à l'état de bon de commande signé ; commande refusée par le fournisseur

                'COMMANDE_AVEC_REPONSE', // à l'état de bon de commande signé ; le fournisseur a répondu favorablement à la commande. (Peut fournir le délai de livraison)

                'PARTIELLEMENT_LIVRE', // le demandeur à signalé que certains colis ont été livrés, et que d'autres sont manquants.

                'SERVICE_FAIT', // = terme utilisé par le demandeur pour signaler que la commande a été totalement livrée ; en attente de paiment par le service financier

                'LIVRE_ET_PAYE', // commande payée par le service financié (dernière étape)

                'ANNULE', // La commande a été annulée par le demandeur à n'importe quelle étape
            ])->default('BROUILLON');
        });

        Schema::create('colis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_colis')->autoIncrement();
            $table->foreignId('id_commande')->constrained('commande', 'id_commande')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('label');
            $table->decimal('cout', 12, 2)->nullable();
            $table->date('date_prevue_livraison')->nullable();
            $table->dateTime('date_reception')->nullable();

            $table->primary(['id_colis', 'id_commande']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colis');
        Schema::dropIfExists('commande');
    }
};
