<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    use HasFactory;

    public $timestamps = false;

    //cast
    protected $casts = [
        'date' => 'datetime',
    ];

    protected $fillable = [
        'date',
        'user_1',
        'user_2',
        'winner', //1 if user 1, 2 if user 2, 0 else
    ];

    public function user1(){
        return $this->belongsTo(User::class, 'user_1', 'id');
    }

    public function user2(){
        return $this->belongsTo(User::class, 'user_2', 'id');
    }

    public function registry()
    {
        return $this->hasMany(BattleRegistry::class);
    }
}
