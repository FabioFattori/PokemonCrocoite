<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DBController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeedController;
use App\Http\Controllers\UserController;
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

    Route::get("/seed/all", [SeedController::class, "all"])->name("api.seed.all");
});


Route::get("db", [DBController::class, "index"])->name("db.index");


Route::prefix("admin")->group(function () {
    Route::match(['GET', 'POST'],"/users", [AdminController::class, "Users"])->name("admin.users");
    Route::post("/users/Add", [AdminController::class, "addUser"])->name("admin.users.add");
    Route::post("/users/Edit", [AdminController::class, "editUser"])->name("admin.users.edit");
    Route::post("/users/Delete", [AdminController::class, "deleteUser"])->name("admin.users.delete");
    Route::post("/exemplaries/Add", [AdminController::class, "addEmplaries"])->name("admin.exemplaries.add");
    Route::post("/exemplaries/Edit", [AdminController::class, "editEmplaries"])->name("admin.exemplaries.edit");
    Route::post("/exemplaries/Delete", [AdminController::class, "deleteEmplaries"])->name("admin.exemplaries.delete");
    Route::post("/moves/Add", [AdminController::class, "addMove"])->name("admin.moves.add");
    Route::post("/moves/Edit", [AdminController::class, "editMove"])->name("admin.moves.edit");
    Route::post("/moves/Delete", [AdminController::class, "deleteMove"])->name("admin.moves.delete");
    Route::match(['GET', 'POST'],"/moves",[AdminController::class, "Moves"])->name("admin.moves");
    Route::post("/genders/Add", [AdminController::class, "addGender"])->name("genders.add");
    Route::post("/genders/Edit", [AdminController::class, "editGender"])->name("genders.edit");
    Route::post("/genders/Delete", [AdminController::class, "deleteGender"])->name("genders.delete");
    Route::match(['GET', 'POST'],"/genders",[AdminController::class, "Genders"])->name("admin.genders");
    Route::post("/pokemons/Add", [AdminController::class, "addPokemon"])->name("pokemons.add");
    Route::post("/pokemons/Edit", [AdminController::class, "editPokemon"])->name("pokemons.edit");
    Route::post("/pokemons/Delete", [AdminController::class, "deletePokemon"])->name("pokemons.delete");
    Route::match(['GET', 'POST'],"/pokemons",[AdminController::class, "Pokemons"])->name("admin.pokemons");
    // Route::get("/profile", [ProfileController::class, "index"])->name("admin.profile");
    // Route::get("/profile/{id}", [ProfileController::class, "show"])->name("admin.profile.show");
    // Route::get("/profile/{id}/edit", [ProfileController::class, "edit"])->name("admin.profile.edit");
    // Route::post("/profile/{id}/edit", [ProfileController::class, "update"])->name("admin.profile.update");
    //Route::get("/profile/{id}/delete", [ProfileController::class, "delete"])->name("admin.profile.delete");
    Route::match(['GET', 'POST'],"/exemplaries",[AdminController::class, "Exemplaries"])->name("admin.exemplaries");
});
 

Route::prefix("user")->group(function () {
    Route::get("exemplaries",[UserController::class, "exemplaries"])->name("user.exemplaries");
    Route::get("userTeam",[UserController::class, "teams"])->name("user.userTeam");

});