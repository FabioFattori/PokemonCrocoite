<?php

namespace App\Tables;

use App\Models\Captured;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class CaptureTable extends Table
{

    public function getDependencies(): array
    {
        return ["Exemplary","Zone"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Captured::query();
        $q->leftJoin('exemplaries', 'captureds.exemplary_id', '=', 'exemplaries.id');
        $q->leftJoin('zones', 'captureds.zone_id', '=', 'zones.id');
        return $q;
    }

    public function __construct()
    {
        $this->setId(6123);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","captureds.id","id",types:Types::INTEGER,isOriginal:false),
            "date" => Column::Visible("date","captureds.date","Data della cattura",types:Types::DATE,isOriginal:true),
            "exemplary_id" => Column::Hidden("exemplary_id","captureds.exemplary_id","Exemplary Captured",types:Types::INTEGER,isOriginal:true),
            "exemplary" => Column::Visible("exemplary","exemplaries.name","Esemplare Catturato",types:Types::STRING,isOriginal:false),
            "zone_id" => Column::Hidden("zone_id","captureds.zone_id","Zone of Capture",types:Types::INTEGER,isOriginal:true),
            "zone" => Column::Visible("zone","zones.name","Zona di Cattura",types:Types::STRING,isOriginal:false),
        ]);
    }
}