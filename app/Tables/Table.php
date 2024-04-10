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

    protected function getQuery():Builder|EloquentBuilder{
        throw new \Exception("Not implemented");
    }

    protected function getColumns():Collection{
        return collect($this->columns);
    }

    protected function setColumns(array|Collection $columns):void{
        $this->columns = collect($columns);
    }

    public function setFilters(array|Collection $filters){
        $filters = collect($filters);
        $this->filters = $filters->map(fn($value) => Filter::FromJson($value));
    }

    public function setSorts(array|Collection $sorts) {
        $sorts = collect($sorts);
        $this->sorts = $sorts->map(fn($value) => Sortable::FromJson($value));
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
            if($column !== null && $column->getSortable()){
                if($column->getType()->isString()){
                    $query->where($filter->getColumnName(), "like", "%" . $filter->getValue() . "%");
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

    protected function getFullQuery(): Builder|EloquentBuilder{
        $query = $this->getQuery();
        $query = $this->applySelect($query);
        $query = $this->applyFilters($query);
        $query = $this->applyCustomFilters($query);
        $query = $this->applySort($query);
        $query = $this->applyCustomSort($query);
        $query = $this->applyPagination($query);
        return $query;
    }

    protected function getData(){
        return $this->getFullQuery()->get();
    }

    protected function getCount(){
        return $this->getFullQuery()->count();
    }

    public function get(){
        $query = $this->getFullQuery();
        $data = $this->getData();
        $count = $this->getCount();
        return [
            'column' => $this->getColumns(),
            'filters' => $this->filters->values()->all(),
            'sorts' => $this->sorts->values()->all(),
            'data' => $data,
            'page' => $this->page,
            'perPage' => $this->perPage,
            'count' => $count
        ];
    }
}