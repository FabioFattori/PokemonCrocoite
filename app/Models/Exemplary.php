<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exemplary extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'speed',
        'specialDefense',
        'defense',
        'attack',
        'specialAttack',
        'ps',
        'level',
        'catchDate',
        'pokemon_id',
        'gender_id',
        'nature_id',
        'user_team_id',
        'npc_id',
        'holding_tools_id',
        'box_id',
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }

    public function getWhereTheExemplaryIs()
    {
        if($this->user_team_id != null)
        {
            return 'Equipped in team of user ' . $this->user_team_id;
        }
        else if($this->npc_id != null)
        {
            return 'Equipped in team of NPC ' . $this->npc_id;
        }
        else if($this->box_id != null)
        {
            return 'Rests in box ' . $this->box_id;
        }
        else
        {
            return "WARNING : Esemplare Fantasma - L'esemplare non è ne in una box , ne in nessuna squadra ";
        }
    }
}
