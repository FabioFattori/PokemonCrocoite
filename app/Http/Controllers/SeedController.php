<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeedController extends Controller
{
    public function basePokemon(){
        //create 5 pokemon with the factory and for each pokemon create 5 exemplary
        $pkm = \App\Models\Pokemon::factory(5)->create()->each(function($p){
            \App\Models\Exemplary::factory(5)->create(["pokemon_id" => $p->id]);
        });

        return response()->json(["message" => "Pokemon and Exemplaries seeded", "pokemon" => $pkm]);
    }   

    public function users(){
        //create 5 users with the factory
        $users = \App\Models\User::factory(5)->create();

        return response()->json(["message" => "Users seeded", "users" => $users]);
    }
}
