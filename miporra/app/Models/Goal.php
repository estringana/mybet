<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function match()
    {
        return $this->belongsTo('App\Models\Match');
    }

    public function player()
    {
        return $this->belongsTo('App\Models\Player');
    }

    public function addPlayer(Player $player)
    {
        $this->player()->associate($player);
    }

    public function shouldCount(){
        if ($this->penalty_round || $this->own_goal) {
            return false;
        }

        return true;
    }
}
