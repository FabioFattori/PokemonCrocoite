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
        return $this->belongsToMany(Exemplary::class, 'state_exemplary', 'state_id', 'exemplary_id');
    }

}
