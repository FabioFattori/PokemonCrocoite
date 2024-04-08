<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'   
    ];

    public function exemplary()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function canLearnFromLeve()
    {
        return $this->belongsToMany(Move::class, "can_learn_level")->withPivot('level');
    }

    public function canLearnFromMachine()
    {
        return $this->belongsToMany(Move::class, "can_learn_from_mn_mt");
    }

    public function type()
    {
        return $this->belongsToMany(Type::class);
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }

    public function zone()
    {
        return $this->belongsToMany(Zone::class, 'can_be_found', 'pokemon_id', 'id');
    }

    public function encountered()
    {
        return $this->hasMany(PokemonEncountered::class);
    }
}
