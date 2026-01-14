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
        Schema::table('orders', function (Blueprint $table) {
             $table->enum('states', [
            'DEVIS_SIGNE',
            'BC_REDIGE',
            'BC_SIGNE',
            'BC_ENVOYE',
            'LIVREE',
            'PAYEE',
            'ANNULEE'
        ])->change();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
             $table->enum('states', [
            'BROUILLON',
            'DEVIS',
            'DEVIS_SIGNE',
            'BC_REDIGE',
            'BC_SIGNE',
            'BC_ENVOYE',
            'PAYEE'
        ])->change();

        });
    }
};
