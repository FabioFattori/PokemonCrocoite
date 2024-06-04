<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Tables\UserTable;
use Illuminate\Support\Facades\Hash;
use App\Models\Exemplary;
use App\Tables\Class\DependeciesResolver;

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
            "user_id" => "required|integer",
            "speed" => "required|integer",
            "attack" => "required|integer",
            "defense" => "required|integer",
            "specialAttack" => "required|integer",
            "specialDefense" => "required|integer",
            "ps" => "required|integer",
            "catchDate" => "required|date",
        ]);

        Exemplary::create([
            "level" => $request->input("level"),
            "user_id" => $request->input("user_id"),
            "speed" => $request->input("speed"),
            "attack" => $request->input("attack"),
            "defense" => $request->input("defense"),
            "specialAttack" => $request->input("specialAttack"),
            "specialDefense" => $request->input("specialDefense"),
            "ps" => $request->input("ps"),
            "catchDate" => $request->input("catchDate"),
            "pokemon_id" => $request->input("pokemon_id"),
        ]);
        
        return redirect()->route("admin.exemplaries");
    }
}
