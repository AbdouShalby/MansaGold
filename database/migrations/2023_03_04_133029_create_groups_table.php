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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->smallInteger('current_subscription')->default(0);
            $table->smallInteger('group_max_subscription');
            $table->smallInteger('group_status')->default(0);
            $table->smallInteger('group_gain')->default(3);
            $table->string('group_avatar')->nullable();
            $table->timestamps();
        });

        DB::table('groups')->insert([
            ['group_name' => 'منسا 1', 'group_max_subscription' => 1000, 'group_gain' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['group_name' => 'منسا 2', 'group_max_subscription' => 1000, 'group_gain' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
