<?php

namespace App\Tables;

use App\Models\Type;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\DB;

class EffectivnessTable extends Table{

    public function getDependencies(): array
    {
        return ["Type"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = DB::table("effectiveness")
            ->join("types as t1", "effectiveness.attacking_type_id", "=", "t1.id")
            ->join("types as t2", "effectiveness.defending_type_id", "=", "t2.id");
             
        return $q;
    }

    public function __construct()
    {
        $this->setId(88);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id", "effectiveness.id", "ID", types: Types::INTEGER, isOriginal: true),
            "attacking" => Column::Visible("attacking", "t1.name", "Tipo Che Attacca", types: Types::STRING, isOriginal: false),
            "defending" => Column::Visible("defending", "t2.name", "Tipo Che Incassa l'Attacco", types: Types::STRING, isOriginal: false),
            "attacking_id" => Column::Hidden("attacking_id", "t1.id", "Type Attacking", types: Types::INTEGER, isOriginal: true),
            "defending_id" => Column::Hidden("defending_id", "t2.id", "Type Defending", types: Types::INTEGER, isOriginal: true),
            "multiplier" => Column::Visible("multiplier", "effectiveness.multiplier", "Moltiplicatore del Danno",Types::FLOAT,isOriginal: true)
        ]);
    }
}