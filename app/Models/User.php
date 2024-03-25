<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $timestamps = false;

    protected $fillable = ['email', 'password'];

    public function getCurrentTeam()
    {
        return $this->hasMany(Exemplary::class);
    }
}
