<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Npc>
 */
class NpcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "position_id" => \App\Models\Position::inRandomOrder()->first()->id,
            "gym_id" => rand(0,1) == 1 ? \App\Models\Zone::inRandomOrder()->first()->id : null,
        ];
    }
}
