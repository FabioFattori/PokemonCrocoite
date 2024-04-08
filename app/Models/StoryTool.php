<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryTool extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'story_tool_user')->withPivot('quantity');
    }
}
