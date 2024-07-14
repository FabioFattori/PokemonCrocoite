<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gym>
 */
class GymFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "position_id" => \App\Models\Position::inRandomOrder()->first()->id,
            "zone_id" => \App\Models\Zone::inRandomOrder()->first()->id,
        ];
    }
}
