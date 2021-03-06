<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerBet extends Model implements \App\Interfaces\Betable, \App\Interfaces\Identifiable, \App\Interfaces\Fillable
{
    const POINTS = 1;

    protected $table = 'playerBets';

    public function player()
    {
        return $this->belongsTo('App\Models\Player');
    }

    public function bet()
    {
        return $this->morphOne('App\Models\Bet', 'bettype');
    }

    public function associatePlayer(Player $player)
    {
        $this->player()->associate($player);
    }

    public function disassociatePlayer()
    {
        $this->player()->dissociate();
    }

    public function getPointsAttribute()
    {
        if ( $this->isEmpty() )
        {
            return 0;
        }

        return $this->player->countableGoals;
    }

    public function getIdentification()
    {
        return \App\Interfaces\Identifiable::NO_IDENTIFICATION;
    }

    public function setIdentification($id){}

    public function isEmpty()
    {
        return is_null($this->player);
    }

    public function isFilled()
    {
        return ! $this->isEmpty();
    }
}
