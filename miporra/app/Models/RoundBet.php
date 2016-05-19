<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoundBet extends Model implements \App\Interfaces\Betable, \App\Interfaces\Identifiable
{
    public function round()
    {
        return $this->belongsTo('App\Models\Bet');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function associateRound(Round $round)
    {
        $this->round()->associate($round);
    }

    public function associateTeam(Team $team)
    {
        $this->team()->associate($team);
    }    

    public function getPointsAttribute()
    {
        if ( $this->round->hasTeam($this->team) )
        {
            return $this->round->points;
        }

        return 0;
    }

    public function getIdentification()
    {
        return $this->round->id;
    }
}
