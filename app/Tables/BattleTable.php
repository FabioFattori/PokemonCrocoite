<?php

namespace App\Tables;

use App\Models\Battles;
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
        $q = Battles::query();
        if($this->mode == BattleMode::USER){
            $q->where("user_1", "=", $this->userId)->orWhere("user_2", "=", $this->userId);
        }
        $q->leftJoin("users as user_1","user_1","=","user_1.id");
        $q->leftJoin("users as user_2","user_2","=","user_2.id");
        $q->leftJoin("users","winner","=","users.id");
        $q->select("battles.id","battles.date","battles.winner","users.email","user_1.email","user_2.email");
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
            "winnerName" => Column::Visible("winnerName","users.email","Vincitore ",types:Types::STRING,isOriginal:false),
            "winner" => Column::Hidden("winner","battles.winner","User Vincitore",types:Types::INTEGER,isOriginal:true),
            "user_1Name" => Column::Visible("user_1Name","user_1.email","User 1",types:Types::STRING,isOriginal:false),
            "user_2Name" => Column::Visible("user_2Name","user_2.email","User 2",types:Types::STRING,isOriginal:false),
            "user_1" => Column::Hidden("user_1","battles.user_1","User 1",types:Types::INTEGER,isOriginal:true),
            "user_2" => Column::Hidden("user_2","battles.user_2","User 2",types:Types::INTEGER,isOriginal:true),
        ]);
    }

    
}