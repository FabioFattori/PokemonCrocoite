<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleRegistry extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'battle_id',
        'exemplary1_id',
        'exemplary2_id',
        'winner' //1 if exemplary 1, 2 if exemplary 2, 0 else
    ];

    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }
}
