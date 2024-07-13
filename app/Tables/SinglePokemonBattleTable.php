<?php

namespace App\Tables;
use App\Models\BattleRegistry;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

class SinglePokemonBattleTable extends Table{
    public function getDependencies(): array
    {
        return ["Exemplary","Battles"];
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder{
        $q = BattleRegistry::query();
        $q->leftJoin("exemplaries","exemplaries.id","=","battle_registries.pokemon1_id")->leftJoin("battles","battles.id","=","battle_registries.battle_id")->leftJoin("exemplaries as pokemon2","pokemon2.id","=","battle_registries.pokemon2_id");
        $q->leftJoin("exemplaries as winnerPK","winnerPK.id","=","battle_registries.winner");
        return $q;
    }

    public function __construct(){
        $this->setId(432);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","battle_registries.id",types:Types::INTEGER),
            "exemplaries1Level" => Column::Visible("exemplaries1Level","exemplaries.level","Exemplary 1 Level",types:Types::INTEGER,isOriginal:false,sortable:false),
            "exemplary1" => Column::Hidden("exemplary1","battle_registries.pokemon1_id","Exemplary 1 ",types:Types::INTEGER,isOriginal:true,sortable:false),
            "battle_id" => Column::Hidden("battle_id","battle_registries.battle_id","Battles ",types:Types::INTEGER),
            "battle" => Column::Hidden("battle","battles.date","Data della Battaglia",types:Types::DATE,isOriginal:false,sortable:false),
            "exemplaries2Level" => Column::Visible("exemplaries2Level","pokemon2.level","Exemplary 2 level",types:Types::INTEGER,isOriginal:false,sortable:false),
            "exemplary2" => Column::Hidden("exemplary2","battle_registries.pokemon2_id","Exemplary 2 ",types:Types::INTEGER,isOriginal:true,sortable:false),
            "winnerName" => Column::Visible("winnerName","winnerPK.level","Exemplary Vincitore",types:Types::STRING,isOriginal:false,sortable:false),
            "winner" => Column::Hidden("winner","battle_registries.winner","Exemplary Winner",types:Types::INTEGER,isOriginal:true,sortable:false),
        ]);
    }
}