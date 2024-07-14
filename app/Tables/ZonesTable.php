<?php 

namespace App\Tables;

use App\Models\Zone;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ZonesTable extends Table{

    public function getDependencies(): array
    {
        return ["Position"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Zone::query()->join("positions","zones.position_id","=","positions.id")->select("zones.*","positions.x","positions.y");

        return $q;
    }

    public function __construct()
    {
        $this->setId(56);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","zones.id","ID",types:Types::INTEGER),
            "name" => Column::Visible("name","zones.name","Name"),
            "length" => Column::Visible("length","zones.length","Length",types:Types::INTEGER),
            "width" => Column::Visible("width","zones.width","Width",types:Types::INTEGER),
            "x" => Column::Visible("x","positions.x","X",isOriginal:false),
            "y" => Column::Visible("y","positions.y","Y",isOriginal:false),
            "position_id" => Column::Hidden("position_id","positions.id","Position",isOriginal:true),
        ]);
    }
}