<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exemplary extends Model
{
    use HasFactory;

    protected $timestamps = false;

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
        'user_team_id',
        'npc_id',
        'holding_tools_id',
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }
}
