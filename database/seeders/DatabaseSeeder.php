<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BattleTollNpc;
use App\Models\BattleTollUser;
use App\Models\BattleTool;
use App\Models\Box;
use App\Models\Exemplary;
use App\Models\Gender;
use App\Models\Gym;
use App\Models\MnMt;
use App\Models\Move;
use App\Models\Nature;
use App\Models\Npc;
use App\Models\Pokemon;
use App\Models\Position;
use App\Models\Rarity;
use App\Models\State;
use App\Models\StateBattleTool;
use App\Models\StateExemplary;
use App\Models\StoryTool;
use App\Models\Team;
use App\Models\Type;
use App\Models\User;
use App\Models\Zone;
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
        
        $this->seedRarity();
        $this->seedTypes();
        $this->naturesSeed();
        $this->genderSeed();
        $this->statesSeed();
        //create 20 pokemon
        Pokemon::factory(30)->create();
        User::factory(10)->create();
        Type::all()->each(function(Type $type){            
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
            $type->effectivenessOnAttack()->attach($type->id, [
                'multiplier' => rand(0, 3),
                'defending_type_id' => Type::inRandomOrder()->first()
            ]);
        });
        User::all()->each(function(User $user){
            $user->boxes()->saveMany(Box::factory(10)->make());
            //create a team for each user
            $user->team()->save(Team::make([
                'date' => now()
            ]));
        });
        Pokemon::all()->each(function (Pokemon $pokemon) {
            $type1 = Type::inRandomOrder()->first();
            $pokemon->types()->attach($type1);
            if(rand(0, 1)){
                $pokemon->types()->attach(Type::whereNot("id", $type1->id)->inRandomOrder()->first());
            }
        });        
        Position::factory(10)->create()->each(function(Position $position){
            $position->zones()->save(Zone::factory()->make());
        });
        //can be found logic
        Zone::all()->each(function(Zone $zone){
            collect(range(1, 10))->each(function($i) use ($zone){
                $zone->pokemons()->attach(Pokemon::inRandomOrder()->first());
            });
        });

        //each user encountered 10 pokemons
        User::all()->each(function(User $user){
            for ($i=0; $i < 10; $i++) { 
                $user->pokemonsEncountered()->attach(['pokemon_id' => Pokemon::inRandomOrder()->first()->id, 'zone_id' => Zone::inRandomOrder()->first()->id, 'date' => now()]);
            }
        });

        //create 10 mnMt
        $mnMtI = 1;
        Move::all()->each(function(Move $move)use(&$mnMtI){
            $uneOrZero = rand(0, 1);
            if($uneOrZero){
                $move->mnMt()->saveMany([
                    "number" => $mnMtI,
                    "description" => "Lorem Ipsum"
                ]);
                $mnMtI++;

                //give this to some user
                $users = rand(1, 3);
                for ($i = 0; $i < $users; $i++) {
                    User::inRandomOrder()->first()->mnMt()->attach($move->mnMt()->first(), ['quantity' => rand(1, 10)]);
                }
            }

            //add 5 can learn from mn mt
            for ($i=0; $i < 5; $i++) { 
                $move->canLearnFromMachine()->attach(Pokemon::inRandomOrder()->first());
            }
        });

        //create some gym first create the position than the gym
        $gymNumber = 8;
        Position::factory($gymNumber)->create()->each(function(Position $position){
            Gym::make([
                'zone_id' => Zone::inRandomOrder()->first()->id,
                'position_id' => $position->id
            ]);
        });

        $this->seedNpc();

        //create story tools

        $storyTools = [
            'Pokeball',
            'Greatball',
            'Ultraball',
            'Masterball',
            'Message',
            'Great Message',
            'Ultra Message',
            'Master Message',
        ];

        foreach($storyTools as $tool){
            $storyTool = StoryTool::create([
                'name' => $tool,
                'description' => 'Lorem Ipsum'
            ]);

            //assign it some user
            User::inRandomOrder()->first()->storyTool()->attach($storyTool, ['quantity' => rand(1, 10)]);
        }

        //battle tools
        $battleTools = [
            'Potion',
            'Super Potion',
            'Hyper Potion',
            'Max Potion',
            'Revive',
            'Max Revive',
            'Antidote',
            'Burn Heal',
            'Ice Heal',
            'Awakening',
            'Paralyze Heal',
            'Full Heal',
            'Full Restore',
            'X Attack',
        ];

        foreach($battleTools as $tool){
            $battleTool = BattleTool::create([
                'name' => $tool,
                'description' => 'Lorem Ipsum',
                'healthRecovery' => rand(1, 100)
            ]);

            //assign it some user
            User::inRandomOrder()->first()->battleTool()->attach($battleTool, ['amount' => rand(1, 10)]);
            //assign it to a NPC
            Npc::inRandomOrder()->first()->battleTool()->attach($battleTool, ['amount' => rand(1, 10)]);

            $oneOrZero = rand(0, 1);
            if($oneOrZero){
                //add state
                $battleTool->states()->attach(["state_id" => State::inRandomOrder()->first()->id]);
            }
        }

        //create 10 or 20 exemplaries for each pokemon
        Pokemon::all()->each(function(Pokemon $pokemon){
            for ($i=0; $i < rand(10, 20); $i++) { 
                $exemplary = $pokemon->exemplary()->save(Exemplary::factory()->make());
                $thirtyPercent = rand(0, 100) < 30;
                if($thirtyPercent){
                    $exemplary->states()->attach(State::inRandomOrder()->first());
                }

                //give them 3 or 4 move
                $moveNumber = rand(3, 4);
                for ($i=0; $i < $moveNumber; $i++) { 
                    $exemplary->move()->attach(Move::inRandomOrder()->first());
                }
            }
        });
    }

    private function adminSeed(){
        Admin::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
    }

    private function seedRarity()
    {
        // Define the rarities and their corresponding quantities
        $rarities = [
            ['name' => 'Common'],
            ['name' => 'Uncommon'],
            ['name' => 'Rare'],
            ['name' => 'Legendary'],
        ];

        // Loop through each rarity and create records in the database
        $rarities = collect();
        foreach ($rarities as $rarityData) {
            $rarities->push(Rarity::create($rarityData));            
        }
    }

    private function seedPokemon(){
        $common = Rarity::where('name', 'Common')->first()->get("id");
        $uncommon = Rarity::where('name', 'Uncommon')->first()->get("id");
        $rare = Rarity::where('name', 'Rare')->first()->get("id");
        $legendary = Rarity::where('name', 'Legendary')->first()->get("id");
        Pokemon::create(['name' => 'Bulbasaur', 'rarity_id' => $uncommon]);
        Pokemon::create(['name' => 'Ivysaur', 'rarity_id' => $rare]);
        Pokemon::create(['name' => 'Venusaur', 'rarity_id' => $legendary]);
        Pokemon::create(['name' => 'Charmander', 'rarity_id' => $uncommon]);
        Pokemon::create(['name' => 'Charmeleon', 'rarity_id' => $rare]);
        Pokemon::create(['name' => 'Charizard', 'rarity_id' => $legendary]);
        Pokemon::create(['name' => 'Squirtle', 'rarity_id' => $uncommon]);
        Pokemon::create(['name' => 'Wartortle', 'rarity_id' => $rare]);
        Pokemon::create(['name' => 'Blastoise', 'rarity_id' => $legendary]);
        Pokemon::create(['name' => 'Caterpie', 'rarity_id' => $common]);
        Pokemon::create(['name' => 'Metapod', 'rarity_id' => $uncommon]);
        Pokemon::create(['name' => 'Butterfree', 'rarity_id' => $rare]);
    }

    private function seedTypes(){
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

    private function userSeed(){
        User::factory(10)->create();
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

    private function seedNpc(){
        $npcs = [
            'Brock',
            'Misty',
            'Lt. Surge',
            'Erika',
            'Koga',
            'Sabrina',
            'Blaine',
            'Giovanni',
            'Lorelei',
            'Bruno',
            'Agatha',
            'Lance',
            'Blue',
            'Red',
            'Silver',
            'Gold',
            'Crystal',
            'Ruby',
            'Sapphire',
            'Emerald',
            'Diamond',
            'Pearl',
            'Platinum',
            'Black',
            'White',
            'Black 2',
            'White 2',
            'X',
            'Y',
            'Sun',
            'Moon',
            'Ultra Sun',
            'Ultra Moon',
            'Sword',
            'Shield'
        ];

        foreach($npcs as $npc){
            $npc = Npc::create([
                'name' => $npc,
                'description' => 'Lorem Ipsum',
                'position_id' => Position::factory()->create()->id,
            ]);

            $oneOrZero = rand(0, 1);
            if($oneOrZero){
                $npc->gym()->attach(Gym::inRandomOrder()->first());
            }
        }
    }

    
}


/*
OK- rarities
OK- pokemon
OK- types
OK- natures
OK- admins
OK positions
OK- users
OK- genders
OK- states
OK- moves
OK- boxes
OK- can_learn_level
OK- effectivness
OK - pokemon_type
OK- zones
OK - can_be_found
OK pokemon_encountereds
OK mn_mts
OK mn_mt_quantity
OK story_tools
OK story_tool_user
OK battle_tools
OK state_battle_tools
OK gyms
OK battle_tool_users
OK npcs
OK battle_tool_npcs
OK can_learn_from
OK exemplaries
OK state_exemplaries
OK exemplary_move

missing new tables
*/