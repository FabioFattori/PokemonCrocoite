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
        Schema::create('effectiveness', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attacking_type_id')->constrained('types')->cascadeOnDelete();
            $table->foreignId('defending_type_id')->constrained('types')->cascadeOnDelete();
            $table->float('multiplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('effectiveness');
    }
};
