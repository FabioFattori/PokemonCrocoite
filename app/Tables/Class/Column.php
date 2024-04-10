<?php

namespace App\Tables\Class;

class Column implements \JsonSerializable {

    private string $name;
    private string $dbName;
    private string $label;
    private bool $sortable;
    private bool $searchable;
    private Types $type;
    private bool $hidden;

    public function __construct(string $name, string|null $dbName, string|null $label, bool $sortable, bool $searchable, Types|string $type, bool $hidden = false){
        $this->name = $name;
        $this->dbName = $dbName ?? $name;
        $this->label = $label ?? $name;
        $this->sortable = $sortable;
        $this->searchable = $searchable;
        $this->type = new Types($type);
        $this->hidden = $hidden;
    }

    public static function Visible(string $name = "", string|null $dbName = null, string|null $label = null, bool $sortable = true, bool $searchable = true, Types|string $types = Types::STRING){
        return new Column($name, $dbName, $label, $sortable, $searchable, $types, false);
    }
    public static function Hidden(string $name = "", string|null $dbName = null, string|null $label = null, bool $sortable = true, bool $searchable = true, Types|string $types = Types::STRING){
        return new Column($name, $dbName, $label, $sortable, $searchable, $types, true);
    }

    public function getName(): string{
        return $this->name;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function getDbName(): string{
        return $this->dbName;
    }

    public function setDbName(string $dbName): void{
        $this->dbName = $dbName;
    }

    public function getLabel(): string{
        return $this->label;
    }

    public function setLabel(string $label): void{
        $this->label = $label;
    }

    public function getSortable(): bool{
        return $this->sortable;
    }

    public function setSortable(bool $sortable): void{
        $this->sortable = $sortable;
    }

    public function getSearchable(): bool{
        return $this->searchable;
    }

    public function setSearchable(bool $searchable): void{
        $this->searchable = $searchable;
    }

    public function getType(): Types{
        return $this->type;
    }

    public function setType(Types $type): void{
        $this->type = $type;
    }

    public function getHidden(): bool{
        return $this->hidden;
    }

    public function setHidden(bool $hidden): void{
        $this->hidden = $hidden;
    }

    function jsonSerialize(){
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'sortable' => $this->getSortable(),
            'searchable' => $this->getSearchable(),
            'type' => $this->type->getType(),
            'hidden' => $this->getHidden()
        ];
    }

}