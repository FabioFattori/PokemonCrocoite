<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\BattleRegistry;
use App\Models\Battles;
use App\Models\BattleTool;
use App\Models\Box;
use App\Models\User;
use App\Tables\BattleTable;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use App\Tables\SinglePokemonBattleTable;
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
use App\Models\State;
use App\Models\StateBattleTool;
use App\Models\Team;
use App\Models\Type;
use App\Models\Zone;
use App\Tables\BattleToolTable;
use App\Tables\BoxTable;
use App\Tables\Class\DependeciesResolver;
use App\Tables\EffectivnessTable;
use App\Tables\GendersTable;
use App\Tables\GymsTable;
use App\Tables\MovesMode;
use App\Tables\MovesTable;
use App\Tables\NatureTable;
use App\Tables\PokemonTable;
use App\Tables\PositionTable;
use App\Tables\SingleBattleMode;
use App\Tables\ZonesTable;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;
use PhpParser\Node\Stmt\Return_;

class AdminController extends Controller
{
    public function Users(Request $request){
        $tb = new UserTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }


        return Inertia::render('Admin/Utenti', [
            'users' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addUser(Request $request){
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

        return redirect()->route("admin.users");
    }

    public function editUser(Request $request){
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

        return redirect()->route("admin.users");
    }

    public function deleteUser(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        User::where("id", "=", $request->input("id"))->delete();

        return redirect()->route("admin.users");
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

        Exemplary::create([
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
        ]);
        
        return redirect()->route("admin.exemplaries");
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
        ]);

        Move::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "type_id" => $request->input("type_id"),
        ]);

        return redirect()->route("admin.moves");
    }

    public function editMove(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
            "description" => "required",
            "type_id" => "required|integer",
        ]);

        Move::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "type_id" => $request->input("type_id"),
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
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        

        return Inertia::render("Admin/Razze",[
            'pokemon' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function addPokemon(Request $request){
        $request->validate([
            "name" => "required",
            "type_id" => "required|integer",
        ]);

        $pokemon = Pokemon::create([
            "name" => $request->input("name"),
        ]);

        $pokemon->type()->attach($request->input("type_id"));

        return redirect()->back();
    }

    public function editPokemon(Request $request){
        $request->validate([
            "id" => "required|integer",
            "name" => "required",
        ]);

        Pokemon::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
        ]);

        return redirect()->back();
    }

    public function deletePokemon(Request $request){
        $request->validate([
            "id" => "required|integer",
        ]);

        Pokemon::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
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
        ]);

        Zone::create([
            "name" => $request->input("name"),
            "length" => $request->input("length"),
            "width" => $request->input("width"),
            "position_id" => $request->input("position_id"),
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
        ]);

        Zone::where("id", "=", $request->input("id"))->update([
            "name" => $request->input("name"),
            "length" => $request->input("length"),
            "width" => $request->input("width"),
            "position_id" => $request->input("position_id"),
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
        ]);

        $gym = Gym::create([
            "zone_id" => $request->input("zone_id"),
            "position_id" => $request->input("position_id"),
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
        ]);

        Gym::where("id", "=", $request->input("id"))->update([
            "zone_id" => $request->input("zone_id"),
            "position_id" => $request->input("position_id"),
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
    
            if($request->input("winner") != $request->input("user_1") && $request->input("winner") != $request->input("user_2")){
                return redirect()->back();
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

        Battle::where("id", "=", $request->input("id"))->delete();

        return redirect()->back();
    }


    private function resolveDate($date){
        return explode("T", $date)[0];
    }
}
