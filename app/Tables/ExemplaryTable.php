<?php

namespace App\Tables;

use App\Models\Exemplary;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

class ExemplaryTable extends Table{

    protected function getQuery():Builder|EloquentBuilder{
        $q = Exemplary::query()->join("pokemon", "exemplaries.pokemon_id", "=", "pokemon.id");
        return $q;
    }

    public function __construct() {
        parent::__construct();
        $this->setColumns([
            "pokemonName" => Column::Visible("pokemonName", "pokemon.name", "Nome Pokemon", types: Types::STRING),
            "level" => Column::Visible("level", "exemplaries.level", "Livello Pokemon", true, false, Types::INTEGER),
            "id" => Column::Hidden(name: "id", dbName: "exemplaries.id", types: Types::INTEGER),
        ]);
    }
}