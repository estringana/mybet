<?php

namespace App\Repositories;

use App\Models\Round;
use App\Models\Team;

class TeamStatisticsRepository extends StatisticsRepositoryAbstract
{
    public function teams()
    {
        return $this->championship()->teams;
    } 

    public function rounds()
    {
        return $this->championship()->rounds;
    }    

    protected function betsWithTeamOnRound(Team $team,Round $round)
    {
        return $team->bets()->where('round_id',$round->id)->count();
    }
    
    public function getTeam($team_id)
    {
        $team = $this->teams()->first(function ($key, $team) use ($team_id) {
                return $team->id == $team_id;
        });        

        if ( is_null($team) )
        {
            throw new \App\Exceptions\TeamNotFoundException();
        }

        return $team;
    }
 
    public function getRound($round_id)
    {
        $round = $this->rounds()->first(function ($key, $round) use ($round_id) {
                return $round->id == $round_id;
        });        

        if ( is_null($round) )
        {
            throw new \App\Exceptions\RoundNotFoundException();
        }

        return $round;
    }

    public function percentageOfTeamOnRound($team_id,$round_id)
    {
           $team = $this->getTeam($team_id);
           $round = $this->getRound($round_id);

           return $this->betsWithTeamOnRound($team, $round) * 100 / $this->numberOfCoupons();
    }

    public function couponsWithTeamOnRound($team_id,$round_id)
    {
        $coupons = [];
        $team = $this->getTeam($team_id);
        $round = $this->getRound($round_id);

        foreach ($team->bets()->where('round_id', $round_id)->get() as $roundbet) {
           $coupons[] = $roundbet->bet->coupon;
        }

        return collect($coupons);
    }

    public function getBreakDownOfTeam($team_id)
    {
        $team = $this->getTeam($team_id);
        $rounds = $this->championship()->rounds;

        $breakDown = [];

        foreach ($rounds as $round) {
            $row = new \App\Championship\Statistics\BreakDownTeamOnRound();
            $row->round= $round;
            $row->percentage = $this->percentageOfTeamOnRound($team_id, $round->id);
            $row->coupons = $this->couponsWithTeamOnRound($team_id, $round->id);

            $breakDown[] = $row;
        }

        return collect($breakDown);
    }
}