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
        Schema::create('fournisseur', function (Blueprint $table) {
            $table->id('id_fournisseur');
            $table->string('nom_entreprise')->unique();
            $table->bigInteger('siret', false, true)->unique();
            $table->string('email')->nullable();
            $table->string('numero_tel')->nullable();
            $table->string('nom_contact')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseur');
    }
};
