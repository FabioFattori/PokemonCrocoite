<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    public function getExemplariesWithThisState()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function exemplary()
    {
        return $this->belongsToMany(Exemplary::class, 'state_exemplaries', 'state_id', 'exemplary_id');
    }

    public function battleTool()
    {
        return $this->belongsToMany(BattleTool::class, 'state_battle_tools', 'state_id', 'battle_tool_id');
    }

}
