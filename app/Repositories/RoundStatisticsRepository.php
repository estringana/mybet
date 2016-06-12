<?php

namespace App\Repositories;

use App\Models\RoundBet;
use App\Models\Round;
use App\Models\Team;
use App\Championship\Statistics\BreakDownTeamOnRound;

class RoundStatisticsRepository extends StatisticsRepositoryAbstract
{
    public function rounds()
    {
        return $this->championship()->rounds;
    }

    public function teams()
    {
        return $this->championship()->teams;
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

    protected function percetangeOfTeamOnRound(Team $team, Round $round)
    {
           $bets = $round->bets()->where('team_id',$team->id)->count();

           return $bets * 100 / $this->numberOfCoupons();
    }

    protected function sortTeamsByPercentage($roundsBreakDown)
    {
           return $roundsBreakDown->sortByDesc(function ($roundStatistics, $key) {
                return $roundStatistics->percentage;
           });
    }

    public function teamBreakDownOnRound($round_id)
    {
           $roundsBreakDown = collect([]);
           $round = $this->getRound($round_id);

           foreach ($this->teams() as $team) {
               $teamStatistics = new BreakDownTeamOnRound();
               $teamStatistics->round = $round;
               $teamStatistics->team = $team;
               $teamStatistics->percentage = $this->percetangeOfTeamOnRound($team, $round);
               $roundsBreakDown->push($teamStatistics);
           }

           return $this->sortTeamsByPercentage($roundsBreakDown);
    }
}