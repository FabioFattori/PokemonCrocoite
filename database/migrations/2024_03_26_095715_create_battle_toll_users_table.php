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
        Schema::create('battle_toll_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battle_toll_id')->references("id")->on("battle_tools")->cascadeOnDelete();
            $table->foreignId('user_id')->references("id")->on("users")->cascadeOnDelete();
            $table->unsignedInteger('amount')->default(1);
        });

        DB::statement("ALTER TABLE battle_toll_users ADD CONSTRAINT amount_user_not_less_than_zero CHECK (amount >= 1 AND amount <= 999)");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_toll_users');
    }
};
