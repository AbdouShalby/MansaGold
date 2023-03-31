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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('lang', 2);
            $table->string('path');
            $table->boolean('status')->default(1);
        });

        DB::table('videos')->insert([
            ['lang' => 'ar', 'path' => 'videos/Mansa_Gold_AR.mp4', 'status' => '1'],
            ['lang' => 'en', 'path' => 'videos/Mansa_Gold_EN.mp4', 'status' => '1'],
            ['lang' => 'fr', 'path' => 'videos/Mansa_Gold_FR.mp4', 'status' => '1'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
