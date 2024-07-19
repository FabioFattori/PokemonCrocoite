<?php

namespace App\Tables;

use App\Models\Gym;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class GymsTable extends Table{

    public function getDependencies(): array
    {
        return ["Position","Zone","Npc","Type"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Gym::query() -> join("positions","positions.id","=","gyms.position_id") -> join("zones","zones.id","=","gyms.zone_id") -> leftJoin("npcs","npcs.gym_id","=","gyms.id")->where("npcs.is_gym_leader",1);
        $q = $q->select("gyms.id","positions.x","positions.y","gyms.position_id","gyms.zone_id","npcs.id as npc_id","zones.name as zone_name","npcs.name as npc_name");
        $q = $q->leftJoin("types","types.id","=","gyms.type_id");
        return $q;
    }

    public function __construct()
    {
        $this->setId(44);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","gyms.id","ID",types:Types::INTEGER,isOriginal:true),
            "x" => Column::Visible("x","positions.x","X",types:Types::INTEGER,isOriginal:false),
            "y" => Column::Visible("y","positions.y","Y",types:Types::INTEGER,isOriginal:false),
            "position_id" => Column::Hidden("position_id","gyms.position_id","Position",types:Types::INTEGER,isOriginal:true),
            "zone_id" => Column::Hidden("zone_id","gyms.zone_id","Zone",types:Types::INTEGER,isOriginal:true),
            "npc_id" => Column::Hidden("npc_id","npcs.id","Npc",types:Types::INTEGER,isOriginal:true),
            "zone_name" => Column::Visible("zone_name","zones.name","Zona",types:Types::STRING,isOriginal:false),
            "npc_name" => Column::Visible("npc_name","npcs.name","Gym Leader",types:Types::STRING,isOriginal:false),
            "type_id" => Column::Hidden("type_id","gyms.type_id","Type",types:Types::INTEGER,isOriginal:true),
            "type_name" => Column::Visible("type_name","types.name","Tipo Palestra",types:Types::STRING,isOriginal:false),
        ]);
    }
}