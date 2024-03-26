<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BattleTollNpc;
use App\Models\BattleTollUser;
use App\Models\BattleTool;
use App\Models\Box;
use App\Models\Exemplary;
use App\Models\Gender;
use App\Models\Nature;
use App\Models\Npc;
use App\Models\Pokemon;
use App\Models\State;
use App\Models\StateBattleTool;
use App\Models\StateExemplary;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        //create 10 of every model
        Box::factory(10)->create();
        Nature::factory(10)->create();
        Admin::factory(10)->create();
        BattleTool::factory(10)->create();
        Npc::factory(10)->create();
        BattleTollNpc::factory(10)->create();
        BattleTollUser::factory(10)->create();
        Gender::factory(10)->create();
        Pokemon::factory(10)->create();
        State::factory(10)->create();
        StateBattleTool::factory(10)->create();
        Exemplary::factory(10)->create();
        StateExemplary::factory(10)->create();
        
    }
}
