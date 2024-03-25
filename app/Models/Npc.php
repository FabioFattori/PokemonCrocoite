<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Npc extends Model
{
    use HasFactory;

    protected $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function getCurrentTeam()
    {
        return $this->hasMany(Exemplary::class);
    }


}
