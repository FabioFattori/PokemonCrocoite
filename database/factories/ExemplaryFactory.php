<?php

namespace Database\Factories;

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
            'pokemon_id' => function (){
                return \APP\Models\Pokemon::factory()->create()->id;
            }
            
        ];
    }
}
