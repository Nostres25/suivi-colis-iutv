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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users', 'id')->nullOnDelete();
        });

        Schema::create('comment_order', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained('orders', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('role_id')->constrained('roles', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['order_id', 'role_id']);
        });
    }

    /*
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_order');
        Schema::dropIfExists('comments');

    }
};
