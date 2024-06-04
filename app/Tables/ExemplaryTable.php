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
}


class ExemplaryTable extends Table{

    private int $currentMode;

    public function getDependencies():array{
        return ["Pokemon","Nature","Team","Npc","Gender"];
    }

    public function getQuery():Builder|EloquentBuilder{
        $q = Exemplary::query()->join("pokemon", "exemplaries.pokemon_id", "=", "pokemon.id");
        if($this->currentMode == Mode::TEAM){
            $q->where("team_id", "=", auth()->user()->getTeamId());
        }
        return $q;
    }

    public function __construct($mode = Mode::ADMIN) {
        $this->setId(90);
        $this->currentMode = $mode;
        parent::__construct();
        $this->setColumns([
            "pokemonName" => Column::Visible("pokemonName", "pokemon.name", "Nome Pokemon", types: Types::STRING,isOriginal: false),
            "level" => Column::Visible("level", "exemplaries.level", "Livello Pokemon", true, true, Types::INTEGER),
            "hp" => Column::Visible("hp", "exemplaries.ps", "Punti Vita", true, true, Types::INTEGER),
            "attack" => Column::Visible("attack", "exemplaries.attack", "Attacco", true, true, Types::INTEGER),
            "defense" => Column::Visible("defense", "exemplaries.defense", "Difesa", true, true, Types::INTEGER),
            "speed" => Column::Visible("speed", "exemplaries.speed", "Velocità", true, true, Types::INTEGER),
            "specialAttack" => Column::Visible("specialAttack", "exemplaries.specialAttack", "Attacco Speciale", true, true, Types::INTEGER),
            "catchDate" => Column::Visible("catchDate", "exemplaries.catchDate", "Data Cattura", true, true, Types::DATE),
            "specialDefense" => Column::Visible("specialDefense", "exemplaries.specialDefense", "Difesa Speciale", true, true, Types::INTEGER),
            "pokemon_id" => Column::Hidden("pokemon_id", "exemplaries.pokemon_id", "Pokemon", types: Types::INTEGER,isOriginal: true),
            "team_id" => Column::Hidden("team_id", "exemplaries.team_id", "Team", types: Types::INTEGER,isOriginal: true),
            "npc_id" => Column::Hidden("npc_id", "exemplaries.npc_id", "Npc", types: Types::INTEGER,isOriginal: true),
            "nature_id" => Column::Hidden("nature_id", "exemplaries.nature_id", "Natura", types: Types::INTEGER,isOriginal: true),
            "gender_id" => Column::Hidden("gender_id", "exemplaries.gender_id", "Sesso", types: Types::INTEGER,isOriginal: true),
            "id" => Column::Hidden(name: "id", dbName: "exemplaries.id", types: Types::INTEGER,isOriginal: true),
        ]);
    }
}