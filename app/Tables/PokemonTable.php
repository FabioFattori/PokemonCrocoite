<?php

namespace App\Tables;

use App\Models\Pokemon;
use App\Tables\Table;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class PokemonTable extends Table{
    
    public function getDependencies(): array
    {
        return ["Type"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Pokemon::query()->join("pokemon_type", "pokemon.id", "=", "pokemon_type.pokemon_id")->join("types", "pokemon_type.type_id", "=", "types.id");
        //$q = $q->join("")
        return $q;
    }

    public function __construct(){
        parent::__construct();
        $this->setId(10);
        $this->setColumns(
                [
                    "id" => Column::Hidden("id", "pokemon.id", types: Types::INTEGER,isOriginal: true),
                    "name" => Column::Visible("name", "pokemon.name", "Nome", types: Types::STRING),
                    "type" => Column::Visible("type", "types.name", "Tipo", types: Types::STRING,isOriginal: false),
                    "type_id" => Column::Hidden("type_id", "types.id",label:"Type", types: Types::INTEGER,isOriginal: true),
                ]
            );
    }
}