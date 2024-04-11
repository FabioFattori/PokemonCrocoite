<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function effectivenessOnAttack()
    {
        return $this->belongsToMany(Type::class, 'effectiveness', 'attacking_type_id', 'id')->withPivot('multiplier');
    }

    public function effectivenessOnDefense()
    {
        return $this->belongsToMany(Type::class, 'effectiveness', 'defending_type_id', 'id')->withPivot('multiplier');
    }

    public function moves()
    {
        return $this->hasMany(Move::class);
    }

    //pokemon n:n relation
    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class);
    }
}
