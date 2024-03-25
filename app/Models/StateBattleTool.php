<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateBattleTool extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'state_id',
        'battle_tool_id',
    ];

    
}
