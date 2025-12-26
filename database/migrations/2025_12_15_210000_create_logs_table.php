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
        Schema::create('logs', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->foreignId('order_id')->constrained('orders', 'id')->cascadeOnDelete();
            $table->text('text');
            $table->dateTime('created_at');
            $table->foreignId('author_id')->nullable()->constrained('users', 'id')->nullOnDelete()->cascadeOnUpdate();
            $table->primary(['id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
