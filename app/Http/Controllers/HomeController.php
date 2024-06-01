<?php

namespace App\Http\Controllers;

use App\Models\Exemplary;
use App\Tables\UserTable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request){
        $table = new UserTable();

        if ($request->all() != []) {
            $table->setConfigObject($request->all());
        } else {
            $table->setConfigObject([
                "sorts" => [
                ],
                "filters" => [
                ],
                "page" => 1,
                "perPage" => 5
            ]);
        }

        return Inertia::render('Home', ['users' => $table->get(), 'exemplaries' => Exemplary::all()]);
    }
}
