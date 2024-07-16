<?php

namespace App\Tables;
use App\Models\MnMt;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

class MnMtTable extends Table{
    public function getDependencies(): array
    {
        return ["Move"];
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder{
        $q = MnMt::query();
        $q = $q->leftJoin('moves', 'mn_mts.move_id', '=', 'moves.id');
        return $q;
    }

    public function __construct(){
        $this->setId(7231);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","mn_mts.id","ID",types: Types::INTEGER,isOriginal: true),
            "move_id" => Column::Hidden("move_id","mn_mts.move_id","Move",types: Types::INTEGER,isOriginal: true),
            "move_name" => Column::Visible("move_name","moves.name","Nome Mossa",types: Types::STRING,isOriginal: false),
            "number" => Column::Visible("number","mn_mts.number","Numero",types: Types::INTEGER,isOriginal: true),
            "description" => Column::Visible("description","mn_mts.description","Descrizione",types: Types::STRING,isOriginal: true),
            "isMn" => Column::Visible("isMn","mn_mts.is_mn","è Macchina Nascosta",types: Types::BOOLEAN,isOriginal: true),
        ]);
    }
}