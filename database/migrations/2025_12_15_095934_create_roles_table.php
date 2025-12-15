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

        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nom')->unique();
            $table->tinyText('description');
        });

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
