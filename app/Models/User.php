<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use ErrorException;

class User extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['email', 'password', 'position_id'];

    public function currentTeam()
    {
        $team= Team::where('user_id', $this->id)->get()->first();
        if($team != null){
            return $team->pokemons();
        }
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTeamId()
    {
        $team= Team::where('user_id', $this->id)->get()->first();
        if($team != null){
            return $team->id;
        }
        throw new ErrorException("User has no team");
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

    public function storyTools()
    {
        return $this->belongsToMany(StoryTool::class, 'story_tool_user')->withPivot('quantity');
    }

    public function battleTools()
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

    public function exemplaries(){
        return $this->join('teams', 'teams.user_id', '=', 'users.id')
            ->join('exemplaries', 'teams.id', '=', 'exemplaries.team_id')
            ->select('exemplaries.*');
    }
}
