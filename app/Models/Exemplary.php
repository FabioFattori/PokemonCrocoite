<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exemplary extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'speed',
        'specialDefense',
        'defense',
        'attack',
        'specialAttack',
        'ps',
        'level',
        'catchDate',
        'pokemon_id',
        'gender_id',
        'nature_id',
        'team_id',
        'npc_id',
        'holding_tools_id',
        'box_id',
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_id', 'id');
    }
    
    public function move()
    {
        return $this->belongsToMany(Move::class);
    }

    public function nature()
    {
        return $this->belongsTo(Nature::class);
    }

    public function state()
    {
        //is a n:N
        return $this->belongsToMany(State::class, 'state_exemplary', 'exemplary_id', 'state_id');
    }


}
