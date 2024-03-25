<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $timestamps = false;

    protected $fillable = [
        'name'   
    ];

    public function exemplary()
    {
        return $this->hasOne(Exemplary::class);
    }
}
