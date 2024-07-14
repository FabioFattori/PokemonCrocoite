<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Captured extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $fillable = [
        'date',
        'exemplary_id',
        'user_id',
        'zone_id',
    ];

    public function exemplary(){
        return $this->belongsTo(Exemplary::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }
}
