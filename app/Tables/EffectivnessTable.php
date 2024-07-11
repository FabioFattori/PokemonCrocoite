<?php

namespace App\Tables;

use App\Models\Type;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class EffectivnessTable extends Table{

    public function getDependencies(): array
    {
        return ["Type"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Type::query()->join("effectiveness", "types.id", "=", "effectiveness.attacking_type_id")->join("types as t", "effectiveness.defending_type_id", "=", "t.id")->select("types.name as attacking", "t.name as defending", "effectiveness.multiplier");
        return $q;
    }

    public function __construct()
    {
        $this->setId(88);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id", "effectiveness.id", "ID", types: Types::INTEGER, isOriginal: true),
            "attacking" => Column::Visible("attacking", "types.name", "Tipo Che Attacca", types: Types::STRING, isOriginal: false),
            "defending" => Column::Visible("defending", "types.name", "Tipo Che Incassa l'Attacco", types: Types::STRING, isOriginal: false),
            "attacking_id" => Column::Hidden("attacking_id", "types.id", "Type Attacking", types: Types::INTEGER, isOriginal: true),
            "defending_id" => Column::Hidden("attacking_id", "types.id", "Type Defending", types: Types::INTEGER, isOriginal: true),
            "multiplier" => Column::Visible("multiplier", "effectiveness.multiplier", "Moltiplicatore del Danno",Types::FLOAT,isOriginal: true)
        ]);
    }
}