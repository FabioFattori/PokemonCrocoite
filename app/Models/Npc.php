<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Npc extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'description', 'position_id', 'gym_id'];

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

    public function battleTool()
    {
        return $this->belongsToMany(BattleTool::class, 'battle_tool_npc', 'npc_id', 'battle_tool_id')->withPivot('amount');
    }


}
