<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BattleTool;
use App\Models\Npc;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BattleTollNpc>
 */
class BattleTollNpcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'battle_tool_id' => function () {
                return BattleTool::factory()->create()->id;
            },
            'npc_id' => function () {
                return Npc::factory()->create()->id;
            },
            'amount' => $this->faker->randomNumber(1,100),
        ];
    }
}
