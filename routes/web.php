<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeedController;
use App\Tables\ExemplaryTable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home',['users' => App\Models\User::all(), 'exemplaries' => App\Models\Exemplary::all()]);
});


Route::prefix("api")->group(function () {
    Route::get("/seed/pokemon", [SeedController::class, "basePokemon"])->name("api.seed.pokemon");
    Route::get("/pokemons", function () {
        $table = new ExemplaryTable();        
        return response()->json(["table" => $table->get()]);
    
    })->name("api.pokemon");
});