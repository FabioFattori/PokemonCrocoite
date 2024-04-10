<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeedController;
use App\Tables\ExemplaryTable;
use App\Tables\UserTable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $table = new UserTable();
    return Inertia::render('Home',['users' => $table->get(), 'exemplaries' => App\Models\Exemplary::all()]);
});

Route::get("/seedUsers", [SeedController::class, "users"])->name("seed.users");


Route::prefix("api")->group(function () {
    Route::get("/seed/pokemon", [SeedController::class, "basePokemon"])->name("api.seed.pokemon");
    Route::get("/pokemons", function () {
        $table = new ExemplaryTable();        
        return response()->json(["table" => $table->get()]);
    
    })->name("api.pokemon");
});