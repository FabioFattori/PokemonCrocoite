<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zone>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->unique()->city(),
            //length is a random int
            "length" => $this->faker->numberBetween(1, 200),
            //width is a random int
            "width" => $this->faker->numberBetween(1, 200),
        ];
    }
}
