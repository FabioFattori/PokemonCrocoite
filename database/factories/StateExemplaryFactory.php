<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StateExemplary>
 */
class StateExemplaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exemplary_id' => function (){
                return \App\Models\Exemplary::factory()->create()->id;
            },
            'state_id' => function (){
                return \App\Models\State::factory()->create()->id;
            }
        ];
    }
}
