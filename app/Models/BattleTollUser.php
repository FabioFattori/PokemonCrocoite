<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleTollUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'battle_toll_id',
        'user_id',
        'amount',
    ];

    
}
