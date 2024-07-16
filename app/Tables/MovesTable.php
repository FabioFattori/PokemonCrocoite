<?php
namespace App\Tables;
use App\Models\Move;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use App\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

enum MovesMode{
    public const getAll = 0;
    public const getMovesFromExemplaryId = 1;

    public const getMovesForExemplaryLevel = 2;

    public const getMovesForExemplaryMnMt = 3;
}

class MovesTable extends Table{
    private int $currentMode;
    private int $exemplaryId;

    private array $dependencies = ["Type","State"];

    public function getDependencies():array{
        return $this->dependencies;
    }

    public function getQuery():Builder|EloquentBuilder{
        // Implements the query to fetch data from the database
        $q = Move::query();
        $q->leftJoin("types", "moves.type_id", "=", "types.id");
        $q->leftJoin("states", "moves.state_id", "=", "states.id");
        if ($this->currentMode == MovesMode::getMovesFromExemplaryId) {
            $q->join("exemplary_move", "exemplary_move.move_id", "=", "moves.id")->where("exemplary_move.exemplary_id", "=", $this->exemplaryId);
        }

        if ($this->currentMode == MovesMode::getMovesForExemplaryLevel) {
            $q->leftJoin("can_learn_level", "can_learn_level.move_id", "=", "moves.id")->where("can_learn_level.pokemon_id", "=", $this->exemplaryId);
        }

        if ($this->currentMode == MovesMode::getMovesForExemplaryMnMt) {      
            $q->leftJoin("can_learn_from_mn_mt", "can_learn_from_mn_mt.move_id", "=", "moves.id")->where("can_learn_from_mn_mt.pokemon_id", "=", $this->exemplaryId);
        }
        
        return $q;
    }

    public function __construct($mode = MovesMode::getAll, $exemplaryId = -1){
        $this->setId(91);
        $this->currentMode = $mode;
        $this->exemplaryId = $exemplaryId;

        if($mode == MovesMode::getMovesForExemplaryLevel || $mode == MovesMode::getMovesForExemplaryMnMt){
            
            array_push($this->dependencies, "Move");
        }

        parent::__construct();
        if($mode == MovesMode::getMovesForExemplaryLevel){
            $this->setColumns([
                "prefabbricato" => Column::Hidden("prefabbricato","moves.name","Move prefabbricato ",types:Types::STRING,isOriginal:true),
                "id" => Column::Hidden(name: "id", dbName: "moves.id", types: Types::INTEGER,isOriginal: true),
                "name" => Column::Visible(name: "name", dbName: "moves.name", types: Types::STRING,isOriginal: true),
                "description" => Column::Visible(name: "description", dbName: "moves.description", types: Types::STRING,isOriginal: true),
                "type_id" => Column::Hidden(name: "type_id", dbName: "moves.type_id",label:"Type", types: Types::INTEGER,isOriginal: true),
                "types.name" => Column::Visible("types.name", "types.name", "Tipo", types: Types::STRING,isOriginal: false),
                "can_learn_level" => Column::Visible("can_learn_level", "can_learn_level.level", "Livello a cui la impara", types: Types::INTEGER,isOriginal: true),
                "probState" => Column::Visible("probState", "moves.probState", "Probabilità di Applicare Lo stato", types: Types::INTEGER,isOriginal: true),
                "nomeStato" => Column::Visible("nomeStato", "states.name", "Stato", types: Types::STRING,isOriginal: false),
                "state_id" => Column::Hidden("state_id", "moves.state_id", "State", types: Types::INTEGER,isOriginal: true),
            ]);
        }else if($mode == MovesMode::getMovesForExemplaryMnMt){
            $this->setColumns([
                "id" => Column::Hidden(name: "id", dbName: "moves.id", types: Types::INTEGER,isOriginal: true),
                "name" => Column::Visible(name: "name", dbName: "moves.name", types: Types::STRING,isOriginal: false),
                "description" => Column::Visible(name: "description", dbName: "moves.description", types: Types::STRING,isOriginal: false),
                "type_id" => Column::Hidden(name: "type_id", dbName: "moves.type_id",label:"Type", types: Types::INTEGER,isOriginal: false),
                "types.name" => Column::Visible("types.name", "types.name", "Tipo", types: Types::STRING,isOriginal: false),
                "can_learn_mn_mt" => Column::Hidden("can_learn_mn_mt", "can_learn_from_mn_mt.move_id", "Move ", types: Types::INTEGER,isOriginal: true),
                "probState" => Column::Visible("probState", "moves.probState", "Probabilità di Applicare Lo stato", types: Types::INTEGER,isOriginal: true),
                "nomeStato" => Column::Visible("nomeStato", "states.name", "Stato", types: Types::STRING,isOriginal: false),
                "state_id" => Column::Hidden("state_id", "moves.state_id", "State", types: Types::INTEGER,isOriginal: true),
            ]);
        }else{
            $this->setColumns([
                "id" => Column::Hidden(name: "id", dbName: "moves.id", types: Types::INTEGER,isOriginal: true),
                "name" => Column::Visible(name: "name", dbName: "moves.name", types: Types::STRING,isOriginal: true),
                "description" => Column::Visible(name: "description", dbName: "moves.description", types: Types::STRING,isOriginal: true),
                "type_id" => Column::Hidden(name: "type_id", dbName: "moves.type_id",label:"Type", types: Types::INTEGER,isOriginal: true),
                "types.name" => Column::Visible("types.name", "types.name", "Tipo", types: Types::STRING,isOriginal: false),
                "probState" => Column::Visible("probState", "moves.probState", "Probabilità di Applicare Lo stato", types: Types::INTEGER,isOriginal: true),
                "nomeStato" => Column::Visible("nomeStato", "states.name", "Stato", types: Types::STRING,isOriginal: false),
                "state_id" => Column::Hidden("state_id", "moves.state_id", "State", types: Types::INTEGER,isOriginal: true),
            ]);
        }
    }
}