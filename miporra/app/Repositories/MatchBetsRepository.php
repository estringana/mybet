<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\Match;

class MatchBetsRepository extends BetRepositoryAbstract
{
    const MATCH_BETS_TYPE = 'App\Models\MatchBet';

    protected function getIdentifier(){
        return MatchBetsRepository::MATCH_BETS_TYPE;
    }

    public function save($id, $value)
    {
        $matchbet = $this->findBet($id);

        $matchbet->setPrediction($value);

        $matchbet->save();
    }

    protected function getValueOfPoints()
    {
           return $this->championship()->getPointsOfTypeIdentifyBy($this->getIdentifier());
    }

    public function points()
    {
        $points_of_type = $this->getValueOfPoints();

        $points = $this->bets()->sum(function ($bet) use ($points_of_type) {
            return $bet->points * $points_of_type;
        });

        return $points;
    }
}
