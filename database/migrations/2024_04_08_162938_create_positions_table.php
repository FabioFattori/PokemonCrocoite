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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->integer('x');
            $table->integer('y');            
        });

        //add position to user and zone
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('zones', function (Blueprint $table) {
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();
        });

        //add to NPC
        Schema::table('npcs', function (Blueprint $table) {
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });

        Schema::table('zones', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });
    }
};
