<?php 

namespace App\Tables;

use App\Models\Gender;
use App\Tables\Class\Column;
use App\Tables\Class\Types;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class GendersTable extends Table
{

    public function getQuery(): Builder|EloquentBuilder
    {
        $q = Gender::query();
        return $q;
    }

    public function getDependencies():array{
        return [];
    }

    public function __construct() {
        $this->setId(19823);
        parent::__construct();
        $this->setColumns([
            "id" => Column::Hidden("id", "genders.id", types: Types::INTEGER,isOriginal: true),
            "name" => Column::Visible("name", "genders.name", "Nome", types: Types::STRING),
        ]);
    }
}