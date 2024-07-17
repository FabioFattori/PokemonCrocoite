<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Exemplary;
use App\Models\Team;
use App\Tables\BoxMode;
use App\Tables\BoxTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use App\Tables\Class\DependeciesResolver;
use TeamTable;

class  UserController extends Controller
{
    public function freePokemon(Request $request){
        $request->validate([
            'id' => 'required|integer',
        ]);

        Exemplary::find($request->id)->delete();

        return redirect()->back()->with('success', 'Il Pokemon è stato liberato con successo ; (');
    }


    public function teams(Request $request){
        $tb = new ExemplaryTable(mode:Mode::TEAM);

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render('Users/Team', [
            'teams' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
            'Box' => Box::all()->where('user_id', auth()->user()->id),
        ]);
    }

    public function boxes(Request $request){
        if(auth()->user() == null){
            return redirect()->route('login.log');
        }
        $tb = new BoxTable(mode:BoxMode::ofUser,userId:auth()->user()->id);

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render('Users/Box', [
            'boxes' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function exemplariesInBox(Request $request){
        $request->validate([
            'id' => 'required|integer',
        ]);

        $tb = new ExemplaryTable(mode:Mode::Box,boxId:$request->id);

        


        return Inertia::render('Users/EsemplariInBox', [
            'EsemplariInBox' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
            't1' => "Esemplari contenuti nel box ". Box::find($request->id)->name,
            't2' => "Esemplari",
        ]);
    }

    public function exemplaryInTeam(Request $request){
        $request->validate([
            'id' => 'required|integer',
        ]);

        $ex = Exemplary::find($request->id);

        $user = auth()->user();

        //check if the team has >6 exemplaries already
        $nExeInTeam = Exemplary::all()->whereNull("exemplary_id");
        $nExeInTeam = $nExeInTeam->where("team_id", Team::where("user_id", $user->id)->first()->id)->count();
        
        if($nExeInTeam == 6){
            return redirect()->back()->withErrors(['user_id' => 'Il team ha già 6 esemplari']);
        }else{
            $ex->team_id = $user->getTeamId();
            $ex->box_id = null;
            $ex->save();
        }
        return redirect()->back()->with('success', 'Il Pokemon è stato aggiunto al team');
    }

    public function exemplaryInBox(Request $request){
        $request->validate([
            'box_id' => 'required|integer',
            'exemplary_id' => 'required|integer',
        ]);

        $ex = Exemplary::find($request->exemplary_id);
        $box = Box::find($request->box_id);

        $ex->team_id = null;
        $ex->box_id = $box->id;
        $ex->save();
       
        return redirect()->back()->with('success', 'Il Pokemon è stato aggiunto al box');
    }
}
