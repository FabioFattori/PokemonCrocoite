<?php

use App\Tables\Table;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use App\Models\Box;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

class TeamTable extends Table{

    private array $dependencies = ["User"];

    public function getDependencies():array{
        return $this->dependencies;
    }

    public function getQuery():Builder|EloquentBuilder{
        $q = Box::query()->join("users", "boxes.user_id", "=", "users.id");

        return $q;
    }

    public function __construct(){
        $this->setId(100);
        parent::__construct();
        $this->setColumns([
            "date" => Column::Visible("date", "teams.date", "Data Creazione", types: Types::DATE,isOriginal: false),
            "user_id" => Column::Hidden("user_id", "teams.user_id", "Creatore", types: Types::INTEGER,isOriginal: true),
            "id" => Column::Hidden(name: "id", dbName: "exemplaries.id", types: Types::INTEGER,isOriginal: true),
        ]);
    }

    
}