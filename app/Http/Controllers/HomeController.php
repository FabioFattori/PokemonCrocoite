<?php

namespace App\Http\Controllers;

use App\Models\Exemplary;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use App\Tables\UserTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\DBController;

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

            return Inertia::render('Home', [ 'user' => $user , "mode" => "admin"]);
        }

        
    }
}
