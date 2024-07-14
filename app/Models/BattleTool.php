<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleTool extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'healthRecovery',
    ];

    public function getExemplaryThatHoldsThisTool()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function statesRecovery()
    {
        return $this->belongsToMany(State::class, 'state_battle_tools', 'battle_tool_id', 'state_id');
    }

    public function npcs()
    {
        return $this->belongsToMany(Npc::class, 'battle_tool_npcs', 'battle_tool_id', 'npc_id')->withPivot('amount');
    }
}
