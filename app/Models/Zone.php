<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'length', 'width', "position_id"];

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'can_be_found', 'zone_id', 'id');
    }

    public function pokemonEncounteredInZone()
    {
        return $this->hasMany(PokemonEncountered::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function gym()
    {
        return $this->hasOne(Gym::class);
    }
}
