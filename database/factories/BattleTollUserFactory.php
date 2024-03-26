<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BattleTool;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BattleTollUser>
 */
class BattleTollUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'battle_toll_id' => BattleTool::first()->id,
            'user_id' => User::first()->id,
            'amount' => $this->faker->randomNumber(1,100),
        ];
    }
}
