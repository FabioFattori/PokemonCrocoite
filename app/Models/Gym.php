<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['position_id', 'zone_id', 'type_id'];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function npc()
    {
        return $this->hasMany(Npc::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }
}
