<?php

namespace App\Tables;

use App\Models\Position;
use App\Tables\Class\Column;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class PositionTable extends Table{

    public function getDependencies(): array
    {
        return [];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        return Position::query();
    }

    public function __construct()
    {
        $this->setId(55);
        parent::__construct();

        $this->setColumns([
            "id" => Column::Hidden("id","positions.id","ID"),
            "x" => Column::Visible("x","positions.x","X"),
            "y" => Column::Visible("y","positions.y","Y"),
        ]);
    }
}