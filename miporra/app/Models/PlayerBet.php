<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerBet extends Model implements \App\Interfaces\Betable
{
    const POINTS = 1;

    public function player()
    {
        return $this->belongsTo('App\Models\Player');
    }

    public function associatePlayer(Player $player)
    {
        $this->player()->associate($player);
    }

    public function getPointsAttribute()
    {
        return PlayerBet::POINTS * $this->player->countableGoals;
    }
}