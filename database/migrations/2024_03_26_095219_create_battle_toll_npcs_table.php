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
        Schema::create('battle_toll_npcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battle_toll_id')->references('id')->on("battle_tools")->cascadeOnDelete();
            $table->foreignId('npc_id')->references('id')->on("npcs")->cascadeOnDelete();
            $table->unsignedInteger('amount')->default(1);
        });

        DB::statement("ALTER TABLE battle_toll_npcs ADD CONSTRAINT amount_npc_not_less_than_zero CHECK (amount >= 1 AND amount <= 999)");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_toll_npcs');
    }
};
