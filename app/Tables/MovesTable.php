<?php
namespace App\Tables;
use App\Models\Move;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use App\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class MovesTable extends Table{

    public function getDependencies():array{
        return ["Type"];
    }

    public function getQuery():Builder|EloquentBuilder{
        // Implements the query to fetch data from the database
        $q = Move::query()->leftJoin("types", "moves.type_id", "=", "types.id");
        return $q;
    }

    public function __construct(){
        $this->setId(91);
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