<?php

namespace App\Tables;

use App\Models\Nature;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class NatureTable extends Table
{
    public function getQuery(): Builder|EloquentBuilder
    {
        return Nature::query();
    }

    public function getDependencies(): array
    {
        return [];
    }
    
    public function __construct()
    {
        $this->setId(33);
        parent::__construct();

        $this->setColumns([
            "id" => Column::Hidden("id","natures.id","ID",types:Types::INTEGER,isOriginal:true),
            "name" => Column::Visible("name","natures.name","Name",types:Types::STRING,isOriginal:true),
            "description" => Column::Visible("description","natures.description","Description",types:Types::STRING,isOriginal:true),
        ]);
    }
}