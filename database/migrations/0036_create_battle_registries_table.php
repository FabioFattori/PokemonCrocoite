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
        Schema::create('battle_registries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pokemon1_id')->constrained('exemplaries')->cascadeOnDelete();
            $table->foreignId('pokemon2_id')->constrained('exemplaries')->cascadeOnDelete();
            //1 if winner is pokemon 1, 2 if winner is pokemon 2
            $table->tinyInteger('winner');
            $table->foreignId('battle_id')->constrained('battles')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_registries');
    }
};
