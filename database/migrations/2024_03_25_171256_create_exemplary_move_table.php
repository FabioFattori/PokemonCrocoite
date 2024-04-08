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
        Schema::create('exemplary_move', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exemplary_id')->constrained()->cascadeOnDelete();
            $table->foreignId('move_id')->constrained()->cascadeOnDelete();
            $table->unique(['exemplary_id', 'move_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exemplary_move');
    }
};
