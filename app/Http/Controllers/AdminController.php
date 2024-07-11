<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\User;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Tables\UserTable;
use Illuminate\Support\Facades\Hash;
use App\Models\Exemplary;
use App\Models\Gender;
use App\Models\Gym;
use App\Models\Move;
use App\Models\Npc;
use App\Models\Pokemon;
use App\Models\Position;
use App\Models\Team;
use App\Models\Type;
use App\Models\Zone;
use App\Tables\BoxTable;
use App\Tables\Class\DependeciesResolver;
use App\Tables\EffectivnessTable;
use App\Tables\GendersTable;
use App\Tables\GymsTable;
use App\Tables\MovesTable;
use App\Tables\PokemonTable;
use App\Tables\PositionTable;
use App\Tables\ZonesTable;
use Mockery\Undefined;

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

        User::create([
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
            "position_id" => $request->input("position_id"),
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

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
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
            "catchDate" => "required|date",
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
            "catchDate" => $this->resolveDate($request->input("catchDate")),
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
            "attacking_type_id" => "required|integer",
            "defending_type_id" => "required|integer",
            "multiplier" => "required|numeric",
        ]);

        Type::find($request->input("attacking_type_id"))->effectiveness()->attach($request->input("defending_type_id"), ["multiplier" => $request->input("multiplier")]);

        return redirect()->back();
    }

    public function editEffectivness(Request $request){
        $request->validate([
            "attacking_type_id" => "required|integer",
            "defending_type_id" => "required|integer",
            "multiplier" => "required|numeric",
        ]);

        Type::find($request->input("attacking_type_id"))->effectiveness()->updateExistingPivot($request->input("defending_type_id"), ["multiplier" => $request->input("multiplier")]);

        return redirect()->back();
    }

    public function deleteEffectivness(Request $request){
        $request->validate([
            "attacking_type_id" => "required|integer",
            "defending_type_id" => "required|integer",
        ]);

        Type::find($request->input("attacking_type_id"))->effectiveness()->detach($request->input("defending_type_id"));

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



    private function resolveDate($date){
        return explode("T", $date)[0];
    }
}
