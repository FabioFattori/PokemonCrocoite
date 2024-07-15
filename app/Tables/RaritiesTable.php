<?php

namespace App\Tables;

use App\Models\Rarity;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class RaritiesTable extends Table
{
    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Rarity::query();

        return $q;
    }

    public function getDependencies(): array
    {
        return [];
    }

    public function __construct()
    {
        $this->setId(701);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","rarities.id","id",types:Types::INTEGER,isOriginal:true),
            "name" => Column::Visible("name","rarities.name","name",types:Types::STRING,isOriginal:true),
        ]);
    }
}