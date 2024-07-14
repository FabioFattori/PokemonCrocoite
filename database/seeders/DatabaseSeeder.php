<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Battle;
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
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
        $this->faker->seed(1111);
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(Rarity::count() < 1)
            $this->seedRarity();
        if(Type::count() < 1)
            $this->seedTypes();
        if(Pokemon::count() < 1)
            $this->seedPokemon();        
        if(Nature::count() < 1)
            $this->seedNature();
        if(User::count() < 1)
            $this->seedUser();
        if(Gender::count() < 1)
            $this->seedGender();
        if(State::count() < 1)
            $this->seedState();
        if(Move::count() < 1)
            $this->seedMoves();
        if(Box::count() < 1)
            $this->seedBoxes();
        if(Zone::count() < 1)
            $this->seedZones();
        if(StoryTool::count() < 1)
            $this->seedStoryTools();
        if(BattleTool::count() < 1)
            $this->seedBattleTools();
        if(Gym::count() < 1)
            $this->seedGyms();
        if(Npc::count() < 1)
            $this->seedNpc();
        if(Team::count() < 1)
            $this->seedTeams();
        if(Exemplary::count() < 1)
            $this->seedExemplary();
        if(Battle::count() < 1)
            $this->seedBattles();
        if(Admin::count() < 1)
            $this->seedAdmin();
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

        foreach ($rarities as $rarityData) {
            Rarity::create($rarityData);
        }
    }

    private function seedPokemon(){
        $common = Rarity::where('name', 'Common')->first()->id;
        $uncommon = Rarity::where('name', 'Uncommon')->first()->id;
        $rare = Rarity::where('name', 'Rare')->first()->id;
        $legendary = Rarity::where('name', 'Legendary')->first()->id;
        
        $Bulbasaur = Pokemon::create(['name' => 'Bulbasaur', 'rarity_id' => $uncommon]);
        $Ivysaur = Pokemon::create(['name' => 'Ivysaur', 'rarity_id' => $rare]);
        $Venusaur = Pokemon::create(['name' => 'Venusaur', 'rarity_id' => $legendary]);
        $Charmander = Pokemon::create(['name' => 'Charmander', 'rarity_id' => $uncommon]);
        $Charmeleon = Pokemon::create(['name' => 'Charmeleon', 'rarity_id' => $rare]);
        $Charizard = Pokemon::create(['name' => 'Charizard', 'rarity_id' => $legendary]);
        $Squirtle = Pokemon::create(['name' => 'Squirtle', 'rarity_id' => $uncommon]);
        $Wartortle = Pokemon::create(['name' => 'Wartortle', 'rarity_id' => $rare]);
        $Blastoise = Pokemon::create(['name' => 'Blastoise', 'rarity_id' => $legendary]);
        $Caterpie = Pokemon::create(['name' => 'Caterpie', 'rarity_id' => $common]);
        $Metapod = Pokemon::create(['name' => 'Metapod', 'rarity_id' => $uncommon]);
        $Butterfree = Pokemon::create(['name' => 'Butterfree', 'rarity_id' => $rare]);
        $Pidgey = Pokemon::create(['name' => 'Pidgey', 'rarity_id' => $common]);

        //DIO PORCO VEDI DI INIZIARE AD ANDARE O INVADO IL CAUCASO DIO PORCO
        $grass = Type::where('name', 'Grass')->first()->id;
        $Bulbasaur->type()->attach(Type::where('name', 'Grass')->first()->id);
        $Bulbasaur->type()->attach(Type::where('name', 'Poison')->first()->id);
        $Ivysaur->type()->attach(Type::where('name', 'Grass')->first()->id);
        $Ivysaur->type()->attach(Type::where('name', 'Poison')->first()->id);
        $Venusaur->type()->attach(Type::where('name', 'Grass')->first()->id);
        $Venusaur->type()->attach(Type::where('name', 'Poison')->first()->id);
        $Charmander->type()->attach(Type::where('name', 'Fire')->first()->id);
        $Charmeleon->type()->attach(Type::where('name', 'Fire')->first()->id);
        $Charizard->type()->attach(Type::where('name', 'Fire')->first()->id);
        $Charizard->type()->attach(Type::where('name', 'Flying')->first()->id);
        $Squirtle->type()->attach(Type::where('name', 'Water')->first()->id);
        $Wartortle->type()->attach(Type::where('name', 'Water')->first()->id);
        $Blastoise->type()->attach(Type::where('name', 'Water')->first()->id);
        $Caterpie->type()->attach(Type::where('name', 'Bug')->first()->id);
        $Metapod->type()->attach(Type::where('name', 'Bug')->first()->id);
        $Butterfree->type()->attach(Type::where('name', 'Bug')->first()->id);
        $Butterfree->type()->attach(Type::where('name', 'Flying')->first()->id);
        $Pidgey->type()->attach(Type::where('name', 'Normal')->first()->id);
        $Pidgey->type()->attach(Type::where('name', 'Flying')->first()->id);
    }

    private function seedTypes(){
        $types = [
            'Normal',
            'Fire',
            'Water',
            'Grass',
            'Ice',
            'Fighting',
            'Poison',
            'Ground',
            'Flying',
            'Bug',
        ];

        foreach($types as $type){
            Type::create([
            'name' => $type
            ]);
        }

        Type::where('name', 'Water')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Fire')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Water')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Ground')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Water')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Fire')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Water')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Ground')->first()->id, ['multiplier' => 2]);

        Type::where('name', 'Fire')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Water')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Fire')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Fire')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Water')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Fire')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 2]);

        Type::where('name', 'Grass')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Fire')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Grass')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Water')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Grass')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Fire')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Grass')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Water')->first()->id, ['multiplier' => 2]);

        Type::where('name', 'Ice')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Ice')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Ground')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Ice')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Ice')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Ground')->first()->id, ['multiplier' => 0.5]);

        Type::where('name', 'Fighting')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Normal')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Fighting')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Ice')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Fighting')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Normal')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Fighting')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Ice')->first()->id, ['multiplier' => 0.5]);

        Type::where('name', 'Poison')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Poison')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Fighting')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Poison')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Poison')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Fighting')->first()->id, ['multiplier' => 2]);

        Type::where('name', 'Ground')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Poison')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Ground')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Poison')->first()->id, ['multiplier' => 2]);

        Type::where('name', 'Flying')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Flying')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Fighting')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Flying')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Flying')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Fighting')->first()->id, ['multiplier' => 2]);

        Type::where('name', 'Bug')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Bug')->first()->effectivenessOnDefense()->attach(Type::where('name', 'Fighting')->first()->id, ['multiplier' => 0.5]);
        Type::where('name', 'Bug')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Grass')->first()->id, ['multiplier' => 2]);
        Type::where('name', 'Bug')->first()->effectivenessOnAttack()->attach(Type::where('name', 'Fighting')->first()->id, ['multiplier' => 2]);
    }

    private function seedNature(){
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

    private function seedUser(){

        $positions = [
            [
                "x" => 10,
                "y" => 20
            ],
            [
                "x" => 30,
                "y" => 40
            ],
            [
                "x" => 50,
                "y" => 60
            ],
        ];

        $position1 = Position::create($positions[0]);
        $position2 = Position::create($positions[1]);
        $position3 = Position::create($positions[2]);

        $users = [
            [
                "email" => "red@pokemon.com",
                "password" => bcrypt("password"),
                "position_id" => $position1->id
            ],
            [
                "email" => "yellow@pokemon.com",
                "password" => bcrypt("password"),
                "position_id" => $position2->id
            ],
            [
                "email" => "green@pokemon.com",
                "password" => bcrypt("password"),
                "position_id" => $position3->id
            ]
        ];

        collect($users)->each(function ($user) {
            User::create($user);
        });
    }

    private function seedGender()
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

    private function seedState(){
        $states = [
            "Burn",
            "Freeze",
            "Paralysis",
            "Poison",
            "Badly Poisoned",
            "Sleep",
        ];

        foreach($states as $state){
            State::create([
                'name' => $state,
                'description' => 'Lorem Ipsum'
            ]);
        }
    }

    private function seedMoves(){
        //now give types to each moves
        Move::create(["name" => "Tackle", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Normal")->first()->id]);
        Move::create(["name" => "Scratch", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Normal")->first()->id]);
        Move::create(["name" => "Ember", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Fire")->first()->id]);
        Move::create(["name" => "Water Gun", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Water")->first()->id]);
        Move::create(["name" => "Vine Whip", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Grass")->first()->id]);
        Move::create(["name" => "Fly", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Flying")->first()->id]);
        Move::create(["name" => "Quick Attack", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Normal")->first()->id]);
        Move::create(["name" => "Gust", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Flying")->first()->id]);
        Move::create(["name" => "Poison Sting", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Poison")->first()->id]);
        Move::create(["name" => "Bug Bite", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Bug")->first()->id]);
        Move::create(["name" => "Peck", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Flying")->first()->id]);
        Move::create(["name" => "EarthQuake", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Ground")->first()->id]);
        Move::create(["name" => "Ice Beam", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Ice")->first()->id]);
        Move::create(["name" => "Fire Blast", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Fire")->first()->id]);
        Move::create(["name" => "Blade Leaves", "description" => "Lorem Ipsum", "type_id" => Type::where("name", "Grass")->first()->id]);

        //Add can learn level
        Move::where("name", "Tackle")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Bulbasaur")->first()->id, ['level' => 1]);
        Move::where("name", "Scratch")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Charmander")->first()->id, ['level' => 1]);
        Move::where("name", "Ember")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Charmander")->first()->id, ['level' => 5]);
        Move::where("name", "Water Gun")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Squirtle")->first()->id, ['level' => 7]);
        Move::where("name", "Vine Whip")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Bulbasaur")->first()->id, ['level' => 7]);
        Move::where("name", "Fly")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Pidgey")->first()->id, ['level' => 25]);
        Move::where("name", "Quick Attack")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Pidgey")->first()->id, ['level' => 7]);
        Move::where("name", "Gust")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Pidgey")->first()->id, ['level' => 20]);
        Move::where("name", "Poison Sting")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Caterpie")->first()->id, ['level' => 10]);
        Move::where("name", "Bug Bite")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Caterpie")->first()->id, ['level' => 15]);
        Move::where("name", "Peck")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Pidgey")->first()->id, ['level' => 10]);
        Move::where("name", "EarthQuake")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Charmeleon")->first()->id, ['level' => 30]);
        Move::where("name", "Ice Beam")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Ivysaur")->first()->id, ['level' => 33]);
        Move::where("name", "Fire Blast")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Wartortle")->first()->id, ['level' => 45]);
        Move::where("name", "Blade Leaves")->first()->canLearnFromLevel()->attach(Pokemon::where("name", "Butterfree")->first()->id, ['level' => 20]);
        //other 
        Move::where("name", "Tackle")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Bulbasaur")->first()->id);
        Move::where("name", "Scratch")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Charmander")->first()->id);
        Move::where("name", "Ember")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Charmander")->first()->id);
        Move::where("name", "Water Gun")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Squirtle")->first()->id);
        Move::where("name", "Vine Whip")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Bulbasaur")->first()->id);
        Move::where("name", "Fly")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Pidgey")->first()->id);
        Move::where("name", "Quick Attack")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Pidgey")->first()->id);
        Move::where("name", "Gust")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Pidgey")->first()->id);
        Move::where("name", "Poison Sting")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Caterpie")->first()->id);
        Move::where("name", "Bug Bite")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Caterpie")->first()->id);
        Move::where("name", "Peck")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Pidgey")->first()->id);
        Move::where("name", "EarthQuake")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Charmeleon")->first()->id);
        Move::where("name", "Ice Beam")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Ivysaur")->first()->id);
        Move::where("name", "Fire Blast")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Wartortle")->first()->id);
        Move::where("name", "Blade Leaves")->first()->canLearnFromMachine()->attach(Pokemon::where("name", "Butterfree")->first()->id);
        
    }

    private function seedBoxes(){
        User::where("email", "red@pokemon.com")->first()->boxes()->createMany([
            ['name' => 'Box 1'],
            ['name' => 'Box 2'],
            ['name' => 'Box 3'],
        ]);
        User::where("email", "yellow@pokemon.com")->first()->boxes()->createMany([
            ['name' => 'Box 1'],
            ['name' => 'Box 2'],
            ['name' => 'Box 3'],
        ]);
        User::where("email", "green@pokemon.com")->first()->boxes()->createMany([
            ['name' => 'Box 1'],
            ['name' => 'Box 2'],
            ['name' => 'Box 3'],
        ]);
    }

    private function seedZones(){
        $dreamForest = Zone::create([
            "name" => "Dream Forest",
            "length" => 10,
            "width" => 10,
            "position_id" => Position::factory()->create()->id
        ]);
        $dreamForest->pokemons()->attach(Pokemon::where("name", "Bulbasaur")->first()->id);
        $dreamForest->pokemons()->attach(Pokemon::where("name", "Caterpie")->first()->id);
        $dreamForest->pokemons()->attach(Pokemon::where("name", "Pidgey")->first()->id);
        $dreamForest->pokemons()->attach(Pokemon::where("name", "Butterfree")->first()->id);
        $dreamForest->pokemons()->attach(Pokemon::where("name", "Ivysaur")->first()->id);
        $dreamForest->pokemons()->attach(Pokemon::where("name", "Venusaur")->first()->id);

        $fireMountain = Zone::create([
            "name" => "Fire Mountain",
            "length" => 10,
            "width" => 10,
            "position_id" => Position::factory()->create()->id
        ]);
        $fireMountain->pokemons()->attach(Pokemon::where("name", "Charmander")->first()->id);
        $fireMountain->pokemons()->attach(Pokemon::where("name", "Charmeleon")->first()->id);
        $fireMountain->pokemons()->attach(Pokemon::where("name", "Charizard")->first()->id);
        $fireMountain->pokemons()->attach(Pokemon::where("name", "Blastoise")->first()->id);
        
        $waterCave = Zone::create([
            "name" => "Water Cave",
            "length" => 10,
            "width" => 10,
            "position_id" => Position::factory()->create()->id
        ]);
        $waterCave->pokemons()->attach(Pokemon::where("name", "Squirtle")->first()->id);
        $waterCave->pokemons()->attach(Pokemon::where("name", "Wartortle")->first()->id);
        $waterCave->pokemons()->attach(Pokemon::where("name", "Blastoise")->first()->id);
        $waterCave->pokemons()->attach(Pokemon::where("name", "Metapod")->first()->id);
        $waterCave->pokemons()->attach(Pokemon::where("name", "Butterfree")->first()->id);

        $mountMoon = Zone::create([
            "name" => "Mount Moon",
            "length" => 10,
            "width" => 10,
            "position_id" => Position::factory()->create()->id
        ]);
        $mountMoon->pokemons()->attach(Pokemon::where("name", "Caterpie")->first()->id);
        $mountMoon->pokemons()->attach(Pokemon::where("name", "Metapod")->first()->id);
        $mountMoon->pokemons()->attach(Pokemon::where("name", "Butterfree")->first()->id);

        $pokemonMansion = Zone::create([
            "name" => "Pokemon Mansion",
            "length" => 10,
            "width" => 10,
            "position_id" => Position::factory()->create()->id
        ]);
        $pokemonMansion->pokemons()->attach(Pokemon::where("name", "Pidgey")->first()->id);
        $pokemonMansion->pokemons()->attach(Pokemon::where("name", "Charmeleon")->first()->id);
        $pokemonMansion->pokemons()->attach(Pokemon::where("name", "Butterfree")->first()->id);
        $pokemonMansion->pokemons()->attach(Pokemon::where("name", "Ivysaur")->first()->id);
        $pokemonMansion->pokemons()->attach(Pokemon::where("name", "Venusaur")->first()->id);

        $powerPlant = Zone::create([
            "name" => "Power Plant",
            "length" => 10,
            "width" => 10,
            "position_id" => Position::factory()->create()->id
        ]);
        $powerPlant->pokemons()->attach(Pokemon::where("name", "Pidgey")->first()->id);
        $powerPlant->pokemons()->attach(Pokemon::where("name", "Charizard")->first()->id);
        $powerPlant->pokemons()->attach(Pokemon::where("name", "Blastoise")->first()->id);
        $powerPlant->pokemons()->attach(Pokemon::where("name", "Butterfree")->first()->id);
        $powerPlant->pokemons()->attach(Pokemon::where("name", "Ivysaur")->first()->id);
        $powerPlant->pokemons()->attach(Pokemon::where("name", "Venusaur")->first()->id);
    }

    private function seedStoryTools(){
        $pokedex = StoryTool::create([
            'name' => 'Pokedex',
            'description' => 'Lorem Ipsum'
        ]);
        $bike = StoryTool::create([
            'name' => 'Bike',
            'description' => 'Lorem Ipsum'
        ]);
        $cityMap = StoryTool::create([
            'name' => 'City Map',
            'description' => 'Lorem Ipsum'
        ]);
        $red = User::where("email", "red@pokemon.com")->first();
        $red->storyTools()->attach($pokedex->id, ['quantity' => 1]);
        $red->storyTools()->attach($bike->id, ['quantity' => 1]);
        $red->storyTools()->attach($cityMap->id, ['quantity' => 1]);        

        $yellow = User::where("email", "yellow@pokemon.com")->first();
        $yellow->storyTools()->attach($pokedex->id, ['quantity' => 1]);
        $yellow->storyTools()->attach($bike->id, ['quantity' => 1]);

        $green = User::where("email", "green@pokemon.com")->first();
        $green->storyTools()->attach($pokedex->id, ['quantity' => 1]);
    }

    private function seedBattleTools(){
        $potion = BattleTool::create([
            'name' => 'Potion',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 20
        ]);
        $superPotion = BattleTool::create([
            'name' => 'Super Potion',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 50
        ]);
        $hyperPotion = BattleTool::create([
            'name' => 'Hyper Potion',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 200
        ]);
        $maxPotion = BattleTool::create([
            'name' => 'Max Potion',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 999
        ]);
        $revive = BattleTool::create([
            'name' => 'Revive',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 0
        ]);
        $maxRevive = BattleTool::create([
            'name' => 'Max Revive',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 999
        ]);
        $antidote = BattleTool::create([
            'name' => 'Antidote',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 0
        ]);
        $burnHeal = BattleTool::create([
            'name' => 'Burn Heal',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 0
        ]);
        $iceHeal = BattleTool::create([
            'name' => 'Ice Heal',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 0
        ]);
        $awakening = BattleTool::create([
            'name' => 'Awakening',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 0
        ]);
        $paralyzeHeal = BattleTool::create([
            'name' => 'Paralyze Heal',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 0
        ]);
        $fullHeal = BattleTool::create([
            'name' => 'Full Heal',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 0
        ]);
        $fullRestore = BattleTool::create([
            'name' => 'Full Restore',
            'description' => 'Lorem Ipsum',
            'healthRecovery' => 999
        ]);

        //Add StateRecovery
        $antidote->statesRecovery()->attach(State::where("name", "Poison")->first()->id);
        $burnHeal->statesRecovery()->attach(State::where("name", "Burn")->first()->id);
        $iceHeal->statesRecovery()->attach(State::where("name", "Freeze")->first()->id);
        $awakening->statesRecovery()->attach(State::where("name", "Sleep")->first()->id);
        $paralyzeHeal->statesRecovery()->attach(State::where("name", "Paralysis")->first()->id);
        $fullHeal->statesRecovery()->attach(State::where("name", "Poison")->first()->id);
        $fullHeal->statesRecovery()->attach(State::where("name", "Burn")->first()->id);
        $fullHeal->statesRecovery()->attach(State::where("name", "Freeze")->first()->id);
        $fullHeal->statesRecovery()->attach(State::where("name", "Sleep")->first()->id);
        $fullHeal->statesRecovery()->attach(State::where("name", "Paralysis")->first()->id);

        //Add to user bag        
        $red = User::where("email", "red@pokemon.com")->first();
        $red->battleTools()->attach($potion->id, ['amount' => 10]);
        $red->battleTools()->attach($superPotion->id, ['amount' => 10]);
        $red->battleTools()->attach($hyperPotion->id, ['amount' => 10]);
        $red->battleTools()->attach($maxPotion->id, ['amount' => 10]);
        $red->battleTools()->attach($revive->id, ['amount' => 10]);
        $red->battleTools()->attach($maxRevive->id, ['amount' => 10]);
        $red->battleTools()->attach($antidote->id, ['amount' => 10]);

        $yellow = User::where("email", "yellow@pokemon.com")->first();
        $yellow->battleTools()->attach($fullHeal->id, ['amount' => 10]);
        $yellow->battleTools()->attach($fullRestore->id, ['amount' => 10]);
        $yellow->battleTools()->attach($paralyzeHeal->id, ['amount' => 10]);
        $yellow->battleTools()->attach($awakening->id, ['amount' => 10]);
        $yellow->battleTools()->attach($iceHeal->id, ['amount' => 10]);
        $yellow->battleTools()->attach($burnHeal->id, ['amount' => 10]);

        $green = User::where("email", "green@pokemon.com")->first();
        $green->battleTools()->attach($revive->id, ['amount' => 10]);
        $green->battleTools()->attach($maxRevive->id, ['amount' => 10]);
        $green->battleTools()->attach($antidote->id, ['amount' => 10]);
        $green->battleTools()->attach($awakening->id, ['amount' => 10]);
        $green->battleTools()->attach($iceHeal->id, ['amount' => 10]);
        $green->battleTools()->attach($burnHeal->id, ['amount' => 10]);
    }

    private function seedGyms(){
        $dreamForest = Zone::where("name", "Dream Forest")->first();
        $fireMountain = Zone::where("name", "Fire Mountain")->first();
        $waterCave = Zone::where("name", "Water Cave")->first();

        Gym::create([
            'position_id' => Position::factory()->create()->id,
            'zone_id' => $dreamForest->id
        ]);
        Gym::create([
            'position_id' => Position::factory()->create()->id,
            'zone_id' => $fireMountain->id
        ]);
        Gym::create([
            'position_id' => Position::factory()->create()->id,
            'zone_id' => $waterCave->id
        ]);
    }

    private function seedNpc(){
        $brock = Npc::create([
            'name' => 'Brock',
            'position_id' => Position::factory()->create()->id,
            'is_gym_leader' => true
        ]);
        $eva = Npc::create([
            'name' => 'Eva',
            'position_id' => Position::factory()->create()->id,
            'is_gym_leader' => true
        ]);
        $misty = Npc::create([
            'name' => 'Misty',
            'position_id' => Position::factory()->create()->id,
            'is_gym_leader' => true
        ]);
        $ltSurge = Npc::create([
            'name' => 'Lt. Surge',
            'position_id' => Position::factory()->create()->id,
        ]);
        $erika = Npc::create([
            'name' => 'Erika',
            'position_id' => Position::factory()->create()->id,
        ]);
        $koga = Npc::create([
            'name' => 'Koga',
            'position_id' => Position::factory()->create()->id,
        ]);
        $sabrina = Npc::create([
            'name' => 'Sabrina',
            'position_id' => Position::factory()->create()->id,
        ]);
        $blaine = Npc::create([
            'name' => 'Blaine',
            'position_id' => Position::factory()->create()->id,
        ]);
        $giovanni = Npc::create([
            'name' => 'Giovanni',
            'position_id' => Position::factory()->create()->id,
        ]);
        $lorelei = Npc::create([
            'name' => 'Lorelei',
            'position_id' => Position::factory()->create()->id,
        ]);

        //Attach some of them to a gym
        $dreamForestGym = Zone::where("name", "Dream Forest")->first()->gym;
        $fireMountainGym = Zone::where("name", "Fire Mountain")->first()->gym;
        $waterCaveGym = Zone::where("name", "Water Cave")->first()->gym;

        //Gym leader
        $brock->update(['gym_id' => $dreamForestGym->id]);
        $eva->update(['gym_id' => $dreamForestGym->id]);
        $misty->update(['gym_id' => $fireMountainGym->id]);

        //Gym trainers
        $ltSurge->update(["gym_id" => $dreamForestGym->id]);
        $erika->update(["gym_id" => $dreamForestGym->id]);
        $koga->update(["gym_id" => $fireMountainGym->id]);
        $sabrina->update(["gym_id" => $fireMountainGym->id]);
        $blaine->update(["gym_id" => $waterCaveGym->id]);
        $giovanni->update(["gym_id" => $waterCaveGym->id]);
        
        //Give them some battle tools
        $hyperPotion = BattleTool::where("name", "Hyper Potion")->first();
        $maxPotion = BattleTool::where("name", "Max Potion")->first();
        $revive = BattleTool::where("name", "Revive")->first();
        $maxRevive = BattleTool::where("name", "Max Revive")->first();
        $antidote = BattleTool::where("name", "Antidote")->first();
        $burnHeal = BattleTool::where("name", "Burn Heal")->first();
        $awakening = BattleTool::where("name", "Awakening")->first();
        $paralyzeHeal = BattleTool::where("name", "Paralyze Heal")->first();
        $fullHeal = BattleTool::where("name", "Full Heal")->first();

        $brock->battleTools()->attach($hyperPotion->id, ['amount' => 3]);
        $brock->battleTools()->attach($maxPotion->id, ['amount' => 3]);
        $brock->battleTools()->attach($antidote->id, ['amount' => 3]);
        $brock->battleTools()->attach($awakening->id, ['amount' => 3]);

        $misty->battleTools()->attach($hyperPotion->id, ['amount' => 3]);
        $misty->battleTools()->attach($maxPotion->id, ['amount' => 3]);
        $misty->battleTools()->attach($burnHeal->id, ['amount' => 3]);
        $misty->battleTools()->attach($awakening->id, ['amount' => 3]);

        $ltSurge->battleTools()->attach($hyperPotion->id, ['amount' => 3]);
        $ltSurge->battleTools()->attach($maxPotion->id, ['amount' => 3]);
        $ltSurge->battleTools()->attach($paralyzeHeal->id, ['amount' => 3]);
        $ltSurge->battleTools()->attach($awakening->id, ['amount' => 3]);

        $erika->battleTools()->attach($hyperPotion->id, ['amount' => 3]);
        $erika->battleTools()->attach($maxPotion->id, ['amount' => 3]);
        $erika->battleTools()->attach($antidote->id, ['amount' => 3]);
        $erika->battleTools()->attach($fullHeal->id, ['amount' => 3]);

        $koga->battleTools()->attach($hyperPotion->id, ['amount' => 3]);
        $koga->battleTools()->attach($maxPotion->id, ['amount' => 3]);

        $sabrina->battleTools()->attach($hyperPotion->id, ['amount' => 3]);

        $blaine->battleTools()->attach($hyperPotion->id, ['amount' => 3]);

        $giovanni->battleTools()->attach($hyperPotion->id, ['amount' => 3]);
        $giovanni->battleTools()->attach($maxPotion->id, ['amount' => 3]);
        $giovanni->battleTools()->attach($revive->id, ['amount' => 3]);

        $lorelei->battleTools()->attach($hyperPotion->id, ['amount' => 3]);
        $lorelei->battleTools()->attach($maxPotion->id, ['amount' => 3]);
        $lorelei->battleTools()->attach($revive->id, ['amount' => 3]);
        $lorelei->battleTools()->attach($maxRevive->id, ['amount' => 3]);       

    }

    private function seedTeams(){
        $red = User::where("email", "red@pokemon.com")->first();
        $yellow = User::where("email", "yellow@pokemon.com")->first();
        $green = User::where("email", "green@pokemon.com")->first();
        
        //give a team to each user
        //date is 3 july 2024
        $date = Carbon::create(2024, 7, 3);
        $red->team()->create([
            'date' => $date,
        ]);
        $yellow->team()->create([
            'date' => $date,
        ]);
        $green->team()->create([
            'date' => $date,
        ]);
    }

    private function seedExemplary(){
        $bulbasaur = Pokemon::where(["name" => "Bulbasaur"])->first();
        $ivySaur = Pokemon::where(["name" => "Ivysaur"])->first();
        $venusaur = Pokemon::where(["name" => "Venusaur"])->first();
        $charmander = Pokemon::where(["name" => "Charmander"])->first();
        $charmeleon = Pokemon::where(["name" => "Charmeleon"])->first();
        $charizard = Pokemon::where(["name" => "Charizard"])->first();
        $squirtle = Pokemon::where(["name" => "Squirtle"])->first();
        $wartortle = Pokemon::where(["name" => "Wartortle"])->first();
        $blastoise = Pokemon::where(["name" => "Blastoise"])->first();
        $caterpie = Pokemon::where(["name" => "Caterpie"])->first();
        $metapod = Pokemon::where(["name" => "Metapod"])->first();
        $butterfree = Pokemon::where(["name" => "Butterfree"])->first();

        $red = User::where("email", "red@pokemon.com")->first();
        $yellow = User::where("email", "yellow@pokemon.com")->first();
        $green = User::where("email", "green@pokemon.com")->first();

        $redTeam = $red->team()->first();
        $yellowTeam = $yellow->team()->first();
        $greenTeam = $green->team()->first();

        //let's give 3 exemplary to each user
        $this->fakeExemplary($bulbasaur, $redTeam);
        $this->fakeExemplary($charmander, $redTeam);
        $this->fakeExemplary($squirtle, $redTeam);

        $this->fakeExemplary($blastoise, $yellowTeam);
        $this->fakeExemplary($charizard, $yellowTeam);
        $this->fakeExemplary($butterfree, $yellowTeam);

        $this->fakeExemplary($caterpie, $greenTeam);
        $this->fakeExemplary($metapod, $greenTeam);
        $this->fakeExemplary($venusaur, $greenTeam);

        // 3 exemplary for some box
        $users = [$red, $yellow, $green];
        $boxes = ["Box 1", "Box 2", "Box 3"];
        $pokemons = [$bulbasaur, $charmander, $squirtle, $blastoise, $charizard, $butterfree, $caterpie, $metapod, $venusaur];
        for($i = 0; $i < 3; $i++){
            $box = Box::where("name", $boxes[$i])->first();
            $user = $users[$i];
            for($j = 0; $j < 3; $j++){
                $pokemon = $pokemons[$j];
                $this->fakeExemplary($pokemon, null, null, $box);
            }
        }

        // 3 exemplary for each npc
        $npcs = Npc::all();
        foreach($npcs as $npc){
            $pokemon = $pokemons[$this->faker->numberBetween(0, 8)];
            $this->fakeExemplary($pokemon, null, $npc);
        }
    }

    private function fakeExemplary($pokemon, Team|null $team = null,Npc|null $npc = null,Box|null $box = null){

        $exemplary = Exemplary::create([
            "pokemon_id" => $pokemon->id,
            'name' => $pokemon->name,
            "level" => $this->faker->numberBetween(1, 100),
            "speed" => $this->faker->numberBetween(1, 100),
            "specialDefense" => $this->faker->numberBetween(1, 100),
            "defense" => $this->faker->numberBetween(1, 100),
            "attack" => $this->faker->numberBetween(1, 100),
            "specialAttack" => $this->faker->numberBetween(1, 100),
            "ps" => $this->faker->numberBetween(1, 100),
            "gender_id" => Gender::inRandomOrder($this->faker->randomNumber(2))->first()->id,
            "nature_id" => Nature::inRandomOrder($this->faker->randomNumber(2))->first()->id,
            "team_id" => $team ? $team->id : null,
            "npc_id" => $npc ? $npc->id : null,
            "box_id" => $box ? $box->id : null,
            "holding_tools_id" => $this->faker->numberBetween(0, 1) ? BattleTool::inRandomOrder($this->faker->randomNumber(2))->first()->id : null,
        ]);

        // each exemplary have 3 or 4 move
        $moves = Move::inRandomOrder($this->faker->randomNumber(2))->limit($this->faker->numberBetween(3, 4))->get();
        foreach($moves as $move){
            $exemplary->move()->attach($move->id);
        }

        //simulate the capture, set a capture object and duplicate exemplary assignign exemplaryId with reference to current exemplary
        $user = null;
        if($box !== null){
            $user = $box->user_id;
        }
        if($team !== null){
            $user = $team->user_id;
        }
        if($user !== null){
            $exemplary->captured()->create([
                "date" => $this->faker->dateTimeBetween('-1 years', 'now'),
                "zone_id" => Zone::inRandomOrder($this->faker->randomNumber(2))->first()->id,
                "user_id" => $user,
            ]);

            //duplicate exemplary (with different id)
            $exemplaryClone = $exemplary->replicate();
            $exemplaryClone->exemplary_id = $exemplary->id;
            $exemplaryClone->save();
        }

    }

    private function seedBattles(){
        $red = User::where("email", "red@pokemon.com")->first();
        $yellow = User::where("email", "yellow@pokemon.com")->first();
        $green = User::where("email", "green@pokemon.com")->first();

        //3 battles
        $battleRedYellow = Battle::create([
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'user_1' => $red->id,
            'user_2' => $yellow->id,
            'winner' => 1,
        ]);

        //in each battle got N battle registry
        $battleRedYellow->registry()->createMany([
            [
                'exemplary1_id' => $red->exemplaries()->where("exemplary_id", null)->skip(0)->first()->id,
                'exemplary2_id' => $yellow->exemplaries()->where("exemplary_id", null)->skip(0)->first()->id,
                'winner' => 1
            ],
            [
                'exemplary1_id' => $red->exemplaries()->where("exemplary_id", null)->skip(1)->first()->id,
                'exemplary2_id' => $yellow->exemplaries()->where("exemplary_id", null)->skip(1)->first()->id,
                'winner' => 2
            ],
            [
                'exemplary1_id' => $red->exemplaries()->where("exemplary_id", null)->skip(2)->first()->id,
                'exemplary2_id' => $yellow->exemplaries()->where("exemplary_id", null)->skip(2)->first()->id,
                'winner' => 1
            ],
        ]);

        $battleRedGreen = Battle::create([
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'user_1' => $red->id,
            'user_2' => $green->id,
            'winner' => 1,
        ]);

        //in each battle got N battle registry
        $battleRedGreen->registry()->createMany([
            [
                'exemplary1_id' => $red->exemplaries()->where("exemplary_id", null)->skip(0)->first()->id,
                'exemplary2_id' => $green->exemplaries()->where("exemplary_id", null)->skip(0)->first()->id,
                'winner' => 1
            ],
            [
                'exemplary1_id' => $red->exemplaries()->where("exemplary_id", null)->skip(1)->first()->id,
                'exemplary2_id' => $green->exemplaries()->where("exemplary_id", null)->skip(1)->first()->id,
                'winner' => 2
            ],
            [
                'exemplary1_id' => $red->exemplaries()->where("exemplary_id", null)->skip(2)->first()->id,
                'exemplary2_id' => $green->exemplaries()->where("exemplary_id", null)->skip(2)->first()->id,
                'winner' => 1
            ],
        ]);

        $battleYellowGreen = Battle::create([
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'user_1' => $yellow->id,
            'user_2' => $green->id,
            'winner' => 1,
        ]);

        //in each battle got N battle registry
        $battleYellowGreen->registry()->createMany([
            [
                'exemplary1_id' => $yellow->exemplaries()->where("exemplary_id", null)->skip(0)->first()->id,
                'exemplary2_id' => $green->exemplaries()->where("exemplary_id", null)->skip(0)->first()->id,
                'winner' => 1
            ],
            [
                'exemplary1_id' => $yellow->exemplaries()->where("exemplary_id", null)->skip(1)->first()->id,
                'exemplary2_id' => $green->exemplaries()->where("exemplary_id", null)->skip(1)->first()->id,
                'winner' => 2
            ],
            [
                'exemplary1_id' => $yellow->exemplaries()->where("exemplary_id", null)->skip(2)->first()->id,
                'exemplary2_id' => $green->exemplaries()->where("exemplary_id", null)->skip(2)->first()->id,
                'winner' => 1
            ],
        ]);
    }


    private function seedAdmin(){
        Admin::create([
            'email' => 'admin@pokemon.com',
            'password' => bcrypt('password')
        ]);
    }
}