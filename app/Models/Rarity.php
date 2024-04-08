<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function pokemons()
    {
        return $this->hasMany(Pokemon::class);
    }
}
