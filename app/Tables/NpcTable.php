<?php

namespace App\Tables;

use App\Models\Npc;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class NpcTable extends Table{
    public function getDependencies(): array
    {
        return ["Position","Gym","Zone"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Npc::query();
        $q->leftJoin("positions","npcs.position_id","=","positions.id");
        $q->leftJoin("gyms","npcs.gym_id","=","gyms.id");
        $q->leftJoin("zones","gyms.zone_id","=","zones.id");
        return $q;
    }

    public function __construct()
    {
        $this->setId(2071);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","npcs.id","id",types:Types::INTEGER,isOriginal:true),
            "name" => Column::Visible("name","npcs.name","name",types:Types::STRING,isOriginal:true),
            "position" => Column::Hidden("position","positions.id","Position",types:Types::STRING,isOriginal:true),
            "gym" => Column::Hidden("gym","gyms.id","Zone Name",types:Types::STRING,isOriginal:true),
            "X" => Column::Visible("X","positions.X","X",types:Types::INTEGER,isOriginal:false),
            "Y" => Column::Visible("Y","positions.Y","Y",types:Types::INTEGER,isOriginal:false),
            "zoneName" => Column::Visible("zoneName","zones.name","si trova nella Palestra nella zona",types:Types::STRING,isOriginal:false),
            "isGymLeader" => Column::Visible("isGymLeader","npcs.is_gym_leader","è Capo Palestra",types:Types::BOOLEAN,isOriginal:true),
        ]);
    }
}