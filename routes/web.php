<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DBController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeedController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\UserController;
use App\Tables\ExemplaryTable;
use App\Tables\UserTable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get("/stats", [StatsController::class, "index"])->name("stats");

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
    Route::post("/boxes/Add", [AdminController::class, "addBox"])->name("boxes.add");
    Route::post("/boxes/Edit", [AdminController::class, "editBox"])->name("boxes.edit");
    Route::post("/boxes/Delete", [AdminController::class, "deleteBox"])->name("boxes.delete");
    Route::match(['GET','POST'],"/boxes",[AdminController::class, "Boxes"])->name("admin.boxes");
    Route::post("/effectivnesses/Add", [AdminController::class, "addEffectivness"])->name("effectivnesses.add");
    Route::post("/effectivnesses/Edit", [AdminController::class, "editEffectivness"])->name("effectivnesses.edit");
    Route::post("/effectivnesses/Delete", [AdminController::class, "deleteEffectivness"])->name("effectivnesses.delete");
    Route::match(['GET','POST'],"/effectivnesses",[AdminController::class, "effectivnesses"])->name("admin.effectivnesses");
    Route::post("/positions/Add", [AdminController::class, "addPosition"])->name("positions.add");
    Route::post("/positions/Edit", [AdminController::class, "editPosition"])->name("positions.edit");
    Route::post("/positions/Delete", [AdminController::class, "deletePosition"])->name("positions.delete");
    Route::match(['GET', 'POST'],"/positions",[AdminController::class, "positions"])->name("admin.positions");
    Route::post("/zones/Add", [AdminController::class, "addZone"])->name("zones.add");
    Route::post("/zones/Edit", [AdminController::class, "editZone"])->name("zones.edit");
    Route::post("/zones/Delete", [AdminController::class, "deleteZone"])->name("zones.delete");
    Route::match(['GET', 'POST'],"/zones",[AdminController::class, "Zones"])->name("admin.zones");
    Route::post("/gyms/Add", [AdminController::class, "addGym"])->name("gyms.add");
    Route::post("/gyms/Edit", [AdminController::class, "editGym"])->name("gyms.edit");
    Route::post("/gyms/Delete", [AdminController::class, "deleteGym"])->name("gyms.delete");
    Route::match(['GET', 'POST'],"/gyms",[AdminController::class, "gyms"])->name("admin.gyms");
    Route::post("/natures/Add", [AdminController::class, "addNature"])->name("natures.add");
    Route::post("/natures/Edit", [AdminController::class, "editNature"])->name("natures.edit");
    Route::post("/natures/Delete", [AdminController::class, "deleteNature"])->name("natures.delete");
    Route::match(['GET', 'POST'],"/natures",[AdminController::class, "nature"])->name("admin.nature");
    Route::post("/changeMove", [AdminController::class, "changeMove"])->name("changeMove");
    Route::post("/tools/Add", [AdminController::class, "addTool"])->name("tools.add");
    Route::post("/tools/Edit", [AdminController::class, "editTool"])->name("tools.edit");
    Route::post("/tools/Delete", [AdminController::class, "deleteTool"])->name("tools.delete");
    Route::match(['GET', 'POST'],"/tools", [AdminController::class, "tools"])->name("admin.tools");
    Route::post("/battles/Add", [AdminController::class, "addBattle"])->name("battles.add");
    Route::post("/battles/Edit", [AdminController::class, "editBattle"])->name("battles.edit");
    Route::post("/battles/Delete", [AdminController::class, "deleteBattle"])->name("battles.delete");
    Route::match(['GET', 'POST'],"/battles", [AdminController::class, "battles"])->name("admin.battles");
    Route::post("/rarities/Add", [AdminController::class, "addRarity"])->name("rarities.add");
    Route::post("/rarities/Edit", [AdminController::class, "editRarity"])->name("rarities.edit");
    Route::post("/rarities/Delete", [AdminController::class, "deleteRarity"])->name("rarities.delete");
    Route::match(['GET', 'POST'],"/rarities", [AdminController::class, "rarities"])->name("admin.rarities");
    Route::post("/npcs/Add", [AdminController::class, "addNpc"])->name("npcs.add");
    Route::post("/npcs/Edit", [AdminController::class, "editNpc"])->name("npcs.edit");
    Route::post("/npcs/Delete", [AdminController::class, "deleteNpc"])->name("npcs.delete");
    Route::match(['GET', 'POST'],"/npcs", [AdminController::class, "npcs"])->name("admin.npcs");
    Route::post("/mnmts/Add", [AdminController::class, "addMnMt"])->name("mnmts.add");
    Route::post("/mnmts/Edit", [AdminController::class, "editMnMt"])->name("mnmts.edit");
    Route::post("/mnmts/Delete", [AdminController::class, "deleteMnMt"])->name("mnmts.delete");
    Route::match(['GET', 'POST'],"/mnmts", [AdminController::class, "mnmts"])->name("admin.mnmts");
    Route::post("/states/Add", [AdminController::class, "addState"])->name("states.add");
    Route::post("/states/Edit", [AdminController::class, "editState"])->name("states.edit");
    Route::post("/states/Delete", [AdminController::class, "deleteState"])->name("states.delete");
    Route::match(['GET', 'POST'],"/states", [AdminController::class, "states"])->name("admin.states");
    Route::post("/storyTools/Add", [AdminController::class, "addStoryTool"])->name("storyTools.add");
    Route::post("/storyTools/Edit", [AdminController::class, "editStoryTool"])->name("storyTools.edit");
    Route::post("/storyTools/Delete", [AdminController::class, "deleteStoryTool"])->name("storyTools.delete");
    Route::match(['GET', 'POST'],"/storyTools", [AdminController::class, "storyTools"])->name("admin.storyTools");
    Route::post("/teams/Delete", [AdminController::class, "deleteTeam"])->name("teams.delete");
    Route::match(['GET', 'POST'],"/teams", [AdminController::class, "teams"])->name("admin.teams");
    Route::post("/captures/Delete", [AdminController::class, "deleteCapture"])->name("captures.delete");
    Route::post("/captures/Add", [AdminController::class, "addCapture"])->name("captures.add");
    Route::post("/captures/Edit", [AdminController::class, "editCapture"])->name("captures.edit");
    Route::match(['GET', 'POST'],"/captures", [AdminController::class, "captures"])->name("admin.captures");
    // Route::get("/profile", [ProfileController::class, "index"])->name("admin.profile");
    // Route::get("/profile/{id}", [ProfileController::class, "show"])->name("admin.profile.show");
    // Route::get("/profile/{id}/edit", [ProfileController::class, "edit"])->name("admin.profile.edit");
    // Route::post("/profile/{id}/edit", [ProfileController::class, "update"])->name("admin.profile.update");
    //Route::get("/profile/{id}/delete", [ProfileController::class, "delete"])->name("admin.profile.delete");
    Route::match(['GET', 'POST'],"/exemplaries",[AdminController::class, "Exemplaries"])->name("admin.exemplaries");
});
 

Route::prefix("user")->group(function () {
    Route::post("/exemplary/free", [UserController::class, "freePokemon"])->name("user.exemplaries.free");
    Route::match(['GET', 'POST'],"/boxes", [UserController::class, "boxes"])->name("user.boxes");
    Route::post("/exemplary/inTeam", [UserController::class, "exemplaryInTeam"])->name("user.exemplaries.inTeam");
    Route::post("/exemplary/inBox", [UserController::class, "exemplaryInBox"])->name("user.exemplaries.inBox");
    Route::match(['GET', 'POST'],"/exemplariesInBox", [UserController::class, "exemplariesInBox"])->name("user.exemplariesInBox");
    Route::match(['GET', 'POST'],"/exemplaries", [UserController::class, "exemplaries"])->name("user.exemplaries");
    Route::match(['GET', 'POST'],"/userTeam", [UserController::class, "teams"])->name("user.userTeam");

});