<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleTool extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'healthRecovery',
    ];

    public function getExemplaryThatHoldsThisTool()
    {
        return $this->hasMany(Exemplary::class);
    }
}
