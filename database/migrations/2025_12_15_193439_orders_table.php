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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_num')->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers', 'id')->nullOnDelete();
            $table->decimal('cost', 12, 2)->nullable();
            $table->string('quote_num')->unique();
            $table->string('path_quote')->nullable(); // chemin vers le fichier du devis
            $table->string('path_purchase_order')->nullable(); // chemin vers le fichier du bon de commande signé ou non signé
            $table->string('path_delivery_note')->nullable(); // chemin vers le fichier du bon de livraison
            $table->enum('states', [ // états possibles de la commande (triés dans l'ordre) :

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

        Schema::create('packages', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->foreignId('order_id')->constrained('orders', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('label');
            $table->decimal('cost', 12, 2)->nullable();
            $table->date('date_expected_delivery')->nullable();
            $table->dateTime('date_reception')->nullable();

            $table->primary(['id', 'order_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package');
        Schema::dropIfExists('orders');
    }
};
