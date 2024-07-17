<?php

namespace App\Http\Controllers;

use App\Tables\MnMtMode;
use App\Tables\StoryToolMode;
use Database\Seeders\DatabaseSeeder;
use App\Models\Battle;
use App\Models\BattleRegistry;
use App\Models\Battles;
use App\Models\BattleTool;
use App\Models\Box;
use App\Models\Captured;
use App\Models\MnMt;
use App\Models\StoryTool;
use App\Models\User;
use App\Tables\BattleTable;
use App\Tables\ExemplaryTable;
use App\Tables\MnMtTable;
use App\Tables\Mode;
use App\Tables\SinglePokemonBattleTable;
use App\Tables\StateTable;
use App\Tables\StoryToolTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Tables\UserTable;
use Illuminate\Support\Facades\Hash;
use App\Models\Exemplary;
use App\Models\Gender;
use App\Models\Gym;
use App\Models\Move;
use App\Models\Nature;
use App\Models\Npc;
use App\Models\Pokemon;
use App\Models\Position;
use App\Models\Rarity;
use App\Models\State;
use App\Models\StateBattleTool;
use App\Models\Team;
use App\Models\Type;
use App\Models\Zone;
use App\Tables\BattleToolMode;
use App\Tables\BattleToolTable;
use App\Tables\BoxTable;
use App\Tables\CaptureTable;
use App\Tables\Class\DependeciesResolver;
use App\Tables\EffectivnessTable;
use App\Tables\GendersTable;
use App\Tables\GymsTable;
use App\Tables\MovesMode;
use App\Tables\MovesTable;
use App\Tables\NatureTable;
use App\Tables\NpcTable;
use App\Tables\PokemonTable;
use App\Tables\PositionTable;
use App\Tables\RaritiesTable;
use App\Tables\SingleBattleMode;
use App\Tables\ZonesTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;
use PhpParser\Node\Stmt\Return_;

