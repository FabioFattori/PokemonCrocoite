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
        'pokemon_id'
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }
}
