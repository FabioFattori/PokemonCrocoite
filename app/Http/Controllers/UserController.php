<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use App\Tables\Class\DependeciesResolver;
use TeamTable;

class  UserController extends Controller
{
    public function exemplaries(Request $request){
        $tb = new ExemplaryTable(mode:Mode::USER);

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }
        return Inertia::render('Users/Esemplari', [
            'exemplaries' => $tb->get(),
            'dependencies' => DependeciesResolver::resolve($tb),
            'dependenciesName' => $tb->getDependencies(),
        ]);
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
        ]);
    }
}
