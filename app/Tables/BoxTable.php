<?php

namespace App\Tables;

use App\Models\Box;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class BoxTable extends Table
{

    public function getDependencies():array{
        return ["User"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Box::query()->join("users", "boxes.user_id", "=", "users.id");
        return $q;
    }
    
    public function __construct()
    {
        $this->setId(20);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id", "boxes.id", types: Types::INTEGER,isOriginal: true),
            "name" => Column::Visible("name", "boxes.name", "Nome Box", types: Types::STRING),
            "user_id" => Column::Hidden("user_id", "boxes.user_id", "User", types: Types::INTEGER,isOriginal: true),
            "users.email" => Column::Visible("users.email", "users.email", "Email Propetario", types: Types::STRING,isOriginal: false),
        ]);
    }
}