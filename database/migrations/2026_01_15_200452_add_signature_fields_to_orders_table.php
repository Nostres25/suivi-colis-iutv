<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Horodatages
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('refused_at')->nullable();
            
            // Clés étrangères vers Users
            $table->unsignedBigInteger('signed_by')->nullable();
            $table->unsignedBigInteger('refused_by')->nullable();
            
            // Si 'amount' n'existe pas encore (à vérifier dans Tinker)
            if (!Schema::hasColumn('orders', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable();
            }

            $table->foreign('signed_by')->references('id')->on('users');
            $table->foreign('refused_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['signed_by']);
            $table->dropForeign(['refused_by']);
            $table->dropColumn(['signed_at', 'refused_at', 'signed_by', 'refused_by', 'amount']);
        });
    }
};