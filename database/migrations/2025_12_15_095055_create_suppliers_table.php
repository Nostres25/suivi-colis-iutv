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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->bigInteger('siret', false, true)->unique();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('contact_name')
                ->nullable()
                ->comment('Nom du contact dans l\'entreprise fournisseur');
            $table->text('note')->nullable();
            $table->boolean('is_valid')
                ->default(false)
                ->comment('Indique s\'il est possible de passer commande à ce fournisseur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
