<?php

namespace App\Tables;
use App\Models\BattleRegistry;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

class SingleBattleMode{
    public const GivenBattleId = 0;
    public const AllBattles = 1;
}

class SinglePokemonBattleTable extends Table{

    private int $mode;
    private int $battleId;

    public function getDependencies(): array
    {
        return ["Exemplary","Battle"];
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder{
        $q = BattleRegistry::query();
        $q->leftJoin("exemplaries","exemplaries.id","=","battle_registries.exemplary1_id")->leftJoin("battles","battles.id","=","battle_registries.battle_id")->leftJoin("exemplaries as pokemon2","pokemon2.id","=","battle_registries.exemplary2_id");


        if($this->mode == SingleBattleMode::GivenBattleId){
            $q->where("battle_registries.battle_id","=",$this->battleId);
        }

        return $q;
    }

    public function __construct($mode = SingleBattleMode::AllBattles, $battleId = -1){
        $this->setId(432);
        $this->mode = $mode;
        $this->battleId = $battleId;
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","battle_registries.id",types:Types::INTEGER),
            "exemplaries1name" => Column::Visible("exemplaries1name","exemplaries.name","Exemplary 1 name",types:Types::INTEGER,isOriginal:false,sortable:false),
            "exemplary1" => Column::Hidden("exemplary1","battle_registries.exemplary1_id","Exemplary 1 ",types:Types::INTEGER,isOriginal:true,sortable:false),
            "battle_id" => Column::Hidden("battle_id","battle_registries.battle_id","Battles ",types:Types::INTEGER),
            "battle" => Column::Hidden("battle","battles.date","Data della Battaglia",types:Types::DATE,isOriginal:false,sortable:false),
            "exemplaries2Name" => Column::Visible("exemplaries2Name","pokemon2.name","Exemplary 2 name",types:Types::INTEGER,isOriginal:false,sortable:false),
            "exemplary2" => Column::Hidden("exemplary2","battle_registries.exemplary2_id","Exemplary 2 ",types:Types::INTEGER,isOriginal:true,sortable:false),
            "winner" => Column::Visible("winner","battle_registries.winner","Vincitore",types:Types::INTEGER,isOriginal:true,sortable:false),
        ]);
    }
}