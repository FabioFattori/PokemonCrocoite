<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemon';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'rarity_id'
    ];

    public function exemplary()
    {
        return $this->hasMany(Exemplary::class, 'pokemon_id', 'id');
    }

    public function canLearnFromLevel()
    {
        return $this->belongsToMany(Move::class, "can_learn_level", 'pokemon_id', "move_id")->withPivot('level');
    }

    public function canLearnFromMachine()
    {
        return $this->belongsToMany(Move::class, "can_learn_from_mn_mt", 'pokemon_id', "move_id");
    }

    public function allLearnableMoves()
    {
        $learnableMoves = [];
        $learnableMoves['level'] = $this->canLearnFromLevel()->get();
        $learnableMoves['machine'] = $this->canLearnFromMachine()->get();
        return $learnableMoves;
    }

    public function type()
    {
        return $this->belongsToMany(Type::class, 'pokemon_type', 'pokemon_id', 'type_id');
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }

    public function zone()
    {
        return $this->belongsToMany(Zone::class, 'can_be_found', 'pokemon_id', 'zone_id');
    }

    public function encountered()
    {
        return $this->hasMany(PokemonEncountered::class);
    }
}
