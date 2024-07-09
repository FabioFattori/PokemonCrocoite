<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['x', 'y'];

    public static function checkIfPositionIsInZone($x, $y, $zone_id)
    {
        $zone = Zone::where('id', $zone_id)->first();
        if ($zone->x1 <= $x && $zone->x2 >= $x && $zone->y1 <= $y && $zone->y2 >= $y) {
            return true;
        }
        $position = Position::where('x', $x)->where('y', $y)->first();
        if($zone->position_id == $position->id){
            return true;
        }
        return false;
    }

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
