<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function getOwner()
    {
        return $this->belongsTo(User::class);
    }

    public function getExemplariesInBox()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function getExemplariesInBoxCount()
    {
        return $this->getExemplariesInBox()->count();
    }

}
