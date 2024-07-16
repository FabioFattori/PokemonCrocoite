<?php

namespace App\Tables;
use App\Models\State;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

class StateTable extends Table{
    public function getDependencies(): array
    {
        return [];
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder{
        $q = State::query();
        return $q;
    }

    public function __construct(){
        $this->setId(1);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","states.id","ID",types: Types::INTEGER,isOriginal: true),
            "name" => Column::Visible("name","states.name","Nome Stato",types: Types::STRING,isOriginal: true),
            "description" => Column::Visible("description","states.description","Descrizione",types: Types::STRING,isOriginal: true),
        ]);
    }
}