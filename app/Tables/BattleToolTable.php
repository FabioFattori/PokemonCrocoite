<?php

namespace App\Tables;

use App\Models\BattleTool;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class BattleToolTable extends Table
{
    public function getDependencies(): array
    {
        return ["StateBattleTool","State","BattleTool"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = BattleTool::query();
        $q->leftJoin("state_battle_tools","state_battle_tools.battle_tool_id","=","battle_tools.id")->leftJoin("states","states.id","=","state_battle_tools.state_id");
        return $q;
    }

    public function __construct()
    {
        $this->setId(12);
        parent::__construct();
        $this->setColumns([
            "id"=>Column::Hidden("id","battle_tools.id","ID",types:Types::INTEGER,isOriginal:true),
            "prefabbricato" => Column::Hidden("prefabbricato","battle_tools.name","BattleTool prefabbricato ",types:Types::STRING,isOriginal:true),
            "name" => Column::Visible("name","battle_tools.name","Name",types:Types::STRING,isOriginal:true),
            "description" => Column::Visible("description","battle_tools.description","Description",types:Types::STRING,isOriginal:true),
            "healthRecovery" => Column::Visible("healthRecovery","battle_tools.healthRecovery","Health Recovery",types:Types::INTEGER,isOriginal:true),
            "state_name" => Column::Visible("state_name","states.name","Stato",types:Types::STRING,isOriginal:false),
            "state_id" => Column::Hidden("state_id","states.id","State",types:Types::INTEGER,isOriginal:true),
        ]);
    }
}