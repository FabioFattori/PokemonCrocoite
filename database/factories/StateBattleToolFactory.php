<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StateBattleTool>
 */
class StateBattleToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'battle_tool_id' => function (){
                return \App\Models\BattleTool::factory()->create()->id;
            },
            'state_id' => function (){
                return \App\Models\State::factory()->create()->id;
            }
        ];
    }
}
