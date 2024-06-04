<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateExemplary extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'exemplary_id',
        'state_id',
    ];

    public function exemplary()
    {
        return $this->belongsTo(Exemplary::class);
    }
}
