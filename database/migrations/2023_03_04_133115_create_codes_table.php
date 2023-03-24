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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('code_key');
            $table->unsignedBigInteger('group_id');
            $table->unsignedInteger('code_balance');
            $table->boolean('code_status')->default(0);
            $table->dateTime('used_at')->nullable();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('cascade');
            $table->index('code_balance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
