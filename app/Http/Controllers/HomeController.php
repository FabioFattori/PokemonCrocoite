<?php

namespace App\Http\Controllers;

use App\Models\Exemplary;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use App\Tables\UserTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\DBController;
use App\Models\Captured;
use App\Models\Move;
use App\Models\Pokemon;
use App\Models\PokemonEncountered;
use App\Models\Position;
use App\Models\Rarity;
use App\Models\Type;
use App\Models\User;
use App\Models\Zone;

class HomeController extends Controller
{
    public function index(Request $request){
        $id = $request->all()["id"] ?? null;
        //check if the user is authenticated
        if (!auth()->check()&& !auth('admin')->check()) {
            return redirect()->route('login.log');
        }

        if(!auth('admin')->check()){
            $user = auth()->user();

            $position = Position::where("id", $user->position_id)->first();

            $zone = Zone::all();

            $zone = $zone->filter(function($zone) use ($position){
                return Position::checkIfPositionIsInZone($position->x, $position->y, $zone->id);
            })->first();

            //return $zone;

            $pokemon = null;
            $rarities = Rarity::all();

            if($zone != null){
                $pokemon = Pokemon::all();
                $pokemon = $pokemon->filter(function($p) use ($zone){
                    return $zone->pokemons()->where("pokemon_id", $p->id)->exists();
                });
            }

            $allPokemon = Pokemon::all();

            //foreach pokemon check if the user has captured it or encountered it
            $allPokemon = $allPokemon->map(function($p) use ($user){
                $allExemplaryOfPokemon = Exemplary::where("pokemon_id", $p->id)->get();
                $p->captured = false;
                $p->encountered = false;
                $allExemplaryOfPokemon->map(function($exemplary) use ($user,$p){
                    $captured = Captured::where("exemplary_id", $exemplary->id)->where("user_id", $user->id)->exists();

                    if($captured){
                        $p->captured = true;
                        $p->encountered = true;
                    }

                    $encountered = PokemonEncountered::where("pokemon_id", $p->id)->where("user_id", $user->id)->exists();
                    if($encountered){
                        $p->encountered = true;
                    }
                });


                return $p;
            });


            return Inertia::render('Home', ['user' => $user, 'position' => $position,"mode" => "user","zone" => $zone,"pokemonInZone" => $pokemon,"rarities" => $rarities,"pokedex" => $allPokemon]);
        }else{
            $user = auth('admin')->user();

            # first chart
            $pokemonForType = [];
            $types = Type::all();
            // select from the types only the name of the type
            foreach($types as $type){
                array_push($pokemonForType,$type->pokemons()->count());
            }  
            $types = $types->map(function($type){
                return $type->name;
            });

            #second chart
            $pokemon = Pokemon::join("exemplaries", "pokemon.id", "=", "exemplaries.pokemon_id")->where("exemplaries.team_id", "!=", null);
            $toReturn = [];
            
            $toIterate = $pokemon->select("pokemon.id","pokemon.name","pokemon.rarity_id")->groupBy("pokemon.name")->get();

            foreach ($toIterate as $key => $pk) {
                $count = Pokemon::select("pokemon.name")->join("exemplaries", "pokemon.id", "=", "exemplaries.pokemon_id")->where("exemplaries.team_id", "!=", null)->where("pokemon.name", "=", $pk->name)->count();
                array_push($toReturn, $count);
            }
                    
            $Pokemon = Pokemon::all()->map(function($p){
                return $p->name;
            });

            # third chart => most populate zone
            $zones = Zone::all();
            $users = User::all();
            $nUsersInZone = [];
            foreach($zones as $zone){
                $count = 0;
                foreach($users as $user){
                    if(Position::checkIfPositionIsInZone($user->position()->first()->x, $user->position()->first()->y, $zone->id)){
                        $count++;
                    }
                }
                array_push($nUsersInZone, $count);
            }
            $zones = $zones->map(function($zone){
                return $zone->name;
            });

            # fourth chart => most popular move 
            $nTimesAMoveIsLearned = [];
            $exemplaries = Exemplary::all()->map(function($exemplary){
                return $exemplary->move()->get();
            });

            $exemplaries->each(function($exemplary) use (&$nTimesAMoveIsLearned){
                $exemplary->each(function($move) use (&$nTimesAMoveIsLearned){
                    if(array_key_exists($move->name, $nTimesAMoveIsLearned)){
                        $nTimesAMoveIsLearned[$move->name]++;
                    }else{
                        $nTimesAMoveIsLearned[$move->name] = 1;
                    }
                });
            });

            

            $moves = Move::all()->map(function($move){
                return $move->name;
            });
            $toRet = [];
            foreach ($moves as $key => $move) {
                if(array_key_exists($move, $nTimesAMoveIsLearned)){
                    array_push($toRet, $nTimesAMoveIsLearned[$move]);
                }else{
                    array_push($toRet, 0);
                }
            }

            return Inertia::render('Home', [ 'user' => $user , "mode" => "admin",
            # first chart
            'pokemonForType' => $pokemonForType,
            'types' => $types,
            # second chart
            'pokemonsMostUsed' => $toReturn,
            'pokemonNames' => $toIterate->map(function($p){
                return $p->name;
            }),
            # third chart
            'nUsersInZone' => $nUsersInZone,
            'zones' => $zones,
            # fourth chart
            "movesTimes" => $toRet,
            "movesNames" => $moves
            
            ]);
        }

        
    }
}
