<?php

namespace Database\Factories;

use App\Models\BattleTool;
use App\Models\Box;
use App\Models\Gender;
use App\Models\Nature;
use App\Models\Npc;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exemplary>
 */
class ExemplaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'speed' => $this->faker->numberBetween(1, 100),
            'specialDefense' => $this->faker->numberBetween(1, 100),
            'defense' => $this->faker->numberBetween(1, 100),
            'attack' => $this->faker->numberBetween(1, 100),
            'specialAttack' => $this->faker->numberBetween(1, 100),
            'ps' => $this->faker->numberBetween(1, 100),
            'level' => $this->faker->numberBetween(1, 100),
            'catchDate' => $this->faker->date(),            
            'nature_id' => Nature::inRandomOrder()->first()->id,
            'gender_id' => Gender::inRandomOrder()->first()->id,
            'holding_tools_id' => rand(0, 1) ? BattleTool::inRandomOrder()->first()->id : null,
        ];
    }
}
