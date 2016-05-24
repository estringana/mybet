<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoundBet extends Model implements \App\Interfaces\Betable, \App\Interfaces\Identifiable, \App\Interfaces\Fillable
{
    protected $table = 'roundBets';

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

    public function disassociateTeam()
    {
        $this->team()->dissociate();
    }

    public function getPointsAttribute()
    {
        if ( $this->round->hasTeam($this->team) )
        {
            return 1;
        }

        return 0;
    }

    public function setIdentification($id){
        $round = Round::find($id);    
        $this->associateRound($round);
    }

    public function getIdentification()
    {
        return $this->round->id;
    }

    public function isEmpty()
    {
        return is_null($this->team);
    }

    public function isFilled()
    {
        return ! $this->isEmpty();
    }
}
