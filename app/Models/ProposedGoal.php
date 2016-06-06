<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposedGoal extends Model
{
    public function proposedScore()
    {
        return $this->belongsTo('App\Models\ProposedScore');
    }

    public function player()
    {
        return $this->belongsTo('App\Models\Player');
    }

    public function addPlayer(Player $player)
    {
        $this->player()->associate($player);
    }
}
