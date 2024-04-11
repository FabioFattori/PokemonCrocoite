<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BattleTollNpc;
use App\Models\BattleTollUser;
use App\Models\BattleTool;
use App\Models\Box;
use App\Models\Exemplary;
use App\Models\Gender;
use App\Models\Move;
use App\Models\Nature;
use App\Models\Npc;
use App\Models\Pokemon;
use App\Models\Rarity;
use App\Models\State;
use App\Models\StateBattleTool;
use App\Models\StateExemplary;
use App\Models\Type;
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
        $this->adminSeed();
        
        $this->raritySeed();
        $this->typeSeed();
        $this->naturesSeed();
        $this->genderSeed();
        $this->statesSeed();
        //create 20 pokemon
        Pokemon::factory(30)->create();
        User::factory(10)->create();
        Type::all()->each(function(Type $type){
            //for each type 10 move
            $type->moves()->saveMany(Move::factory(10)->make());
        });
        Box::factory(10)->create();
        //create 10 can learn at level
        Pokemon::all()->each(function(Pokemon $pokemon){
            //create 10 for each
            for ($i=0; $i < 10; $i++) { 
                $pokemon->canLearnFromLevel()->attach(Move::inRandomOrder()->first(), ['level' => rand(1, 100)]);
                $pokemon->canLearnFromMachine()->attach(Move::inRandomOrder()->first());
            }
        });
        Type::all()->each(function(Type $type){            
            $type->effectivenessOnDefense()->attach($type->id, [
                'multiplier' => rand(0, 3), 
                'attacking_type_id' => Type::inRandomOrder()->first()
            ]);
            $type->effectivenessOnDefense()->attach($type->id, [
                'multiplier' => rand(0, 3),
                'defending_type_id' => Type::inRandomOrder()->first()
            ]);
        });
        

    }

    private function adminSeed(){
        Admin::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
    }

    private function raritySeed(){
        $rarities = [
            'Common',
            'Uncommon',
            'Rare',
            'Very Rare',
            'Legendary'
        ];

        foreach($rarities as $rarity){
            Rarity::create([
                'name' => $rarity
            ]);
        }
    }

    private function typeSeed(){
        $types = [
            'Normal',
            'Fire',
            'Water',
            'Grass',
            'Electric',
            'Ice',
            'Fighting',
            'Poison',
            'Ground',
            'Flying',
            'Psychic',
            'Bug',
            'Ghost',
            'Dark',
            'Dragon',
            'Steel',
            'Fairy'
        ];

        foreach($types as $type){
            Type::create([
                'name' => $type
            ]);
        }
    }

    private function naturesSeed(){
        //pokemon natures, just 10
        $natures = [
            'Hardy',
            'Lonely',
            'Brave',
            'Adamant',
            'Naughty',
            'Bold',
            'Docile',
            'Relaxed',
            'Impish',
            'Lax',
            'Timid'
        ];

        foreach($natures as $nature){
            Nature::create([
                'name' => $nature
            ]);
        }
    }

    private function genderSeed()
    {
        $genders = [
            'male',
            'female'
        ];

        foreach($genders as $gender){
            Gender::create([
                'name' => $gender
            ]);
        }
    }

    private function statesSeed()
    {
        //pokemon states
        $states = [
            'Paralyzed',
            'Burned',
            'Frozen',
            'Poisoned',
            'Asleep',
            'Confused'
        ];

        foreach($states as $state){
            State::create([
                'name' => $state
            ]);
        }
    }

    
}
