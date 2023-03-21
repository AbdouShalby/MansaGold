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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100')->nullable();
            $table->string('email', '100')->unique()->nullable();
            $table->string('password', '100')->nullable();
            $table->bigInteger('phone')->unique()->nullable();
            $table->string('token', 64)->unique()->nullable();
            $table->string('country', '2')->nullable();
            $table->boolean('status')->default(0);
            $table->string('user_avatar')->nullable();
            $table->smallInteger('role')->default(0);
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
