<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Npc extends Model
{
    use HasFactory;

    public $timestamps = false;

<<<<<<< HEAD
    protected $casts = [
        'is_gym_leader' => 'boolean',
    ];

    protected $fillable = ['name', 'position_id', 'gym_id', 'is_gym_leader'];
=======
    protected $fillable = ['name', 'position_id', 'gym_id'];
>>>>>>> 120c944852877aeddea04fc99a3a25ad7ba871f5

    public function getCurrentTeam()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function battleTools()
    {
        return $this->belongsToMany(BattleTool::class, 'battle_tool_npcs', 'npc_id', 'battle_tool_id')->withPivot('amount');
    }


}
