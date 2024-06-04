<?php

namespace App\Http\Controllers;

use App\Tables\ExemplaryTable;
use App\Tables\Mode;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Tables\UserTable;

class AdminController extends Controller
{
    public function Users(Request $request){
        $tb = new UserTable();
        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }


        return Inertia::render('Admin/Utenti', [
            'users' => $tb->get()
        ]);
    }

    public function Exemplaries(Request $request){
        $tb = new ExemplaryTable(mode:Mode::ADMIN);

        if($request->all() != [] && $tb->equalsById($request->all()["id"])){
            $tb->setConfigObject($request->all());
        }
        return Inertia::render('Admin/Esemplari', [
            'exemplaries' => $tb->get()
        ]);
    }
}
