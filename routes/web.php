<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DBController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeedController;
use App\Tables\ExemplaryTable;
use App\Tables\UserTable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::match(['GET', 'POST'], '/', [HomeController::class, "index"])->name("home.get");

Route::get('/login', [LoginController::class, "index"])->name("login.log");

Route::get('/logAdmin',[LoginController::class, "admin"])->name('login.admin');

Route::get('/tryLogin', [LoginController::class, "tryLogin"])->name("login.try");

Route::get('/logout', [LoginController::class, "logout"])->name("logout");

Route::post('/register', [LoginController::class, "register"])->name("register");

Route::post('/registerAdmin', [LoginController::class, "registerAdmin"])->name("registerAdmin");

Route::get("/seedUsers", [SeedController::class, "users"])->name("seed.users");


Route::prefix("api")->group(function () {
    Route::get("/seed/pokemon", [SeedController::class, "basePokemon"])->name("api.seed.pokemon");
    Route::get("/pokemons", function () {
        $table = new ExemplaryTable();
        $table->setConfigObject([
            "sorts" => [
                [
                    "columnName" => "level",
                    "direction" => "DESC"
                ]
            ],
            "filters" => [
                [
                    "columnName" => "level",
                    "value" => 1
                ],
                [
                    "columnName" => "pokemonName",
                    "value" => "1282279348"
                ]
            ],
            "page" => 1,
            "perPage" => 10
        ]);
        return response()->json(["table" => $table->get()]);
    })->name("api.pokemon");
});


Route::get("db", [DBController::class, "index"])->name("db.index");


Route::prefix("admin")->group(function () {
    Route::match(['GET', 'POST'],"/users", [AdminController::class, "Users"])->name("admin.users");
    // Route::get("/profile", [ProfileController::class, "index"])->name("admin.profile");
    // Route::get("/profile/{id}", [ProfileController::class, "show"])->name("admin.profile.show");
    // Route::get("/profile/{id}/edit", [ProfileController::class, "edit"])->name("admin.profile.edit");
    // Route::post("/profile/{id}/edit", [ProfileController::class, "update"])->name("admin.profile.update");
    //Route::get("/profile/{id}/delete", [ProfileController::class, "delete"])->name("admin.profile.delete");
    Route::match(['GET', 'POST'],"/exemplaries",[AdminController::class, "Exemplaries"])->name("admin.exemplaries");
});
 