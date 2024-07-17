<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Exemplary;
use App\Models\Team;
use App\Tables\BattleMode;
use App\Tables\BattleTable;
use App\Tables\BattleToolMode;
use App\Tables\BattleToolTable;
use App\Tables\BoxMode;
use App\Tables\BoxTable;
use App\Tables\CaptureMode;
use App\Tables\CaptureTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use App\Tables\Class\DependeciesResolver;
use App\Tables\MnMtMode;
use App\Tables\MnMtTable;
use App\Tables\MovesMode;
use App\Tables\MovesTable;
use App\Tables\SingleBattleMode;
use App\Tables\SinglePokemonBattleTable;
use App\Tables\StoryToolMode;
use App\Tables\StoryToolTable;
use TeamTable;

class  UserController extends Controller
{


    public function teams(Request $request){
        if(auth()->user() == null){
            return redirect()->route('login.log');
        }
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

        $user = auth()->user();
        
        $nExeInTeam = Exemplary::all()->whereNull("exemplary_id");
        $nExeInTeam = $nExeInTeam->where("team_id", Team::where("user_id", $user->id)->first()->id)->count();

        if($nExeInTeam == 1){
            return redirect()->back()->withErrors(['user_id' => 'Hai solo questo esemplare nel team, non puoi giocare senza pokemon']);
        }else{
            $ex->team_id = null;
            $ex->box_id = $box->id;
            $ex->save();
        }
       
        return redirect()->back()->with('success', 'Il Pokemon è stato aggiunto al box');
    }

    public function captures(Request $request){
        $tb = new CaptureTable(mode:CaptureMode::ofUser,userId:auth()->user()->id);

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render('Users/Catture', [
            'captures' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function battles(Request $request){
        $tb = new BattleTable(mode:BattleMode::USER,userId:auth()->user()->id);

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render('Users/Battaglie', [
            'battles' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
    }

    public function singleBattle(Request $request){
        $request->validate([
            'id' => 'required|integer',
        ]);

        $tb = new SinglePokemonBattleTable(SingleBattleMode::GivenBattleId,$request->id);

        if($request->all() != [] && key_exists("id",$request->all()) && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }
        $ex = null;
        if(key_exists("exemplary_id",$request->all())){
            $ex1 = new ExemplaryTable(mode:Mode::SingleExemplary,SingleExemplaryId:$request->exemplary_id["exemplary1"]);
            $ex2 = new ExemplaryTable(mode:Mode::SingleExemplary,SingleExemplaryId:$request->exemplary_id["exemplary2"]);
            $ex = [
                 $ex1->get(),
                 $ex2->get(),
            ];
        }

        return Inertia::render('Users/SingleBattle', [
            'battles' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
            'battle_id' => $request->id,
            'exemplary' => $ex,
        ]);
    }

    public function bag(Request $request){
        $user = auth()->user();

        $mnMT = new MnMtTable(MnMtMode::ofUser,$user->id);

        if($request->all() != [] && $mnMT->equalsById($request->all()["id"])){
            $mnMT->setConfigObject($request->all());
        }

        $story = new StoryToolTable(StoryToolMode::ofUser,$user->id);

        if($request->all() != [] && $story->equalsById($request->all()["id"])){
            $story->setConfigObject($request->all());
        }

        $battleTool = new BattleToolTable(BattleToolMode::ofUser,$user->id);

        if($request->all() != [] && $battleTool->equalsById($request->all()["id"])){
            $battleTool->setConfigObject($request->all());
        }

        return Inertia::render('Users/Bag', [
            'mnMT' => $mnMT->get(),
            'dependencies' => DependeciesResolver::resolve($mnMT),
            'dependenciesName' => $mnMT->getDependencies(),
            'story' => $story->get(),
            'battleTool' => $battleTool->get(),
        ]);


    }


    public function moves(Request $request){
        $request->validate([
            'id' => 'required|integer',
        ]);

        $tb = new MovesTable(MovesMode::getMovesFromExemplaryId,$request->id);

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }

        return Inertia::render('Users/Mosse', [
            'moves' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);


    }
}
