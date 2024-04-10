<?php

namespace App\Tables\Class;

class Types {
    const STRING = 'string';
    const FLOAT = 'float';
    const INTEGER = 'integer';
    const BOOLEAN = 'boolean';
    const DATE = 'date';
    const DATETIME = 'datetime';

    private string $type;

    public function __construct(string|Types $type){
        if($type instanceof Types){
            $type = $type->getType();
        }
        $this->type = $type;
    }

    public function getType(): string{
        return $this->type;
    }

    public function setType(string $type): void{
        $this->type = $type;
    }

    public function isString(): bool{
        return $this->type === self::STRING;
    }

    public function isFloat(): bool{
        return $this->type === self::FLOAT;
    }

    public function isInteger(): bool{
        return $this->type === self::INTEGER;
    }

    public function isBoolean(): bool{
        return $this->type === self::BOOLEAN;
    }

    public function isDate(): bool{
        return $this->type === self::DATE;
    }

    public function isDateTime(): bool{
        return $this->type === self::DATETIME;
    }


} 