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
    
    public function __construct() {
        $this->setId(19823);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id", "users.id", types: Types::INTEGER),
            "email" => Column::Visible("email", "users.email", "Email", types: Types::STRING),
            "password" => Column::Hidden("password", "users.password", "Password", types: Types::STRING),
            "positions.x" => Column::Visible("positions.x", "positions.x", "X", types: Types::INTEGER),
            "positions.y" => Column::Visible("positions.y", "positions.y", "Y", types: Types::INTEGER),
        ]);
    }

    public function getQuery():Builder|EloquentBuilder{
        // Implements the query to fetch data from the database
        $q = User::query()->join("positions", "users.position_id", "=", "positions.id");
        return $q;
    }
}