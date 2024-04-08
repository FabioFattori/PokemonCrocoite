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
        Schema::create('can_learn_level', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('level');
            $table->foreignId('pokemon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('move_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('can_learn_level');
    }
};
