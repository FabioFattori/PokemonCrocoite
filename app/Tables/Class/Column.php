<?php

namespace App\Tables\Class;

class Column implements \JsonSerializable {

    private string $name;
    private string $dbName;
    private string $label;
    private bool $sortable;
    private bool $searchable;
    private bool $isOriginal;
    private Types $type;
    private bool $hidden;

    public function __construct(string $name, string|null $dbName, string|null $label, bool $sortable, bool $searchable, Types|string $type, bool $hidden = false,bool $isOriginal = true){
        $this->name = $name;
        $this->dbName = $dbName ?? $name;
        $this->label = $label ?? $name;
        $this->sortable = $sortable;
        $this->searchable = $searchable;
        $this->type = new Types($type);
        $this->hidden = $hidden;
        $this->isOriginal = $isOriginal;
    }

    public static function Visible(string $name = "", string|null $dbName = null, string|null $label = null, bool $sortable = true, bool $searchable = true, Types|string $types = Types::STRING , bool $isOriginal = true){
        return new Column($name, $dbName, $label, $sortable, $searchable, $types, false, $isOriginal);
    }
    public static function Hidden(string $name = "", string|null $dbName = null, string|null $label = null, bool $sortable = false, bool $searchable = false, Types|string $types = Types::STRING , bool $isOriginal = false){
        return new Column($name, $dbName, $label, $sortable, $searchable, $types, true, $isOriginal);
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

    public function getIsOriginal(): bool{
        return $this->isOriginal;
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

    public function setIsOriginal(bool $isOriginal): void{
        $this->isOriginal = $isOriginal;
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
            'hidden' => $this->getHidden(),
            'isOriginal' => $this->getIsOriginal(),
        ];
    }

}