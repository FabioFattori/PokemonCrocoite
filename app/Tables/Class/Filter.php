<?php

namespace App\Tables\Class;

use Illuminate\Support\Collection;

class Filter implements \JsonSerializable {
    private string $columnName;
    private mixed $value;

    public function __construct(string $columnName, mixed $value){
        $this->columnName = $columnName;
        $this->value = $value;
    }

    public static function FromJson(array|Collection $array): Filter|null{
        $array = collect($array);
        
        if(!$array->has("columnName") || !$array->has("value")){
            return null;
        }else{
            return new Filter($array->get("columnName"), $array->get("value"));
        }
    }

    public function getColumnName(): string{
        return $this->columnName;
    }

    public function setColumnName(string $columnName): void{
        $this->columnName = $columnName;
    }

    public function getValue(): mixed{
        return $this->value;
    }

    public function setValue(mixed $value): void{
        $this->value = $value;
    }

    function jsonSerialize(){
        return [
            "columnName" => $this->getColumnName(),
            "value" => $this->getValue()
        ];
    }
}