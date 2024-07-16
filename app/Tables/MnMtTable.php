<?php

namespace App\Tables;
use App\Models\MnMt;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

class MnMtMode{
    public const all=0;
    public const ofUser=1;
}

class MnMtTable extends Table{
    private int $mode;
    private int $userId;
    public function getDependencies(): array
    {
        return ["Move"];
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder{
        $q = MnMt::query();
        $q = $q->leftJoin('moves', 'mn_mts.move_id', '=', 'moves.id');
        if($this->mode == MnMtMode::ofUser){
            $q->leftJoin('mn_mt_quantity', 'mn_mt_quantity.mn_mt_id', '=', 'mn_mts.id')->where('mn_mt_quantity.user_id', $this->userId);
        }
        return $q;
    }

    public function __construct($mode = MnMtMode::all, $userId = -1){
        $this->mode = $mode;
        $this->userId = $userId;
        $this->setId(7231);
        parent::__construct();
        if($this->mode == MnMtMode::all){
            $this->setColumns([
                "id" => Column::Hidden("id","mn_mts.id","ID",types: Types::INTEGER,isOriginal: true),
                "move_id" => Column::Hidden("move_id","mn_mts.move_id","Move",types: Types::INTEGER,isOriginal: true),
                "move_name" => Column::Visible("move_name","moves.name","Nome Mossa",types: Types::STRING,isOriginal: false),
                "number" => Column::Visible("number","mn_mts.number","Numero",types: Types::INTEGER,isOriginal: true),
                "description" => Column::Visible("description","mn_mts.description","Descrizione",types: Types::STRING,isOriginal: true),
                "isMn" => Column::Visible("isMn","mn_mts.is_mn","è Macchina Nascosta",types: Types::BOOLEAN,isOriginal: true),
            ]);
        }else{
            $this->setColumns([
                "id" => Column::Hidden("id","mn_mts.id","ID",types: Types::INTEGER,isOriginal: true),
                "move_id" => Column::Hidden("move_id","mn_mts.move_id","Move",types: Types::INTEGER,isOriginal: true),
                "move_name" => Column::Visible("move_name","moves.name","Nome Mossa",types: Types::STRING,isOriginal: false),
                "number" => Column::Visible("number","mn_mts.number","Numero",types: Types::INTEGER,isOriginal: true),
                "description" => Column::Visible("description","mn_mts.description","Descrizione",types: Types::STRING,isOriginal: true),
                "isMn" => Column::Visible("isMn","mn_mts.is_mn","è Macchina Nascosta",types: Types::BOOLEAN,isOriginal: true),
                "quantity" => Column::Visible("quantity","mn_mt_quantity.quantity","Quantità",types: Types::INTEGER,isOriginal: true),
            ]);
        }
    }
}