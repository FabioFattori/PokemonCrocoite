<?php

namespace App\Http\Controllers;

use App\Models\Exemplary;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use App\Tables\UserTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\DBController;
use App\Models\Move;
use App\Models\Pokemon;
use App\Models\Position;
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
            $team = new ExemplaryTable(mode:Mode::TEAM);

            $position = $user->position()->get();

             if($id != null && $team->equalsByID($id)){
                 $team->setConfigObject($request->all());
             }

            return Inertia::render('Home', ['team' => $team->get(), 'user' => $user, 'position' => $position,"mode" => "user"]);
        }else{
            $user = auth('admin')->user();

            # first chart
            $pokemonForType = [];
            $types = Type::all();
            // select from the types only the name of the type
            foreach($types as $type){
                array_push($pokemonForType,$type->pokemons()->get()->count());
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
