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
        $table->string('department')->nullable();
        $table->string('author')->nullable();
        $table->string('title')->nullable();
        $table->string('stateChangedAt')->nullable();
        $table->string('createdAt')->nullable();
    });

    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('department');
            $table->dropColumn('author');
            $table->dropColumn('title');
            $table->dropColumn('stateChangedAt');
            $table->dropColumn('createdAt');

        });
    }
};
