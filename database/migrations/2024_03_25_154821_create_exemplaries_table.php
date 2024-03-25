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
            $table->integer('speed');
            $table->integer('specialDefense');
            $table->integer('defense');
            $table->integer('attack');
            $table->integer('specialAttack');
            $table->integer('ps');
            $table->integer('level');
            $table->date('catchDate');
            $table->foreignId('pokemon_id')->constrained()->cascadeOnDelete();
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
