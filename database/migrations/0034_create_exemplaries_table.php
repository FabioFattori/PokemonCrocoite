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
        Schema::create('exemplaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('speed');
            $table->unsignedInteger('specialDefense');
            $table->unsignedInteger('defense');
            $table->unsignedInteger('attack');
            $table->unsignedInteger('specialAttack');
            $table->unsignedInteger('ps');
            $table->unsignedInteger('level');
            $table->foreignId('exemplary_id')->nullable()->constrained()->cascadeOnDelete();     
            $table->foreignId('pokemon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nature_id')->references("id")->on("natures")->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->references('id')->on('teams')->cascadeOnDelete();
            $table->foreignId('npc_id')->nullable()->references('id')->on('npcs')->cascadeOnDelete();
            $table->foreignId('gender_id')->references('id')->on('genders')->cascadeOnDelete();
            $table->foreignId("box_id")->nullable()->references("id")->on("boxes")->cascadeOnDelete();
            $table->foreignId('holding_tools_id')->nullable()->references('id')->on("battle_tools")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exemplaries');
    }
};
