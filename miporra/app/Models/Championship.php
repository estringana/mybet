<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Championship extends Model
{
    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }

    public function rounds()
    {
        return $this->hasMany('App\Models\Round');
    }

    public function bets()
    {
        return $this->hasMany('App\Models\Bet');
    }

    public function inProgress()
    {
        return Carbon::now() >= $this->start_date && Carbon::now() <= $this->end_date;
    }

    public function subscribeTeam(Team $team)
    {
        $this->teams()->save($team);
    }

    public function addRound(Round $round){
        $this->rounds()->save($round);
    }

    private function guardAgainstUserTwiceOnChampionship(Bet $bet)
    {
        if ( $this->bets()->where('user_id',$bet->user_id)->count() > 0 )
        {
            throw new \App\Exceptions\UserTwiceOnChampionshipException();
        }
    }

    public function addBet(Bet $bet)
    {
        $this->guardAgainstUserTwiceOnChampionship($bet);

        $this->bets()->save($bet);
    }
}