class AdminController extends Controller
{
    public function Users(Request $request){
        
        $tb = new UserTable();
        if($request->all() != [] &&key_exists("id",$request->all())&& $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        $dp = DependeciesResolver::resolve($tb);
        $dpNames = $tb->getDependencies();
        $tools = null;
        $storyTools = null;
        $mnmt = null;
        //codice della madonna 
        if(key_exists("user_id",$request->all())){
            $tools = new BattleToolTable(BattleToolMode::ofUser,$request->all()["user_id"]);
            if((key_exists("id",$request->all())) && $tools->equalsById($request->all()["id"])){
                $tools->setConfigObject($request->all());
            }
            $dp = $this->putTogheterDepencencies($tb, $tools);
            $dpNames = $this->putTogheterDepencenciesNames($tb, $tools);
            $tools = $tools->get();

            $storyTools = new StoryToolTable(mode:StoryToolMode::ofUser,userId:$request->all()["user_id"]);
            if((key_exists("id",$request->all())) && $storyTools->equalsById($request->all()["id"])){
                $storyTools->setConfigObject($request->all());
            }
            $storyTools = $storyTools->get();

            //return $storyTools;

            $mnMt = new MnMtTable(mode:MnMtMode::ofUser,userId:$request->all()["user_id"]);

            if((key_exists("id",$request->all())) && $mnMt->equalsById($request->all()["id"])){
                $mnMt->setConfigObject($request->all());
            }

            $dp1 = $this->putTogheterDepencencies($tb, $mnMt);
            $dpNames1 = $this->putTogheterDepencenciesNames($tb, $mnMt);
            $mnmt = $mnMt->get();

            $dp = array_merge($dp,$dp1);
            $dpNames = array_merge($dpNames,$dpNames1);
            


        }

        return Inertia::render('Admin/Utenti', [
            'users' => $tb->get(),
            'dependencies' => $dp,
            'dependenciesName' => $dpNames,
            'tools' => $tools,
            'storyTool' => $storyTools,
            'mnMt' => $mnmt,
        ]);
    }

    public function addUser(Request $request){
        
        if(key_exists("user_id",$request->all())){
            if(key_exists("move_id",$request->all())){
                
                $request->validate([
                    "move_id" => "required|integer",
                    "number" => "required|integer",
                    "description" => "required|string",
                    "isMn" => "required|integer",
                    "quantity" => "required|integer",
                ]);

                $user = User::find($request->input("user_id"));
                $mnMt = MnMt::create([
                    "move_id" => $request->input("move_id"),
                    "number" => $request->input("number"),
                    "description" => $request->input("description"),
                    "is_mn" => $request->input("isMn"),
                ]);
                $user->mnMt()->attach($mnMt->id,["quantity" => $request->input("quantity")]);
                
            }else if(key_exists("quantity",$request->all())){
                $request->validate([
                    "name" => 'required',
                    "description" => 'required',
                    "quantity" => 'required|integer',
                ]);
                $newTool = StoryTool::create([
                    "name" => $request->input("name"),
                    "description" => $request->input("description"),
                ]);
                $npc = User::find($request->input("user_id"));
                $npc->storyTools()->attach($newTool->id,["quantity" => $request->input("quantity")]);
            }else 
            if(!key_exists("prefabbricato", $request->all())){
                $request->validate([
                    "name" => "required",
                    "description" => "required",
                    "healthRecovery" => "required|integer",
                    "state_id" => "required|integer",
                ]);
                $tb=BattleTool::create([
                    "name" => $request->input("name"),
                    "description" => $request->input("description"),
                    "healthRecovery" => $request->input("healthRecovery"),
                ]);
                $tb->statesRecovery()->attach($request->input("state_id"));
                $npc = User::find($request->input("user_id"));
                $npc->battleTools()->attach($tb->id,["amount" => $request->input("amount")]);
            }else if(key_exists("prefabbricato", $request->all())){
                
                $request->validate([
                    "prefabbricato" => "required|integer",
                ]);
    
                $tb = BattleTool::find($request->input("prefabbricato"));
                $npc = User::find($request->input("user_id"));
                $npc->battleTools()->attach($tb->id,["amount" => $request->input("amount")]);
            }else 

            {
                $request->validate([
                    "name" => "required",
                    "description" => "required",
                    "healthRecovery" => "required|integer",
                ]);
                $bt = BattleTool::create([
                    "name" => $request->input("name"),
                    "description" => $request->input("description"),
                    "healthRecovery" => $request->input("healthRecovery"),
                ]);

                $npc = User::find($request->input("user_id"));
                $npc->battleTools()->attach($bt->id,["amount" => $request->input("amount")]);
            }
        }else{
        $request->validate([
            "email" => "required|email",
            "password" => "required",
            "position_id" => "required|integer",
        ]);

        $user = User::create([
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
            "position_id" => $request->input("position_id"),
        ]);

        Box::create([
            "name" => "Box di ".$user->email,
            "user_id" => $user->id,
        ]);

        Team::create([
            "date" => now(),
            "user_id" => $user->id,
        ]);
    }

        return redirect()->back();
    }

    public function editUser(Request $request){
        if(key_exists("user_id",$request->all())){
            
            if(key_exists("move_id",$request->all())){
                $request->validate([
                    "old_move"=> "required|integer",
                    "move_id" => "required|integer",
                    "number" => "required|integer",
                    "description" => "required|string",
                    "isMn" => "required|integer",
                    "quantity" => "required|integer",
                ]);

                $user = User::find($request->input("user_id"));
                $mnMt = MnMt::find($request->input("id"));
                $mnMt->update([
                    "move_id" => $request->input("move_id"),
                    "number" => $request->input("number"),
                    "description" => $request->input("description"),
                    "is_mn" => $request->input("isMn"),
                ]);
                $user->mnMt()->where("mn_mt_id","=",$request->input("old_move"))->updateExistingPivot($mnMt->id,["quantity" => $request->input("quantity")]);

                
            }else if(key_exists("old_storyToolName",$request->all())){
                $request->validate([
                    "old_storyToolName" => 'required',
                    "name" => 'required',
                    "description" => 'required',
                    "quantity" => 'required|integer',
                ]);
                $oldTool = StoryTool::find($request->input("old_storyToolName")["id"]);
                $npc = User::find($request->input("user_id"));
                $npc->storyTools()->detach($request->input("old_storyToolName")["id"]);
                $oldTool->update([
                    "name" => $request->input("name"),
                    "description" => $request->input("description"),
                ]);
                $npc->storyTools()->attach($oldTool->id,["quantity" => $request->input("quantity")]);
                
                
            }else{

                $request->validate([
                    "prefabbricato" => "required|integer",
                    "old_prefabbricato" => "required|string",
                    "amount" => "required|integer",
                ]);
                
                $oldTool = BattleTool::where("name","=",$request->input("old_prefabbricato"))->get()->first();
                
                $npc = User::find($request->input("user_id"));
                $npc->battleTools()->detach($oldTool->id);
                $npc->battleTools()->attach($request->input("prefabbricato"),["amount" => $request->input("amount")]);
            }

        }else{
        $request->validate([
            "id" => "required|integer",
            "email" => "required|email",
            "password" => "required",
        ]);

        User::where("id", "=", $request->input("id"))->update([
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
            "position_id" => $request->input("position_id"),
        ]);
    }

        return redirect()->back();
    }

    public function deleteUser(Request $request){
        return $request->all();
        if(key_exists("user_id",$request->all())){

            $request->validate([
                "user_id" => "required|integer",
            ]);

            if(key_exists("Nome Mossa",$request->all()["headers"])){
                $npc = User::find($request->input("user_id"));
                $npc->mnMt()->detach($request->input("id"));
            }else if(key_exists("Quantità",$request->all()["headers"])){
                $npc = User::find($request->input("user_id"));
                $npc->storyTools()->detach($request->input("id"));
            }else{
                $npc = User::find($request->input("user_id"));
                $npc->battleTools()->detach($request->input("id"));
            }
        }else{
        $request->validate([
            "id" => "required|integer",
        ]);

        User::where("id", "=", $request->input("id"))->delete();
    }
        return redirect()->back();
    }

    public function Exemplaries(Request $request){
        $tb = new ExemplaryTable(mode:Mode::ADMIN);

        if($request->all() != [] && key_exists("id",$request->all()) && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        if($request->all() != [] && key_exists("exemplary_id",$request->all()) &&$request->all()["exemplary_id"] != null){
            $moves = new MovesTable(mode:MovesMode::getMovesFromExemplaryId, exemplaryId:$request->all()["exemplary_id"]);
            $pokemon = Exemplary::find($request->all()["exemplary_id"])->pokemon()->get()->first();
            $allLearnableMoves = $pokemon->allLearnableMoves();
            return Inertia::render('Admin/Esemplari', [
                'exemplaries' => $tb->get(),
                'dependencies' => DependeciesResolver::resolve($tb),
                'dependenciesName' => $tb->getDependencies(),
                'moves' => $moves->get(),
                'allLearnableMoves' => $allLearnableMoves,
            ]);
        }

        
        
        return Inertia::render('Admin/Esemplari', [
            'exemplaries' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }
    
    public function addEmplaries(Request $request){
        $request->validate([
            "name" => "required",
            "level" => "required|integer",
            "speed" => "required|integer",
            "attack" => "required|integer",
            "defense" => "required|integer",
            "specialAttack" => "required|integer",
            "specialDefense" => "required|integer",
            "hp" => "required|integer",
            "pokemon_id" => "required|integer",
            "nature_id" => "required|integer",
            "gender_id" => "required|integer",
        ]);

        // the pokemon cannot have a box_id and a team_id at the same time
        if(key_exists("box_id",$request->all()) && $request->all()["box_id"] != null && key_exists("team_id",$request->all()) && $request->all()["team_id"] != null){
            return redirect()->back()->withErrors(["box_id" => "Non puoi avere un esemplare in una squadra e in una box allo stesso tempo"]);
        }

        //the pokemon cannot have a npc_id and a user_id at the same time
        if(key_exists("npc_id",$request->all()) && $request->all()["npc_id"] != null && key_exists("user_id",$request->all()) && $request->all()["user_id"] != null){
            return redirect()->back()->withErrors(["npc_id" => "Non puoi avere un esemplare in un npc e in un utente allo stesso tempo"]);
        }

        $ex = Exemplary::create([
            "name" => $request->input("name"),
            "level" => $request->input("level"),
            "speed" => $request->input("speed"),
            "attack" => $request->input("attack"),
            "defense" => $request->input("defense"),
            "specialAttack" => $request->input("specialAttack"),
            "specialDefense" => $request->input("specialDefense"),
            "ps" => $request->input("hp"),
            "pokemon_id" => $request->input("pokemon_id"),
            "nature_id" => $request->input("nature_id"),
            "gender_id" => $request->input("gender_id"),
            "npc_id" => $request->input("npc_id"),
            "team_id" => $request->input("team_id"),
            "box_id" => $request->input("box_id"),
            "holding_tools_id" => $request->input("holding_tools_id"),
        ]);
        if(key_exists("catchDate",$request->all()) && key_exists("zone_id",$request->all()) && key_exists("user_id",$request->all())){
            $ex->captured()->create([
                "date" => $request->input("catchDate"),
                "zone_id" => $request->input("zone_id"),
                "user_id" => $request->input("user_id"),
            ]);
        }
        
        
        
        return redirect()->route("admin.exemplaries");
    }

    public function editEmplaries(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "level" => "required|integer",
            "speed" => "required|integer",
            "attack" => "required|integer",
            "defense" => "required|integer",
            "specialAttack" => "required|integer",
            "specialDefense" => "required|integer",
            "hp" => "required|integer",
            "pokemon_id" => "required|integer",
            "nature_id" => "required|integer",
            "gender_id" => "required|integer",
            "zone_id" => "required|integer",
            "catchDate" => "required|date",
        ]);
        
        $ex = Exemplary::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "level" => $request->input("level"),
            "speed" => $request->input("speed"),
            "attack" => $request->input("attack"),
            "defense" => $request->input("defense"),
            "specialAttack" => $request->input("specialAttack"),
            "specialDefense" => $request->input("specialDefense"),
            "ps" => $request->input("hp"),
            "pokemon_id" => $request->input("pokemon_id"),
            "nature_id" => $request->input("nature_id"),
            "box_id" => $request->input("box_id"),
            "team_id" => $request->input("team_id"),
            "npc_id" => $request->input("npc_id"),
            "holding_tools_id" => $request->input("holding_tools_id"),
        ]);


        if(key_exists("catchDate",$request->all()) && key_exists("zone_id",$request->all()) && key_exists("user_id",$request->all())){
            $ex = Exemplary::find($request->input("id"));
            //check if the exemplary has already a captured
            $validator = Validator::make($request->all(), [
                "catchDate" => "required|date",
                "zone_id" => "required|integer",
                "user_id" => "required|integer",
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors(["user_id" => "Si può inserire una cattura solo se l'esemplare è di un utente"]);
            }
            

            if($ex->captured()->get()->first() != null){
                $ex->captured()->update([
                    "date" => $request->input("catchDate"),
                    "zone_id" => $request->input("zone_id"),
                    "user_id" => $request->input("user_id"),
                ]);
            }else{
                $ex->captured()->create([
                    "date" => $request->input("catchDate"),
                    "zone_id" => $request->input("zone_id"),
                    "user_id" => $request->input("user_id"),
                ]);
            }
        }

        return redirect()->back();
    }

    public  function deleteEmplaries(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Exemplary::where("id", "=", $request->input("id"))->delete();

        return redirect()->route("admin.exemplaries");
    }

    public function moves(Request $request){
        $tb = new MovesTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render('Admin/Mosse', [
            'moves' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addMove(Request $request){
        $request->validate([
            "name" => "required",
            "description" => "required",
            "type_id" => "required|integer",
            "probState" => "required|integer",
            "state_id" => "required|integer",
        ]);

        Move::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "type_id" => $request->input("type_id"),
            "probState" => $request->input("probState"),
            "state_id" => $request->input("state_id"),
        ]);

        return redirect()->route("admin.moves");
    }

    public function editMove(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "description" => "required",
            "type_id" => "required|integer",
            "probState" => "required|integer",
            "state_id" => "required|integer",
        ]);

        Move::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "type_id" => $request->input("type_id"),
            "probState" => $request->input("probState"),
            "state_id" => $request->input("state_id"),
        ]);

        return redirect()->route("admin.moves");
    }

    public function deleteMove(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Move::where("id", "=", $request->input("id"))->delete();

        return redirect()->route("admin.moves");
    }

    public function changeMove(Request $request){
        $request->validate([
            "exemplary_id" => "required|integer",
            "moveOld_id" => "required|integer",
            "moveNew_id" => "required|integer",
        ]);

        if($request->all()["moveNew_id"] == -1 || $request->all()["moveOld_id"] == -1 || $request->all()["moveNew_id"] == $request->all()["moveOld_id"]){
            return redirect()->back();
        }

        $exemplary = Exemplary::find($request->all()["exemplary_id"]);
        $exemplary->move()->detach($request->all()["moveOld_id"]);
        $exemplary->move()->attach($request->all()["moveNew_id"]);
        return redirect()->back();
    }

    public function Genders(Request $request){
        $tb = new GendersTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Generi",[
            'genders' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }


    public function addGender(Request $request){
        $request->validate([
            "name" => "required",
        ]);

        Gender::create([
            "name" => $request->input("name"),
        ]);

        return redirect()->back();
    }

    public function editGender(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
        ]);

        Gender::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
        ]);

        return redirect()->back();
    }

    public function deleteGender(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Gender::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function Pokemons(Request $request){
        $tb = new PokemonTable();
        if($request->all() != [] && key_exists("id",$request->all()) && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        $move = null;
        $moveMn = null;
        $dp = DependeciesResolver::resolve($tb);
        $dpNames = $tb->getDependencies();
        if(key_exists("pokemon_id",$request->all())){
            if(key_exists("mnMt",$request->all()) && $request->input("mnMt") == 1){
                $move1 = new MovesTable(MovesMode::getMovesForExemplaryMnMt,$request->all()["pokemon_id"]);
                $dp = $this->putTogheterDepencencies($tb, $move1);
                $dpNames = $this->putTogheterDepencenciesNames($tb, $move1);
                $moveMn = $move1->get();
            }else{
                $move = new MovesTable(MovesMode::getMovesForExemplaryLevel,$request->all()["pokemon_id"]);
                $dp = $this->putTogheterDepencencies($tb, $move);
                $dpNames = $this->putTogheterDepencenciesNames($tb, $move);
                $move = $move->get();
            }
            
        }
        $id = null ;
        if(key_exists("pokemon_id",$request->all())){
            $id = $request->all()["pokemon_id"];
        }

        return Inertia::render("Admin/Razze",[
            'pokemon' => $tb->get(),
            'dependencies' => $dp,
            'dependenciesName' => $dpNames,
            'moves' => $move,
            'movesMn' => $moveMn,
            "url1" => "pokemons/Delete?mnMt=0&pokemon_id=".$id,
            "url2" => "pokemons/Delete?mnMt=1&pokemon_id=".$id,
        ]);
    }

    public function addPokemon(Request $request){
        if(key_exists("pokemon_id",$request->all()) && !key_exists("rarity_id",$request->all())){
            if(key_exists("can_learn_mn_mt",$request->all())){
                $request->validate([
                    "can_learn_mn_mt" => "required|integer",
                ]);
    
                $move = Move::find($request->input("can_learn_mn_mt"));
                $move->canLearnFromMachine()->attach($request->input("pokemon_id"));
            }else{
                if(!key_exists("prefabbricato", $request->all())){
                    $request->validate([
                        "name" => "required",
                        "description" => "required",
                        "type_id" => "required|integer",
                    ]);
                    $move = Move::create([
                        "name" => $request->input("name"),
                        "description" => $request->input("description"),
                        "type_id" => $request->type_id,
                    ]);
                    $move->canLearnFromLevel()->attach($request->input("pokemon_id"),["level" => $request->input("can_learn_level")]);
                }else if(key_exists("prefabbricato", $request->all())){
                    $request->validate([
                        "prefabbricato" => "required|integer",
                        "can_learn_level" => "required|integer",
                    ]);
    
                    $move = Move::find($request->input("prefabbricato"));
                    $move->canLearnFromLevel()->attach($request->input("pokemon_id"),["level" => $request->input("can_learn_level")]);
        
                }else{
                    $request->validate([
                        "name" => "required",
                        "description" => "required",
                        "type_id" => "required|integer",
                        "can_learn_level" => "required|integer",
                    ]);
                    $move = Move::create([
                        "name" => $request->input("name"),
                        "description" => $request->input("description"),
                        "type_id" => $request->input("type_id"),
                    ]);
                    $move->canLearnFromLevel()->attach($request->input("pokemon_id"),["level" => $request->input("can_learn_level")]);
                }
            }
        }else{
        $request->validate([
            "name" => "required",
            "type_id" => "required|integer",
            "rarity_id" => "required|integer",
        ]);

        $pokemon = Pokemon::create([
            "name" => $request->input("name"),
            "rarity_id" => $request->input("rarity_id"),
        ]);

        $pokemon->type()->attach($request->input("type_id"));
    }
        return redirect()->back();
    }

    public function editPokemon(Request $request){
        //return $request->all();
        if(key_exists("pokemon_id",$request->all())){
            if(key_exists("can_learn_mn_mt",$request->all())){
                $request->validate([
                    "can_learn_mn_mt" => "required|integer",
                    "old_move" => "required|string",
                ]);
                $move = Move::where("name","=",$request->input("old_move"))->get()->first();
                $move->canLearnFromMachine()->detach($move->id);
                $move = Move::find($request->input("can_learn_mn_mt"));
                $move->canLearnFromMachine()->attach($move->id);

            }else{
                $request->validate([
                    "prefabbricato" => "required|integer",
                    "old_prefabbricato" => "required|string",
                    "can_learn_level" => "required|integer",
                ]);
                
                $oldTool = Move::where("name","=",$request->input("old_prefabbricato"))->get()->first();
                
                $npc = Pokemon::find($request->input("pokemon_id"));
                $npc->canLearnFromLevel()->detach($oldTool->id);
                $npc->canLearnFromLevel()->attach($request->input("prefabbricato"),["level" => $request->input("can_learn_level")]);
            }
        }else{
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
        ]);

        Pokemon::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
        ]);
    }
        return redirect()->back();
    }

    public function deletePokemon(Request $request){

        if(key_exists("pokemon_id",$request->all())){
            if(key_exists("mnMt",$request->all()) && $request->input("mnMt") == 1){
                
                
    
                $move = Move::find($request->input("id"));
                $move->canLearnFromMachine()->detach($request->input("pokemon_id"));

            }else{
                $request->validate([
                    "pokemon_id" => "required|integer",
                ]);
    
                $npc = Pokemon::find($request->input("pokemon_id"));
                $npc->canLearnFromLevel()->detach($request->input("id"));
            }
        }else{
        $request->validate([
            "id" => "required|integer",
        ]);

        Pokemon::where("id", "=", $request->input("id"))->delete();
    }
        return redirect()->route("admin.pokemons");
    }

    public function boxes(Request $request){
        $tb = new BoxTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        $exemplaries = null;

        if($request->all() != [] && $request->all()["id"] != null){
            $exemplaries = new ExemplaryTable(mode:Mode::Box, boxId:$request->all()["id"]);
            return Inertia::render("Admin/Box",[
                'boxes' => $tb->get(),
                'dependencies' => DependeciesResolver::resolve($tb),
                'dependenciesName' => $tb->getDependencies(),
                'exemplaries' => $exemplaries->get(),
    
            ]);
        }

        return Inertia::render("Admin/Box",[
            'boxes' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addBox(Request $request){
        $request->validate([
            "name" => "required",
            "user_id" => "required|integer",
        ]);

        Box::create([
            "name" => $request->input("name"),
            "user_id" => $request->input("user_id"),
        ]);

        return redirect()->back();
    }

    

    public function editBox(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "user_id" => "required|integer",
        ]);

        Box::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "user_id" => $request->input("user_id"),
        ]);

        return redirect()->back();
    }

    public function deleteBox(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Box::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function effectivnesses(Request $request){
        $tb = new EffectivnessTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }
        return Inertia::render("Admin/Effectivnesses",[
            'effectivnesses' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addEffectivness(Request $request){

        $request->validate([
            "attacking_id" => "required|integer",
            "defending_id" => "required|integer",
            "multiplier" => "required|numeric",
        ]);

        // do the attach method to add the new effectiveness
        // the effectiveness table has id , attacking_type_id, defending_type_id, multiplier
        $attackingType = Type::find($request->input("attacking_id"));
        $attackingType->effectivenessOnAttack()->attach($request->input("defending_id"), ["multiplier" => $request->input("multiplier")]);

        return redirect()->back();
    }

    public function editEffectivness(Request $request){
        $request->validate([
            "id" => "required|integer",
            "multiplier" => "required|numeric",
            "attacking_id" => "required|integer",
            "defending_id" => "required|integer",
        ]);


        DB::table("effectiveness")->where("id", "=", $request->input("id"))->update([
            "multiplier" => $request->input("multiplier"),
            "attacking_type_id" => $request->input("attacking_id"),
            "defending_type_id" => $request->input("defending_id"),
        ]);

        return redirect()->back();
    }

    public function deleteEffectivness(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        //check if id is an array
        
        DB::table("effectiveness")->where("id", "=", $request->input("id"))->delete();
        

        return redirect()->back();
    }

    public function positions(Request $request){
        $tb = new PositionTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Posizioni",[
            'positions' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addPosition(Request $request){
        $request->validate([
            "x" => "required|integer",
            "y" => "required|integer",
        ]);

        Position::create([
            "x" => $request->input("x"),
            "y" => $request->input("y"),
        ]);

        return redirect()->back();
    }

    public function editPosition(Request $request){
        $request->validate([
            "id" => "required|integer",
            "x" => "required|integer",
            "y" => "required|integer",
        ]);

        Position::where("id", "=", $request->input("id"))->update([
            "x" => $request->input("x"),
            "y" => $request->input("y"),
        ]);

        return redirect()->back();
    }

    public function deletePosition(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Position::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function zones(Request $request){
        $tb = new ZonesTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Zone",[
            'zones' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addZone(Request $request){
        $request->validate([
            "name" => "required",
            "length" => "required|integer",
            "width" => "required|integer",
            "position_id" => "required|integer",
            "is_city" => "required|integer",
        ]);

        Zone::create([
            "name" => $request->input("name"),
            "length" => $request->input("length"),
            "width" => $request->input("width"),
            "position_id" => $request->input("position_id"),
            "is_city" => $request->input("is_city"),
        ]);

        return redirect()->back();
    }

    public function editZone(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "length" => "required|integer",
            "width" => "required|integer",
            "position_id" => "required|integer",
            "is_city" => "required|integer",
        ]);

        Zone::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "length" => $request->input("length"),
            "width" => $request->input("width"),
            "position_id" => $request->input("position_id"),
            "is_city" => $request->input("is_city"),
        ]);

        return redirect()->back();
    }

    public function deleteZone(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Zone::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function gyms(Request $request){
        $tb = new GymsTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Palestre",[
            'gyms' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addGym(Request $request){
        $request->validate([
            "zone_id" => "required|integer",
            "npc_id" => "required|integer",
            "position_id" => "required|integer",
            "type_id" => "required|integer",
        ]);

        $gym = Gym::create([
            "zone_id" => $request->input("zone_id"),
            "position_id" => $request->input("position_id"),
            "type_id" => $request->input("type_id"),
        ]);

        Npc::where("id", "=", $request->input("npc_id"))->update([
            "gym_id" => $gym->id,
        ]);

        return redirect()->back();
    }

    public function editGym(Request $request){
        $request->validate([
            "id" => "required|integer",
            "zone_id" => "required|integer",
            "npc_id" => "required|integer",
            "position_id" => "required|integer",
            "type_id" => "required|integer",
        ]);

        Gym::where("id", "=", $request->input("id"))->update([
            "zone_id" => $request->input("zone_id"),
            "position_id" => $request->input("position_id"),
            "type_id" => $request->input("type_id"),
        ]);

        Npc::where("id", "=", $request->input("npc_id"))->update([
            "gym_id" => $request->input("id"),
        ]);

        return redirect()->back();
    }

    public function deleteGym(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);



        Gym::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function nature(Request $request){
        $tb = new NatureTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Nature",[
            'natures' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addNature(Request $request){
        $request->validate([
            "name" => "required",
            "description" => "required",
        ]);

        Nature::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
        ]);

        return redirect()->back();
    }

    public function editNature(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "description" => "required",
        ]);

        Nature::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
        ]);

        return redirect()->back();
    }   

    public function deleteNature(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Nature::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function tools(Request $request){
        $tb = new BattleToolTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/OggettiDaBattaglia",[
            'tools' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addTool(Request $request){
        if(key_exists("state_id", $request->all()) && !key_exists("prefabbricato", $request->all())){
            $request->validate([
                "name" => "required",
                "description" => "required",
                "healthRecovery" => "required|integer",
                "state_id" => "required|integer",
            ]);
            $tb=BattleTool::create([
                "name" => $request->input("name"),
                "description" => $request->input("description"),
                "healthRecovery" => $request->input("healthRecovery"),
            ]);
            $tb->statesRecovery()->attach($request->input("state_id"));
            
        }else if(key_exists("prefabbricato", $request->all()) && key_exists("state_id", $request->all())){
            $request->validate([
                "prefabbricato" => "required|integer",
                "state_id" => "required|integer",
            ]);

            $tb = BattleTool::find($request->input("prefabbricato"));
            $tb->statesRecovery()->attach($request->input("state_id"));
        }else{
            $request->validate([
                "name" => "required",
                "description" => "required",
                "healthRecovery" => "required|integer",
            ]);
            BattleTool::create([
                "name" => $request->input("name"),
                "description" => $request->input("description"),
                "healthRecovery" => $request->input("healthRecovery"),
            ]);
        }


        return redirect()->back();
    }

    public function editTool(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "description" => "required",
            "healthRecovery" => "required|integer",
        ]);

        $bt=BattleTool::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "healthRecovery" => $request->input("healthRecovery"),
        ]);

        if(key_exists("state_id", $request->all())){
            $bt->statesRecovery()->attach($request->input("state_id"));
        }

        return redirect()->back();
    }

    public function deleteTool(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        BattleTool::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    private function putTogheterDepencencies($table1,$table2){
        //return a object with the dependencies of the two tables
        $dp1 = DependeciesResolver::resolve($table1);
        $dp2 = DependeciesResolver::resolve($table2);
        $dependencies = [];
        foreach($dp1 as $key => $value){
            $dependencies[$key] = $value;
        }
        foreach($dp2 as $key => $value){
            $dependencies[$key] = $value;
        }
        return $dependencies;
    }

    private function putTogheterDepencenciesNames($table1,$table2){
        //return a object with the dependencies of the two tables
        $dp1 = $table1->getDependencies();
        $dp2 = $table2->getDependencies();
        $dependencies = [];
        foreach($dp1 as $key => $value){
            array_push($dependencies,$value);
        }
        foreach($dp2 as $key => $value){
            array_push($dependencies,$value);
        }
        return $dependencies;
    }
    
    public function battles(Request $request){
        
        $tb = new BattleTable();
        if($request->all() != [] &&key_exists("id",$request->all())&& $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        if(key_exists("battle_id", $request->all()) && $request->all()["battle_id"] != null){
            $singlePokemonBattle = new SinglePokemonBattleTable(SingleBattleMode::GivenBattleId, $request->all()["battle_id"]);
            if(key_exists("exemplary_id", $request->all()) && $request->all()["exemplary_id"] != null){
                $exemplary = new ExemplaryTable(mode:Mode::SingleExemplary, SingleExemplaryId:$request->all()["exemplary_id"]);
                return Inertia::render("Admin/Battaglie",[
                    'battles' => $tb->get(),
                    'dependencies' => $this->putTogheterDepencencies($tb, $singlePokemonBattle),
                    'dependenciesName' => $this->putTogheterDepencenciesNames($tb, $singlePokemonBattle),
                    'pokemonBattles' => $singlePokemonBattle->get(),
                    'exemplary' => $exemplary->get(),
                ]);
            }
            return Inertia::render("Admin/Battaglie",[
                'battles' => $tb->get(),
                'dependencies' => $this->putTogheterDepencencies($tb, $singlePokemonBattle),
                'dependenciesName' => $this->putTogheterDepencenciesNames($tb, $singlePokemonBattle),
                'pokemonBattles' => $singlePokemonBattle->get(),
            ]);
        }   

        return Inertia::render("Admin/Battaglie",[
            'battles' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addBattle(Request $request){
        if(key_exists("exemplary1",$request->all()) && key_exists("exemplary2",$request->all())){
            $request->validate([
                "battle_id" => "required|integer",
                "exemplary1" => "required|integer",
                "exemplary2" => "required|integer",
                "winner" => "required|integer",
            ]);

            if($request->input("winner") != 1 && $request->input("winner") != 2){
                return redirect()->back()->withErrors(["winner" => "The winner must be 1 or 2"]);
            }
            
            BattleRegistry::create([
                "battle_id" => $request->input("battle_id"),
                "exemplary1_id" => $request->input("exemplary1"),
                "exemplary2_id" => $request->input("exemplary2"),
                "winner" => $request->input("winner"),
            ]);
        }else{
            $request->validate([
                "date" => "required|date",
                "winner" => "required|integer",
                "user_1" => "required|integer",
                "user_2" => "required|integer",
            ]);
    
            if($request->input("winner") != 1 && $request->input("winner") != 2){
                return redirect()->back()->withErrors(["winner" => "The winner must be 1 or 2"]);
            }
    
            $battle = Battle::create([
                "date" => $this->resolveDate($request->input("date")),
                "winner" => $request->input("winner"),
                "user_1" => $request->input("user_1"),
                "user_2" => $request->input("user_2"),
    
            ]);
        }

        return redirect()->back();
    }

    public function editBattle(Request $request){
        if(key_exists("exemplary1",$request->all()) && key_exists("exemplary2",$request->all())){
            $request->validate([
                "battle_id" => "required|integer",
                "exemplary1" => "required|integer",
                "exemplary2" => "required|integer",
                "winner" => "required|integer",
            ]);

            BattleRegistry::where("id", "=", $request->input("id"))->update([
                "exemplary1_id" => $request->input("exemplary1"),
                "exemplary2_id" => $request->input("exemplary2"),
                "winner" => $request->input("winner"),
            ]);

        }else{
            $request->validate([
                "id" => "required|integer",
                "date" => "required|date",
                "winner" => "required|integer",
                "user_1" => "required|integer",
                "user_2" => "required|integer",
            ]);
            if($request->input("winner") != $request->input("user_1") && $request->input("winner") != $request->input("user_2")){
                return redirect()->back();
            }
    
            Battle::where("id", "=", $request->input("id"))->update([
                "date" => $this->resolveDate($request->input("date")),
                "winner" => $request->input("winner"),
                "user_1" => $request->input("user_1"),
                "user_2" => $request->input("user_2"),
            ]);
        }


        return redirect()->back();
    }

    public function deleteBattle(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);
        if(key_exists("headers",$request->all()) && $request->all()["headers"][1] == "Exemplary 1 Level"){
            BattleRegistry::where("id", "=", $request->input("id"))->delete();
        }else{
            Battle::where("id", "=", $request->input("id"))->delete();
        }

        return redirect()->back();
    }

    public function rarities(Request $request){
        $tb = new RaritiesTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Rarita",[
            'rarities' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addRarity(Request $request){
        $request->validate([
            "name" => "required",
        ]);

        Rarity::create([
            "name" => $request->input("name"),
        ]);

        return redirect()->back();
    }

    public function editRarity(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
        ]);

        Rarity::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
        ]);

        return redirect()->back();
    }

    public function deleteRarity(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Rarity::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function npcs(Request $request){
        $tb = new NpcTable();
        //check if the request contains a query for the battle_tools table

        if($request->all() != [] && key_exists("id",$request->all()) &&  $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        $selectAllTheZonesThatHaveGyms = Zone::whereHas("gym", function($query){
            $query->where("id", ">", 0);
        })->get();
        $invetory = null;
        $dp = DependeciesResolver::resolve($tb);
        // set the Zone key of the dp to the zones that have gyms
        $dpNames = $tb->getDependencies();
        if ($request->all() != [] && key_exists("npc_id", $request->all()) && $request->all()["npc_id"] != null){
            $invetory = new BattleToolTable(mode:BattleToolMode::ofNpc, id:$request->all()["npc_id"]);
            $dp = $this->putTogheterDepencencies($tb, $invetory);
            $dpNames = $this->putTogheterDepencenciesNames($tb, $invetory);
            $invetory->setPerPage(count($invetory->get()));
            $invetory = $invetory->get();
        }
        $dp["Zone"] = $selectAllTheZonesThatHaveGyms;

        return Inertia::render("Admin/Npc",[
            'npcs' => $tb->get(),
            'dependencies' => $dp,
            'dependenciesName' => $dpNames,
            'inventory' => $invetory,
        ]);
    }

    public function addNpc(Request $request){
        
        if(key_exists("npc_id",$request->all())){
            if(!key_exists("prefabbricato", $request->all())){
                $request->validate([
                    "name" => "required",
                    "description" => "required",
                    "healthRecovery" => "required|integer",
                    "state_id" => "required|integer",
                ]);
                $tb=BattleTool::create([
                    "name" => $request->input("name"),
                    "description" => $request->input("description"),
                    "healthRecovery" => $request->input("healthRecovery"),
                ]);
                $tb->statesRecovery()->attach($request->input("state_id"));
                $npc = Npc::find($request->input("npc_id"));
                $npc->battleTools()->attach($tb->id,["amount" => $request->input("amount")]);
            }else if(key_exists("prefabbricato", $request->all())){
                $request->validate([
                    "prefabbricato" => "required|integer",
                ]);
    
                $tb = BattleTool::find($request->input("prefabbricato"));
                $npc = Npc::find($request->input("npc_id"));
                $npc->battleTools()->attach($tb->id,["amount" => $request->input("amount")]);
            }else{
                $request->validate([
                    "name" => "required",
                    "description" => "required",
                    "healthRecovery" => "required|integer",
                ]);
                $bt = BattleTool::create([
                    "name" => $request->input("name"),
                    "description" => $request->input("description"),
                    "healthRecovery" => $request->input("healthRecovery"),
                ]);

                $npc = Npc::find($request->input("npc_id"));
                $npc->battleTools()->attach($bt->id,["amount" => $request->input("amount")]);
            }
        }else{
            $request->validate([
                "name" => "required",
                "isGymLeader" => "required|integer",
                "position" => "required|integer",
            ]);
    
    
            Npc::create([
                "name" => $request->input("name"),
                "gym_id" => $request->input("gym"),
                "position_id" => $request->input("position"),
                "is_gym_leader" => $request->input("isGymLeader"),
            ]);
        }


        return redirect()->back();
    }

    public function editNpc(Request $request){
        if(key_exists("npc_id",$request->all())){
            $request->validate([
                "prefabbricato" => "required|integer",
                "old_prefabbricato" => "required|string",
                "amount" => "required|integer",
            ]);
            
            $oldTool = BattleTool::where("name","=",$request->input("old_prefabbricato"))->get()->first();
            
            $npc = Npc::find($request->input("npc_id"));
            $npc->battleTools()->detach($oldTool->id);
            $npc->battleTools()->attach($request->input("prefabbricato"),["amount" => $request->input("amount")]);
        }else{
            $request->validate([
                "id" => "required|integer",
                "name" => "required",
                "position" => "required|integer",
            ]);

            Npc::where("id", "=", $request->input("id"))->update([
                "name" => $request->input("name"),
                "gym_id" => $request->input("gym"),
                "position_id" => $request->input("position"),
                "is_gym_leader" => $request->input("isGymLeader"),
            ]);
        }
        return redirect()->back();
    }

    public function deleteNpc(Request $request){
        if(key_exists("npc_id",$request->all())){

            $request->validate([
                "npc_id" => "required|integer",
            ]);

            $npc = Npc::find($request->input("npc_id"));
            $npc->battleTools()->detach($request->input("id"));
        }else{
            $request->validate([
                "id" => "required|integer",
            ]);

            Npc::where("id", "=", $request->input("id"))->delete();
        }

        return redirect()->back();
    }

    public function mnmts(Request $request){
        $tb = new MnMtTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/MnMt",[
            'mnmts' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addMnMt(Request $request){
        $request->validate([
            "number" => "required",
            "description" => "required",
            "move_id" => "required|integer",
            "isMn" => "required|integer",
        ]);

        MnMt::create([
            "number" => $request->input("number"),
            "description" => $request->input("description"),
            "move_id" => $request->input("move_id"),
            "is_mn" => $request->input("isMn"),
        ]);

        return redirect()->back();
    }

    public function editMnMt(Request $request){
        $request->validate([
            "id" => "required|integer",
            "number" => "required",
            "description" => "required",
            "move_id" => "required|integer",
            "isMn" => "required|integer",
        ]);

        MnMt::where("id", "=", $request->input("id"))->update([
            "number" => $request->input("number"),
            "description" => $request->input("description"),
            "move_id" => $request->input("move_id"),
            "is_mn" => $request->input("isMn"),
        ]);

        return redirect()->back();
    }

    public function deleteMnMt(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        MnMt::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function states(Request $request){
        $tb = new StateTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Stati",[
            'states' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addState(Request $request){
        $request->validate([
            "name" => "required",
            "description" => "required",
        ]);

        State::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
        ]);

        return redirect()->back();
    }

    public function editState(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "description" => "required",
        ]);

        State::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
        ]);

        return redirect()->back();
    }

    public function deleteState(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        State::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function storyTools(Request $request){
        $tb = new StoryToolTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/StrumentiStoria",[
            'storyTools' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addStoryTool(Request $request){
        $request->validate([
            "name" => "required",
            "description" => "required",
        ]);

        $tb=StoryTool::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
        ]);

        return redirect()->back();
    }

    public function editStoryTool(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "description" => "required",
        ]);

        $bt=StoryTool::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
        ]);

        return redirect()->back();
    }

    public function deleteStoryTool(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        StoryTool::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function teams(Request $request){
        $tb = new ExemplaryTable(mode:Mode::TEAM,userId:$request->input("user_id"));
        if($request->all() != [] && key_exists("id",$request->all()) && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render("Admin/Squadre",[
            'teams' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function deleteTeam(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Exemplary::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function captures(Request $request){
        $tb = new CaptureTable();
        if($request->all() != [] && key_exists("id",$request->all()) && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        $dp = DependeciesResolver::resolve($tb);

        $exemplariesThatAreOriginal = Exemplary::whereNull("exemplary_id")->get();
        $dp["Exemplary"] = $exemplariesThatAreOriginal;

        return Inertia::render("Admin/Catture",[
            'captures' => $tb->get(),
            'dependencies' => $dp,
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function deleteCapture(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Captured::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }

    public function addCapture(Request $request){
        $request->validate([
            "date" => "required|date",
            "exemplary_id" => "required|integer",
            "zone_id" => "required|integer",
            "user_id" => "required|integer",
        ]);

        $ex = Exemplary::find($request->input("exemplary_id"));
        $pokemon = Pokemon::find($ex->pokemon_id);
        $zone = Zone::find($request->input("zone_id"));

        //check if the pokemon can be captured in that zone
        $isFoundInZone = $pokemon->zone()->where('zone_id', $zone->id)->exists();

        if(!$isFoundInZone){
            return redirect()->back()->withErrors(["error" => "Il pokemon non può essere catturato in questa zona"]);
        }

        Captured::create([
            "date" => $this->resolveDate($request->input("date")),
            "exemplary_id" => $request->input("exemplary_id"),
            "zone_id" => $request->input("zone_id"),
            "user_id" => $request->input("user_id"),
        ]);

        return redirect()->back();
    }

    public function editCapture(Request $request){
        $request->validate([
            "id" => "required|integer",
            "date" => "required|date",
            "exemplary_id" => "required|integer",
            "zone_id" => "required|integer",
            "user_id" => "required|integer",
        ]);

        $ex = Exemplary::find($request->input("exemplary_id"));
        $pokemon = Pokemon::find($ex->pokemon_id);
        $zone = Zone::find($request->input("zone_id"));

        //check if the pokemon can be captured in that zone
        $isFoundInZone = $pokemon->zone()->where('zone_id', $zone->id)->exists();

        if(!$isFoundInZone){
            return redirect()->back()->withErrors(["error" => "Il pokemon non può essere catturato in questa zona"]);
        }

        Captured::where("id", "=", $request->input("id"))->update([
            "date" => $this->resolveDate($request->input("date")),
            "exemplary_id" => $request->input("exemplary_id"),
            "zone_id" => $request->input("zone_id"),
            "user_id" => $request->input("user_id"),
        ]);

        return redirect()->back();
    }



    private function resolveDate($date){
        return explode("T", $date)[0];
    }
}
