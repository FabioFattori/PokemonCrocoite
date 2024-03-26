<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleTollNpc extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'battle_toll_id',
        'npc_id',
        'amount',
    ];

    
}
