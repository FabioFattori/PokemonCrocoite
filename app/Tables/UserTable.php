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
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id", "users.id", types: Types::INTEGER),
            "email" => Column::Visible("email", "users.email", "Email", types: Types::STRING),
            "password" => Column::Visible("password", "users.password", "Password", types: Types::STRING),
            "x" => Column::Visible("x", "positions.x", "X", types: Types::INTEGER),
            "y" => Column::Visible("y", "positions.y", "Y", types: Types::INTEGER),
        ]);
    }

    protected function getQuery():Builder|EloquentBuilder{
        // Implements the query to fetch data from the database
        $q = User::query()->join("positions", "users.position_id", "=", "positions.id");
        return $q;
    }
}