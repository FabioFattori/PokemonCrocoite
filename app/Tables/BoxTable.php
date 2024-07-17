<?php

namespace App\Tables;

use App\Models\Box;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class BoxMode{
    public const all = 0;
    public const ofUser = 1;
}

class BoxTable extends Table
{
    private int $mode;
    private int $userId;

    public function getDependencies():array{
        return ["User"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Box::query()->join("users", "boxes.user_id", "=", "users.id");
        if($this->mode == BoxMode::ofUser){
            $q = $q->where("boxes.user_id", $this->userId);
        }
        return $q;
    }
    
    public function __construct($mode = BoxMode::all,$userId = -1)
    {
        $this->mode = $mode;
        $this->userId = $userId;

        $this->setId(20);
        parent::__construct();
        if($this->mode == BoxMode::ofUser){
            $this->setColumns([
                "id" => Column::Hidden("id", "boxes.id", types: Types::INTEGER,isOriginal: true),
                "name" => Column::Visible("name", "boxes.name", "Nome Box", types: Types::STRING),
            ]);
        }else{
            $this->setColumns([
                "id" => Column::Hidden("id", "boxes.id", types: Types::INTEGER,isOriginal: true),
                "name" => Column::Visible("name", "boxes.name", "Nome Box", types: Types::STRING),
                "user_id" => Column::Hidden("user_id", "boxes.user_id", "User", types: Types::INTEGER,isOriginal: true),
                "users.email" => Column::Visible("users.email", "users.email", "Email Propetario", types: Types::STRING,isOriginal: false),
            ]);
        }
    }
}