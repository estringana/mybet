<?php

namespace App\Repositories;

use App\Models\PlayerBet;
use App\Models\Player;

class PlayerStatisticsRepository extends StatisticsRepositoryAbstract
{
    public function players()
    {
        return $this->championship()->players;
    }

    protected function betsWithPlayer(Player $player)
    {
        return $player->bets()->count();
    }
    
    public function getPlayer($player_id)
    {
        $player = $this->players()->first(function ($key, $player) use ($player_id) {
                return $player->id == $player_id;
        });        

        if ( is_null($player) )
        {
            throw new \App\Exceptions\PlayerNotFoundException();
        }

        return $player;
    }

    public function percentage($player_id)
    {
           $player = $this->getPlayer($player_id);

           return $this->betsWithPlayer($player) * 100 / $this->numberOfCoupons();
    }

    protected function sortPlayersByPercentage($playersBreakDown)
    {
           return $playersBreakDown->sortByDesc(function ($playerStatistics, $key) {
                return $playerStatistics->percentage;
           });
    }

    public function all()
    {
            $playersBreakDown = collect([]);

            foreach ($this->players() as $player)
            {
                $playerStatistics = new \App\Championship\Statistics\BreakDownPlayer();
                $playerStatistics->player = $player;
                $playerStatistics->percentage = $this->percentage($player->id);
                $playersBreakDown->push($playerStatistics);
            }

            return $this->sortPlayersByPercentage($playersBreakDown);
    }

    public function couponsWithPlayer($player_id)
    {
        $coupons = [];
        $player = $this->getPlayer($player_id);

        foreach ($player->bets as $playerbet) {
           $coupons[] = $playerbet->bet->coupon;
        }

        return collect($coupons);
    }
}