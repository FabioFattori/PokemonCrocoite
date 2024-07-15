<?php

namespace App\Tables;

use App\Models\BattleTool;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class BattleToolMode{
    public const All = 0;
    public const ofUser = 1;
    public const ofNpc = 2;
}

class BattleToolTable extends Table
{
    private int $mode;
    private int $id;
    public function getDependencies(): array
    {
        return ["State","BattleTool","Npc","User"];
    }

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = BattleTool::query();
        $q->leftJoin("state_battle_tools","state_battle_tools.battle_tool_id","=","battle_tools.id")->leftJoin("states","states.id","=","state_battle_tools.state_id");

        if($this->mode == BattleToolMode::ofUser){
            $q->leftJoin("battle_tool_users","battle_tool_users.battle_tool_id","=","battle_tools.id")->where("battle_tool_users.user_id",$this->id);
        }

        if($this->mode == BattleToolMode::ofNpc){
            $q->leftJoin("battle_tool_npcs","battle_tool_npcs.battle_tool_id","=","battle_tools.id")->where("battle_tool_npcs.npc_id",$this->id);
        }
        return $q;
    }

    public function __construct($mode = BattleToolMode::All,$id = -1)
    {
        $this->mode = $mode;
        $this->id = $id;
        $this->setId(12);
        parent::__construct();
        
        if ($mode == BattleToolMode::ofUser){
            $this->setColumns([
                "id"=>Column::Hidden("id","battle_tools.id","ID",types:Types::INTEGER,isOriginal:true),
                "prefabbricato" => Column::Hidden("prefabbricato","battle_tools.name","BattleTool prefabbricato ",types:Types::STRING,isOriginal:true),
                "name" => Column::Visible("name","battle_tools.name","Name",types:Types::STRING,isOriginal:true),
                "description" => Column::Visible("description","battle_tools.description","Description",types:Types::STRING,isOriginal:true),
                "healthRecovery" => Column::Visible("healthRecovery","battle_tools.healthRecovery","Health Recovery",types:Types::INTEGER,isOriginal:true),
                "state_name" => Column::Visible("state_name","states.name","Stato",types:Types::STRING,isOriginal:false),
                "state_id" => Column::Hidden("state_id","states.id","State",types:Types::INTEGER,isOriginal:true),
                "amount" => Column::Visible("amount","battle_tool_users.amount","Amount",types:Types::INTEGER,isOriginal:true),
            ]);
        }else if($mode == BattleToolMode::ofNpc){
            $this->setColumns([
                "id"=>Column::Hidden("id","battle_tools.id","ID",types:Types::INTEGER,isOriginal:true),
                "prefabbricato" => Column::Hidden("prefabbricato","battle_tools.name","BattleTool prefabbricato ",types:Types::STRING,isOriginal:true),
                "name" => Column::Visible("name","battle_tools.name","Name",types:Types::STRING,isOriginal:true),
                "description" => Column::Visible("description","battle_tools.description","Description",types:Types::STRING,isOriginal:true),
                "healthRecovery" => Column::Visible("healthRecovery","battle_tools.healthRecovery","Health Recovery",types:Types::INTEGER,isOriginal:true),
                "state_name" => Column::Visible("state_name","states.name","Stato",types:Types::STRING,isOriginal:false),
                "state_id" => Column::Hidden("state_id","states.id","State",types:Types::INTEGER,isOriginal:true),
                "amount" => Column::Visible("amount","battle_tool_npcs.amount","Amount",types:Types::INTEGER,isOriginal:true),
            ]);
        } else {
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
}