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
    private array $dependencies = ["Pokemon","Nature","Team","Npc","Gender","User"];
    private int $boxId;
    private int $SingleExemplaryId;

    public function getDependencies():array{
        return $this->dependencies;
    }

    private function addElementToDependencies($element){
        if (!in_array($element, $this->dependencies)) {
            array_push($this->dependencies, $element);
        }
    }

    public function getQuery():Builder|EloquentBuilder{
        $q = Exemplary::query()->join("pokemon", "exemplaries.pokemon_id", "=", "pokemon.id");
        //! if want catch date use this below
        //->join("captured", "captured.exemplary_id", "=", "exemplaries.id");
        if($this->currentMode == Mode::TEAM){
            $q->where("team_id", "=", auth()->user()->getTeamId());
        }

        if($this->currentMode == Mode::ADMIN){
            $q = Exemplary::query()->join("pokemon", "exemplaries.pokemon_id", "=", "pokemon.id")->leftJoin("boxes", "exemplaries.box_id", "=", "boxes.id");
            $this->addElementToDependencies("Box");
        }

        if($this->currentMode == Mode::Box){
            $q->where("box_id", "=", $this->boxId);
        }

        if($this->currentMode == Mode::USER){
            $q = Exemplary::query()->join("pokemon", "exemplaries.pokemon_id", "=", "pokemon.id")->join("boxes", "exemplaries.box_id", "=", "boxes.id");
            $q->where("boxes.user_id", "=", auth()->user()->getId())->where("team_id", "=", auth()->user()->getTeamId());
            $this->addElementToDependencies("Box");
        }

        if($this->currentMode == Mode::SingleExemplary){
            $q->where("exemplaries.id", "=", $this->SingleExemplaryId);
        }
        return $q;
    }

    public function __construct($mode = Mode::ADMIN, $boxId = -1, $SingleExemplaryId = -1) {
        $this->setId(90);
        $this->currentMode = $mode;
        $this->boxId = $boxId;
        $this->SingleExemplaryId = $SingleExemplaryId;
        parent::__construct();
        $this->setColumns([
            "pokemonName" => Column::Visible("pokemonName", "pokemon.name", "Nome Pokemon", types: Types::STRING,isOriginal: false),
            "level" => Column::Visible("level", "exemplaries.level", "Livello Pokemon", true, true, Types::INTEGER),
            "hp" => Column::Visible("hp", "exemplaries.ps", "Punti Vita", true, true, Types::INTEGER),
            "attack" => Column::Visible("attack", "exemplaries.attack", "Attacco", true, true, Types::INTEGER),
            "defense" => Column::Visible("defense", "exemplaries.defense", "Difesa", true, true, Types::INTEGER),
            "speed" => Column::Visible("speed", "exemplaries.speed", "Velocità", true, true, Types::INTEGER),
            "specialAttack" => Column::Visible("specialAttack", "exemplaries.specialAttack", "Attacco Speciale", true, true, Types::INTEGER),
            //"catchDate" => Column::Visible("catchDate", "captured.date", "Data Cattura", true, true, Types::DATE),
            "specialDefense" => Column::Visible("specialDefense", "exemplaries.specialDefense", "Difesa Speciale", true, true, Types::INTEGER),
            "pokemon_id" => Column::Hidden("pokemon_id", "exemplaries.pokemon_id", "Pokemon", types: Types::INTEGER,isOriginal: true),
            "team_id" => Column::Hidden("team_id", "exemplaries.team_id", "Team", types: Types::INTEGER,isOriginal: true),
            "npc_id" => Column::Hidden("npc_id", "exemplaries.npc_id", "Npc", types: Types::INTEGER,isOriginal: true),
            "nature_id" => Column::Hidden("nature_id", "exemplaries.nature_id", "Nature", types: Types::INTEGER,isOriginal: true),
            "gender_id" => Column::Hidden("gender_id", "exemplaries.gender_id", "Gender", types: Types::INTEGER,isOriginal: true),
            "box_id" => Column::Hidden("box_id", "exemplaries.box_id", "Box", types: Types::INTEGER,isOriginal: true),
            "id" => Column::Hidden(name: "id", dbName: "exemplaries.id", types: Types::INTEGER,isOriginal: true),
        ]);
    }
}