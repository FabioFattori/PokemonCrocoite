<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['email', 'password'];

    public function getCurrentTeam()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function getBoxes()
    {
        return $this->hasMany(Box::class);
    }
}
