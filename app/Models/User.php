<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['email', 'password', 'position_id'];

    public function currentTeam()
    {
        return $this->hasMany(Exemplary::class);
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }

    public function pokemonsEncountered()
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

    public function battleTool()
    {
        return $this->belongsToMany(BattleTool::class, 'battle_tool_users')->withPivot('amount');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class, 'user_id');
    }
}
