<?php

namespace App\Tables;

use App\Models\Pokemon;
use App\Tables\Class\Column;
use App\Tables\Class\Filter;
use App\Tables\Class\Sortable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
//use \Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class Table{

    private int $id;

    protected function setId(int $id){
        $this->id = $id;
    }

    public function getId():int{
        return $this->id;
    }

    protected bool $useAutomaticSelect = false;
    /**
     * @var Collection<string, Column>
     */
    protected array|Collection $columns;
    
    /**
     * @var Collection<int, Filter>
     */
    protected Collection $filters;

    /**
     * @var Collection<int, Sortable>
     */
    protected Collection $sorts;

    protected int $page = 1;
    protected int $perPage = 10;


    public function __construct() {
        $this->columns = collect();
        $this->filters = collect();
        $this->sorts = collect();
    }

    public function getQuery():Builder|EloquentBuilder{
        throw new \Exception("Not implemented");
    }

    protected function checkPage(){
        $maxPage = ceil($this->getCount() / $this->perPage);
        if($this->page > $maxPage){
            $this->page = $maxPage;
            return true;
        }
        return false;
    }

    protected function getColumns():Collection{
        return collect($this->columns);
    }

    protected function setColumns(array|Collection $columns):void{
        $this->columns = collect($columns);
    }

    public function setFilters(array|Collection $filters){
        $filters = collect($filters);
        $this->filters = $filters->map(fn($value) => Filter::FromJson($value))->except(null);
    }

    public function setSorts(array|Collection $sorts) {
        $sorts = collect($sorts);
        $this->sorts = $sorts->map(fn($value) => Sortable::FromJson($value))->except(null);
    }

    public function setPage(int $page){
        $this->page = $page;
    }

    public function setPerPage(int $perPage){
        $this->perPage = $perPage;
    }

    public function setConfigObject(array|Collection $object){
        $object = collect($object);
        if($object->has("page")){
            $this->setPage($object->get("page"));
        }
        if($object->has("perPage")){
            $this->setPerPage($object->get("perPage"));
        }
        if($object->has("filters")){
            $this->setFilters($object->get("filters"));
        }
        if($object->has("sorts")){
            $this->setSorts($object->get("sorts"));
        }
    }

    public function getColumn(string $name): Column|null{
        return $this->getColumns()->get($name);
    }

    protected function applyFilters(Builder|EloquentBuilder $query): Builder|EloquentBuilder{
        $this->filters->each(function(Filter $filter, $key) use ($query){
            $column = $this->getColumn($filter->getColumnName());
            if($column !== null && $column->getSearchable()){
                if($column->getType()->isString()){
                    $query->where($column->getDbName(), "like", "%" . $filter->getValue() . "%");
                }
                else {
                    $query->where($filter->getColumnName(), $filter->getValue());
                }
            }
        });

        return $query;
    } 

    protected function applyCustomFilters(Builder|EloquentBuilder $query): Builder|EloquentBuilder{
        return $query;
    }

    protected function applySort(Builder|EloquentBuilder $query): Builder|EloquentBuilder{  
        $this->sorts->each(function(Sortable $sortable, $key) use ($query){
            $column = $this->getColumn($sortable->getColumnName());
            if($column !== null && $column->getSortable()){
                $query->orderBy($sortable->getColumnName(), $sortable->getDirection());
            }
        });

        return $query;
    }

    protected function applyCustomSort(Builder|EloquentBuilder $query): Builder|EloquentBuilder{
        return $query;
    }

    protected function applyPagination(Builder|EloquentBuilder $query): Builder|EloquentBuilder{
        return $query->skip(($this->page - 1) * $this->perPage)->take($this->perPage);
    }

    protected function applySelect(Builder|EloquentBuilder $query): Builder|EloquentBuilder{
        $selects = collect();
        $this->getColumns()->each(function (Column $column) use ($selects) {
            $selects->push("{$column->getDbName()} as {$column->getName()}");
        });
        $query->select($selects->toArray());

        return $query;
    }

    public function getFullQuery(bool $withPagination = true): Builder|EloquentBuilder{
        $query = $this->getQuery();
        $query = $this->applySelect($query);
        $query = $this->applyFilters($query);
        $query = $this->applyCustomFilters($query);
        $query = $this->applySort($query);
        $query = $this->applyCustomSort($query);
        if($withPagination){
            $query = $this->applyPagination($query);
        }
        return $query;
    }

    protected function getData(){
        return $this->getFullQuery()->get();
    }

    protected function getCount(){
        return $this->getFullQuery(withPagination:false)->count();
    }

    public function get(){
        $query = $this->getFullQuery();
        $data = $this->getData();
        $count = $this->getCount();
        if($this->checkPage()){
            $data = $this->getData();
            $count = $this->getCount();
        }
        return [
            'sql' => $query->toRawSql(),
            'column' => $this->getColumns(),
            'filters' => $this->filters->values()->all(),
            'sorts' => $this->sorts->values()->all(),
            'data' => $data,
            'page' => $this->page,
            'perPage' => $this->perPage,
            'count' => $count,
            'id' => $this->getId()    
        ];
    }

    public function equals(Table $table): bool{
        return $this->getId() == $table->getId();
    }

    public function equalsByID(int $id):bool{
        return $this->getId() == $id;
    }
}