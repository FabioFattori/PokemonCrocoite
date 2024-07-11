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
}

class MovesTable extends Table{
    private int $currentMode;
    private int $exemplaryId;

    public function getDependencies():array{
        return ["Type"];
    }

    public function getQuery():Builder|EloquentBuilder{
        // Implements the query to fetch data from the database
        $q = Move::query();
        $q->leftJoin("types", "moves.type_id", "=", "types.id");
        if ($this->currentMode == MovesMode::getMovesFromExemplaryId) {
            $q->join("exemplary_move", "exemplary_move.move_id", "=", "moves.id")->where("exemplary_move.exemplary_id", "=", $this->exemplaryId);
        }
        
        return $q;
    }

    public function __construct($mode = MovesMode::getAll, $exemplaryId = -1){
        $this->setId(91);
        $this->currentMode = $mode;
        $this->exemplaryId = $exemplaryId;
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden(name: "id", dbName: "moves.id", types: Types::INTEGER,isOriginal: true),
            "name" => Column::Visible(name: "name", dbName: "moves.name", types: Types::STRING,isOriginal: true),
            "description" => Column::Visible(name: "description", dbName: "moves.description", types: Types::STRING,isOriginal: true),
            "type_id" => Column::Hidden(name: "type_id", dbName: "moves.type_id",label:"Type", types: Types::INTEGER,isOriginal: true),
            "types.name" => Column::Visible("types.name", "types.name", "Tipo", types: Types::STRING,isOriginal: false),
        ]);
    }
}