<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['x', 'y'];

    public function zone()
    {
        return $this->hasOne(Zone::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function npcs()
    {
        return $this->hasMany(Npc::class);
    }

    public function gyms()
    {
        return $this->hasOne(Gym::class);
    }
}
