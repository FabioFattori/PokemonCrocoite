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
        Schema::table('pokemon', function (Blueprint $table) {
            $table->unsignedBigInteger('rarity_id')->nullable();
            $table->foreign('rarity_id')->references('id')->on('rarities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
