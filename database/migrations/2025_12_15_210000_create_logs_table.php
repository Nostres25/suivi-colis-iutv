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
        Schema::create('modification', function (Blueprint $table) {
            $table->unsignedBigInteger('id_modif')->autoIncrement();
            $table->foreignId('id_commande')->constrained('commande', 'id_commande')->cascadeOnDelete();
            $table->text('texte');
            $table->dateTime('date_action');
            $table->foreignId('id_auteur')->nullable()->constrained('utilisateur', 'id_utilisateur')->nullOnDelete()->cascadeOnUpdate();
            $table->primary(['id_modif', 'id_commande']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modification');
    }
};
