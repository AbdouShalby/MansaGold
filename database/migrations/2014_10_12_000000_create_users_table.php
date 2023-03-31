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
            $table->string('phone', '50')->unique()->nullable();
            $table->string('token', '64')->unique()->nullable();
            $table->string('country', '2')->nullable();
            $table->boolean('status')->default(0);
            $table->string('user_avatar')->nullable();
            $table->tinyInteger('role')->default(0);
            $table->rememberToken()->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'mansa@admin.com', 'password' => md5('secret'), 'token' => 'mansaadmin', 'status' => '1', 'role' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
