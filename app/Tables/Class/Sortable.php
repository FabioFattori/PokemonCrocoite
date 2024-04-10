<?php

namespace App\Tables\Class;

use Illuminate\Support\Collection;

class Sortable implements \JsonSerializable{
    private string $columnName;
    private string $direction;

    public function __construct(string $columnName, string $direction = "ASC"){
        $this->columnName = $columnName;
        $this->direction = $direction;
    }

    public static function FromJson(array|Collection $sortable){
        $sortable = collect($sortable);
        return new Sortable($sortable->get("columnName"), $sortable->get("direction"));
    }

    public function getColumnName(): string{
        return $this->columnName;
    }

    public function setColumnName(string $columnName): void{
        $this->columnName = $columnName;
    }

    public function getDirection(): string{
        return $this->direction;
    }

    public function setDirection(string $direction): void{
        $this->direction = $direction;
    }

    function jsonSerialize(){
        return [
            "columnName" => $this->getColumnName(),
            "direction" => $this->getDirection()
        ];
    }
}