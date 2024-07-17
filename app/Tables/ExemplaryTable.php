<?php

namespace App\Tables;

use App\Models\Exemplary;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

final class Mode
{
    public const TEAM = 1;
    public const ADMIN = 2;
    public const Box = 3;   
    public const USER = 4; 
    public const SingleExemplary = 5;  
}


class ExemplaryTable extends Table{

    private int $currentMode;
    private array $dependencies = ["Pokemon","Nature","Team","Npc","Gender","User","Captured","Zone","BattleTool","State"];
    private int $boxId;
    private int $SingleExemplaryId;

    private int $userId;

    public function getDependencies():array{
        return $this->dependencies;
    }

    private function addElementToDependencies($element){
        if (!in_array($element, $this->dependencies)) {
            array_push($this->dependencies, $element);
        }
    }

    public function getQuery():Builder|EloquentBuilder{
        $q = Exemplary::query()->whereNull("exemplaries.exemplary_id")->leftJoin("captureds", "captureds.exemplary_id", "=", "exemplaries.id");
        $q->leftJoin("zones", "captureds.zone_id", "=", "zones.id");
        $q->leftJoin("teams", "exemplaries.team_id", "=", "teams.id");
        $q->leftJoin("users", "teams.user_id", "=", "users.id");
        $q->leftJoin("battle_tools", "exemplaries.holding_tools_id", "=", "battle_tools.id");
        $q->leftJoin("state_exemplaries", "exemplaries.id", "=", "state_exemplaries.exemplary_id");
        $q->leftJoin("states", "state_exemplaries.state_id", "=", "states.id");
        if($this->currentMode == Mode::TEAM && auth()->user() != null){
            $q->where("team_id", "=", auth()->user()->getTeamId());
        }else if($this->currentMode == Mode::TEAM && auth()->user() == null){
            $q->where("team_id", "=", $this->userId);
        }

        if($this->currentMode == Mode::ADMIN){
            $q->leftJoin("boxes", "exemplaries.box_id", "=", "boxes.id");
            $this->addElementToDependencies("Box");
        }

        if($this->currentMode == Mode::Box){
            $q->where("box_id", "=", $this->boxId);
        }

        if($this->currentMode == Mode::SingleExemplary){
            $q->where("exemplaries.id", "=", $this->SingleExemplaryId);
        }
        return $q;
    }

