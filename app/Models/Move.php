<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'description',
        'name',
    ];
    
    public function exemplary()
    {
        return $this->belongsToMany(Exemplary::class, 'exemplary_move', 'move_id', 'exemplary_id');
    }

    public function canLearnFromLevel()
    {
    return $this->belongsToMany(Pokemon::class, "can_learn_level", 'move_id', 'pokemon_id')->withPivot('level');
    }

    public function canLearnFromMachine()
    {
        return $this->belongsToMany(Pokemon::class, "can_learn_from_mn_mt", 'move_id', 'pokemon_id');
    }

    public function types()
    {
        return $this->belongsTo(Type::class);
    }
}
