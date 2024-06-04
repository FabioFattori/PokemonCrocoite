<?php

namespace App\Tables;

use App\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use App\Models\User;

class UserTable extends Table
{
    
    public function getDependencies():array{
        return ["Position"];
    }

    public function __construct() {
        $this->setId(19823);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id", "users.id", types: Types::INTEGER,isOriginal: true),
            "email" => Column::Visible("email", "users.email", "Email", types: Types::STRING),
            "password" => Column::Hidden("password", "users.password", "Password", types: Types::STRING,isOriginal: true),
            "positions.x" => Column::Visible("positions.x", "positions.x", "X", types: Types::INTEGER,isOriginal: false),
            "positions.y" => Column::Visible("positions.y", "positions.y", "Y", types: Types::INTEGER,isOriginal: false),
            "position_id" => Column::Hidden("position_id", "users.position_id", "Position", types: Types::INTEGER,isOriginal: true),
        ]);
    }

    public function getQuery():Builder|EloquentBuilder{
        // Implements the query to fetch data from the database
        $q = User::query()->leftJoin("positions", "users.position_id", "=", "positions.id");
        return $q;
    }
}