    public function __construct($mode = Mode::ADMIN, $boxId = -1, $SingleExemplaryId = -1, $userId = -1){ 
        $this->setId(90);
        $this->currentMode = $mode;
        $this->boxId = $boxId;
        $this->userId = $userId;
        $this->SingleExemplaryId = $SingleExemplaryId;
        parent::__construct();
        if($this->currentMode == Mode::TEAM){
            $this->setColumns([
                "name" => Column::Visible("name", "exemplaries.name", "Nome esemplare", types: Types::STRING,isOriginal: true),
                "level" => Column::Visible("level", "exemplaries.level", "Livello Pokemon", true, true, Types::INTEGER),
                "hp" => Column::Visible("hp", "exemplaries.ps", "Punti Vita", true, true, Types::INTEGER),
                "attack" => Column::Visible("attack", "exemplaries.attack", "Attacco", true, true, Types::INTEGER),
                "defense" => Column::Visible("defense", "exemplaries.defense", "Difesa", true, true, Types::INTEGER),
                "speed" => Column::Visible("speed", "exemplaries.speed", "Velocità", true, true, Types::INTEGER),
                "specialAttack" => Column::Visible("specialAttack", "exemplaries.specialAttack", "Attacco Speciale", true, true, Types::INTEGER),
                "catchDate" => Column::Visible("catchDate", "captureds.date", "Data Cattura", true, true, Types::DATE),
                "specialDefense" => Column::Visible("specialDefense", "exemplaries.specialDefense", "Difesa Speciale", true, true, Types::INTEGER),
                "npc_id" => Column::Hidden("npc_id", "exemplaries.npc_id", "Npc", types: Types::INTEGER,isOriginal: true),
                "nature_id" => Column::Hidden("nature_id", "exemplaries.nature_id", "Nature", types: Types::INTEGER,isOriginal: true),
                "gender_id" => Column::Hidden("gender_id", "exemplaries.gender_id", "Gender", types: Types::INTEGER,isOriginal: true),
                "box_id" => Column::Hidden("box_id", "exemplaries.box_id", "Box", types: Types::INTEGER,isOriginal: true),
                "id" => Column::Hidden(name: "id", dbName: "exemplaries.id", types: Types::INTEGER,isOriginal: true),
                "storico_id" => Column::Hidden("storico_id", "exemplaries.exemplary_id", "Exemplary", types: Types::INTEGER,isOriginal: false),
                "zone_id" => Column::Hidden("zone_id", "zones.id", "Zone", types: Types::INTEGER,isOriginal: true),
                "zoneName" => Column::Visible("zoneName", "zones.name","Zone Di Cattura", types: Types::STRING,isOriginal: false),
                "holding_tools_id" => Column::Hidden("holding_tools_id", "exemplaries.holding_tools_id", "BattleTool which the pokemon holds", types: Types::INTEGER,isOriginal: true),
                "holding_tools_name" => Column::Visible("holding_tools_name", "battle_tools.name", "Strumento", types: Types::STRING,isOriginal: false),
                "state_id" => Column::Hidden("state_id", "state_exemplaries.state_id", "State", types: Types::INTEGER,isOriginal: false),
                "state_name" => Column::Visible("state_name", "states.name", "Stato", types: Types::STRING,isOriginal: false),
            ]);
        }else if($this->currentMode == Mode::Box){
            $this->setColumns([
                "name" => Column::Visible("name", "exemplaries.name", "Nome esemplare", types: Types::STRING,isOriginal: true),
                "level" => Column::Visible("level", "exemplaries.level", "Livello Pokemon", true, true, Types::INTEGER),
                "hp" => Column::Visible("hp", "exemplaries.ps", "Punti Vita", true, true, Types::INTEGER),
                "attack" => Column::Visible("attack", "exemplaries.attack", "Attacco", true, true, Types::INTEGER),
                "defense" => Column::Visible("defense", "exemplaries.defense", "Difesa", true, true, Types::INTEGER),
                "speed" => Column::Visible("speed", "exemplaries.speed", "Velocità", true, true, Types::INTEGER),
                "specialAttack" => Column::Visible("specialAttack", "exemplaries.specialAttack", "Attacco Speciale", true, true, Types::INTEGER),
                "catchDate" => Column::Visible("catchDate", "captureds.date", "Data Cattura", true, true, Types::DATE),
                "specialDefense" => Column::Visible("specialDefense", "exemplaries.specialDefense", "Difesa Speciale", true, true, Types::INTEGER),
                "pokemon_id" => Column::Hidden("pokemon_id", "exemplaries.pokemon_id", "Pokemon", types: Types::INTEGER,isOriginal: true),
                "team_id" => Column::Hidden("team_id", "exemplaries.team_id", "Team", types: Types::INTEGER,isOriginal: true),
                "npc_id" => Column::Hidden("npc_id", "exemplaries.npc_id", "Npc", types: Types::INTEGER,isOriginal: true),
                "nature_id" => Column::Hidden("nature_id", "exemplaries.nature_id", "Nature", types: Types::INTEGER,isOriginal: true),
                "gender_id" => Column::Hidden("gender_id", "exemplaries.gender_id", "Gender", types: Types::INTEGER,isOriginal: true),
                "box_id" => Column::Hidden("box_id", "exemplaries.box_id", "Box", types: Types::INTEGER,isOriginal: true),
                "id" => Column::Hidden(name: "id", dbName: "exemplaries.id", types: Types::INTEGER,isOriginal: true),
                "storico_id" => Column::Hidden("storico_id", "exemplaries.exemplary_id", "Exemplary", types: Types::INTEGER,isOriginal: false),
                "zone_id" => Column::Hidden("zone_id", "zones.id", "Zone", types: Types::INTEGER,isOriginal: true),
                "zoneName" => Column::Visible("zoneName", "zones.name","Zone Di Cattura", types: Types::STRING,isOriginal: false),
                "holding_tools_id" => Column::Hidden("holding_tools_id", "exemplaries.holding_tools_id", "BattleTool which the pokemon holds", types: Types::INTEGER,isOriginal: true),
                "holding_tools_name" => Column::Visible("holding_tools_name", "battle_tools.name", "Strumento", types: Types::STRING,isOriginal: false),
                "state_id" => Column::Hidden("state_id", "state_exemplaries.state_id", "State", types: Types::INTEGER,isOriginal: false),
                "state_name" => Column::Visible("state_name", "states.name", "Stato", types: Types::STRING,isOriginal: false),
            ]);
        }else{
            $this->setColumns([
                "name" => Column::Visible("name", "exemplaries.name", "Nome esemplare", types: Types::STRING,isOriginal: true),
                "level" => Column::Visible("level", "exemplaries.level", "Livello Pokemon", true, true, Types::INTEGER),
                "hp" => Column::Visible("hp", "exemplaries.ps", "Punti Vita", true, true, Types::INTEGER),
                "attack" => Column::Visible("attack", "exemplaries.attack", "Attacco", true, true, Types::INTEGER),
                "defense" => Column::Visible("defense", "exemplaries.defense", "Difesa", true, true, Types::INTEGER),
                "speed" => Column::Visible("speed", "exemplaries.speed", "Velocità", true, true, Types::INTEGER),
                "specialAttack" => Column::Visible("specialAttack", "exemplaries.specialAttack", "Attacco Speciale", true, true, Types::INTEGER),
                "catchDate" => Column::Visible("catchDate", "captureds.date", "Data Cattura", true, true, Types::DATE),
                "specialDefense" => Column::Visible("specialDefense", "exemplaries.specialDefense", "Difesa Speciale", true, true, Types::INTEGER),
                "pokemon_id" => Column::Hidden("pokemon_id", "exemplaries.pokemon_id", "Pokemon", types: Types::INTEGER,isOriginal: true),
                "team_id" => Column::Hidden("team_id", "exemplaries.team_id", "Team", types: Types::INTEGER,isOriginal: true),
                "npc_id" => Column::Hidden("npc_id", "exemplaries.npc_id", "Npc", types: Types::INTEGER,isOriginal: true),
                "nature_id" => Column::Hidden("nature_id", "exemplaries.nature_id", "Nature", types: Types::INTEGER,isOriginal: true),
                "gender_id" => Column::Hidden("gender_id", "exemplaries.gender_id", "Gender", types: Types::INTEGER,isOriginal: true),
                "box_id" => Column::Hidden("box_id", "exemplaries.box_id", "Box", types: Types::INTEGER,isOriginal: true),
                "id" => Column::Hidden(name: "id", dbName: "exemplaries.id", types: Types::INTEGER,isOriginal: true),
                "storico_id" => Column::Hidden("storico_id", "exemplaries.exemplary_id", "Exemplary", types: Types::INTEGER,isOriginal: false),
                "zone_id" => Column::Hidden("zone_id", "zones.id", "Zone", types: Types::INTEGER,isOriginal: true),
                "zoneName" => Column::Visible("zoneName", "zones.name","Zone Di Cattura", types: Types::STRING,isOriginal: false),
                "user_id" => Column::Hidden("user_id", "users.id", "User", types: Types::INTEGER,isOriginal: true),
                "userName" => Column::Visible("userName", "users.email", "Nome User", types: Types::STRING,isOriginal: false),
                "holding_tools_id" => Column::Hidden("holding_tools_id", "exemplaries.holding_tools_id", "BattleTool which the pokemon holds", types: Types::INTEGER,isOriginal: true),
                "holding_tools_name" => Column::Visible("holding_tools_name", "battle_tools.name", "Strumento", types: Types::STRING,isOriginal: false),
                "state_id" => Column::Hidden("state_id", "state_exemplaries.state_id", "State", types: Types::INTEGER,isOriginal: false),
                "state_name" => Column::Visible("state_name", "states.name", "Stato", types: Types::STRING,isOriginal: false),
            ]);
        }
        
    }
}