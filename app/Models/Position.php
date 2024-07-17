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

        $zoneWidth = $zone->width + $zone->position->x;
        $zoneLength = $zone->length + $zone->position->y;

        //check if the position is in the zone
        if($x >= $zone->position->x && $x <= $zoneWidth && $y >= $zone->position->y && $y <= $zoneLength){
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
