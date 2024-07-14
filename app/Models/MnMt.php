<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MnMt extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['move_id', 'number', 'description'];

    public function move()
    {
        return $this->belongsTo(Move::class);
    }

    public function user()
    {
        //has many user, mn_mt_quantity as pivot table
        return $this->belongsToMany(User::class, 'mn_mt_quantity', 'mn_mt_id', 'user_id')->withPivot('quantity');
    }
}
