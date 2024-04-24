<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battles extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'user_1',
        'user_2',
        'winner',
    ];
}
