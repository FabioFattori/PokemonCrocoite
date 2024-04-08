<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['email', 'password', 'position_id'];

    public function getCurrentTeam()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function getBoxes()
    {
        return $this->hasMany(Box::class);
    }

    public function getEncounters()
    {
        return $this->hasMany(PokemonEncountered::class);
    }

    public function mnMt()
    {
        return $this->belongsToMany(MnMt::class, 'mn_mt_quantity')->withPivot('quantity');
    }

    public function storyTool()
    {
        return $this->belongsToMany(StoryTool::class, 'story_tool_user')->withPivot('quantity');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
