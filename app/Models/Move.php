<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'description',
        'name'
    ];
    
    public function exemplary()
    {
        return $this->belongsToMany(Exemplary::class);
    }

    public function canLearnFromLevel()
    {
        return $this->belongsToMany(Pokemon::class, "can_learn_level")->withPivot('level');
    }

    public function canLearnFromMachine()
    {
        return $this->belongsToMany(Pokemon::class, "can_learn_from_mn_mt");
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
