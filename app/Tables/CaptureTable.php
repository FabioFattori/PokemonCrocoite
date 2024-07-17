<?php

namespace App\Tables;

use App\Models\Captured;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class CaptureMode{
    public const all = 0;
    public const ofUser = 1;
}

class CaptureTable extends Table
{
    private int $mode;
    private int $userId;

    public function getDependencies(): array
    {
        return ["Exemplary","Zone"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Captured::query();
        $q->leftJoin('exemplaries', 'captureds.exemplary_id', '=', 'exemplaries.id');
        $q->leftJoin('zones', 'captureds.zone_id', '=', 'zones.id');
        if($this->mode == CaptureMode::ofUser){
            $q->where('captureds.user_id', $this->userId);
        }
        return $q;
    }

    public function __construct($mode = CaptureMode::all, $userId = -1)
    {
        $this->mode = $mode;
        $this->userId = $userId;
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