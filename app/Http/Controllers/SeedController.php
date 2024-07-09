<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeedController extends Controller
{
    public function basePokemon(){
        //create 5 pokemon with the factory and for each pokemon create 5 exemplary
        $pkm = \App\Models\Pokemon::factory(5)->create()->each(function($p){
            \App\Models\Exemplary::factory(5)->create(["pokemon_id" => $p->id]);
            //assign 2 types to each pokemon
            for($i = 0; $i < 2; $i++){
                do{
                    $id = \App\Models\Type::inRandomOrder()->first()->id;
                }while ($p->type()->where("types.id", "=", $id)->exists());
                $p->type()->attach($id);
            }
        });

        return response()->json(["message" => "Pokemon and Exemplaries seeded", "pokemon" => $pkm]);
    }   

    public function users(){
        //create 5 users with the factory
        $users = \App\Models\User::factory(5)->create();

        foreach($users as $user){
            $teams = \App\Models\Team::factory(1)->create(["user_id" => $user->id]);
        }
        

        return response()->json(["message" => "Users seeded", "users" => $users]);
    }

    public function natures(){
        //create 5 natures with the factory
        $natures = \App\Models\Nature::factory(5)->create();

        return response()->json(["message" => "Natures seeded", "natures" => $natures]);
    }

    public function types(){
        //create 5 types with the factory
        $types = \App\Models\Type::factory(5)->create();

        return response()->json(["message" => "Types seeded", "types" => $types]);
    }

    public function moves(){
        //create 5 moves with the factory
        $moves = \App\Models\Move::factory(5)->create();

        return response()->json(["message" => "Moves seeded", "moves" => $moves]);
    }

    public function boxes(){
        //create 5 boxes with the factory
        $boxes = \App\Models\Box::factory(5)->create();

        return response()->json(["message" => "Boxes seeded", "boxes" => $boxes]);
    }

    public function genders(){
        $genders = \App\Models\Gender::factory(5)->create();

        return response()->json(["message" => "genders seeded", "genders" => $genders]);
    }

    public function positions(){
        $positions = \App\Models\Position::factory(5)->create();

        return response()->json(["message" => "positions seeded", "positions" => $positions]);
    }

    public function zones(){
        $zones = \App\Models\Zone::factory(5)->create();

        return response()->json(["message" => "zones seeded", "zones" => $zones]);
    }

    public function gyms(){
        $gyms = \App\Models\Gym::factory(5)->create();

        return response()->json(["message" => "gyms seeded", "gyms" => $gyms]);
    }

    public function npcs(){
        $npcs = \App\Models\Npc::factory(5)->create();

        return response()->json(["message" => "npcs seeded", "npcs" => $npcs]);
    }

    public function battle_tools(){
        $battle_tools = \App\Models\BattleTool::factory(5)->create();

        return response()->json(["message" => "battle_tools seeded", "battle_tools" => $battle_tools]);
    }

    public function all(){
        $this->battle_tools();
        $this->positions();
        $this->zones();
        $this->gyms();
        $this->npcs();
        $this->natures();
        $this->types();
        $this->genders();
        $this->moves();
        $this->users();
        $this->boxes();
        $this->basePokemon();
        return response()->json(["message" => "All seeded"]);
    }
}
