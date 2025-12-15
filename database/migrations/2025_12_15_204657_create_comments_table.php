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
        Schema::create('commentaire', function (Blueprint $table) {
            $table->id('id_commentaire');
            $table->text('texte');
            $table->dateTime('date_envoi');
            $table->dateTime('date_modification')->nullable();
            $table->foreignId('id_auteur')->nullable()->constrained('utilisateur', 'id_utilisateur')->nullOnDelete();
        });

        Schema::create('commentaire_commande', function (Blueprint $table) {
            $table->foreignId('id_commande')->constrained('commande', 'id_commande')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_role')->constrained('role', 'id_role')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['id_commande', 'id_role']);
        });
    }

    /*
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaire_commande');
        Schema::dropIfExists('commentaire');

    }
};
