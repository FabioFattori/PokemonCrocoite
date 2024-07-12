<?php

namespace App\Tables;
use App\Models\BattleRegistry;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

class SinglePokemonBattleTable extends Table{
    public function getDependencies(): array
    {
        return ["Pokemon","Battles"];
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder{
        $q = BattleRegistry::query();
        $q->leftJoin("pokemon","pokemon.id","=","battle_registry.pokemon1_id")->leftJoin("battles","battles.id","=","battle_registry.battle_id")->leftJoin("pokemon as pokemon2","pokemon2.id","=","battle_registry.pokemon2_id");
        $q->leftJoin("pokemon as winnerPK","winnerPK.id","=","battle_registry.winner");
        return $q;
    }

    public function __construct(){
        $this->setId(432);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id","battle_registry.id",types:Types::INTEGER),
            "battle_id" => Column::Hidden("battle_id","battle_registry.battle_id",types:Types::INTEGER),
            "pokemon_id" => Column::Hidden("pokemon_id","battle_registry.pokemon_id",types:Types::INTEGER),
            "pokemonName" => Column::Visible("pokemonName","pokemon.name","Pokemon",types:Types::STRING,isOriginal:false),
            "pokemon" => Column::Hidden("pokemon","battle_registry.pokemon_id","Pokemon",types:Types::INTEGER,isOriginal:true),
            "battle" => Column::Hidden("battle","battles.date","Battaglia",types:Types::INTEGER,isOriginal:true),
            "pokemon2Name" => Column::Visible("pokemon2Name","pokemon2.name","Pokemon 2",types:Types::STRING,isOriginal:false),
            "pokemon2" => Column::Hidden("pokemon2","battle_registry.pokemon2_id","Pokemon 2",types:Types::INTEGER,isOriginal:true),
            "winnerName" => Column::Visible("winnerName","winnerPK.name","Vincitore",types:Types::STRING,isOriginal:false),
            "winner" => Column::Hidden("winner","battle_registry.winner","Vincitore",types:Types::INTEGER,isOriginal:true),
        ]);
    }
}