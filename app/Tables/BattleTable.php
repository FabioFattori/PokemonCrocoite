<?php

namespace App\Tables;

use App\Models\Battle;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

final class BattleMode{
    public const ADMIN = 0;
    public const USER = 1;
}

class BattleTable extends Table
{
    private int $mode;
    private int $userId;
    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
    {
        $q = Battle::query();
        if($this->mode == BattleMode::USER){
            $q->where("user_1", "=", $this->userId)->orWhere("user_2", "=", $this->userId);
        }
        $q->leftJoin("users as user_1","user_1","=","user_1.id");
        $q->leftJoin("users as user_2","user_2","=","user_2.id");
        return $q;
    }

    public function getDependencies(): array
    {
        return ["User"];
    }

    public function __construct($mode = BattleMode::ADMIN, $userId = -1)
    {
        $this->userId = $userId;
        $this->setId(930);
        parent::__construct();
        $this->mode = $mode;
        $this->setColumns([
            "id" => Column::Hidden("id","battles.id",types:Types::INTEGER),
            "date" => Column::Visible("date","battles.date","Data Della battaglia",types:Types::DATE,isOriginal:true),
            "winner" => Column::Visible("winner","battles.winner","Vincitore",types:Types::INTEGER,isOriginal:true),
            "user_1Name" => Column::Visible("user_1Name","user_1.email","User 1",types:Types::STRING,isOriginal:false),
            "user_2Name" => Column::Visible("user_2Name","user_2.email","User 2",types:Types::STRING,isOriginal:false),
            "user_1" => Column::Hidden("user_1","battles.user_1","User 1",types:Types::INTEGER,isOriginal:true),
            "user_2" => Column::Hidden("user_2","battles.user_2","User 2",types:Types::INTEGER,isOriginal:true),
        ]);
    }

    
}