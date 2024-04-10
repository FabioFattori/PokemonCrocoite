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
            'nature_id' => function (){
                return \App\Models\Nature::factory()->create()->id;
            } ,
            'gender_id' => function (){
                return \App\Models\Gender::factory()->create()->id;
            },
            'holding_tools_id' => function (){
                return \App\Models\BattleTool::factory()->create()->id;
            },
            'box_id' => null,


            
        ];
    }
}
