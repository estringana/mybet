<?php

namespace App\Repositories;

use \App\Models\Match;

class MatchStatisticsRepository extends StatisticsRepositoryAbstract
{
    public function matches()
    {
        return $this->championship()->matches;
    }

    public function getMatch($match_id)
    {
        $match = $this->matches()->first(function ($key, $match) use ($match_id) {
                return $match->id == $match_id;
        });   

        if ( is_null($match) )
        {
            throw new \App\Exceptions\MatchNotFoundException();
        }

        return $match;
    }

    protected function betsWithMatchAndPrediction(Match $match, $prediction)
    {
        return $match->bets()->where('prediction',$prediction)->count();
    }

    public function percentageWithPrediction($match_id, $prediction)
    {
           $match = $this->getMatch($match_id);

           return $this->betsWithMatchAndPrediction($match, $prediction) * 100 / $this->numberOfCoupons();
    }

    public function couponsWithMatchAndPrediction($match_id, $prediction)
    {
        $coupons = [];
        $match = $this->getMatch($match_id);

        foreach ($match->bets as $matchbet) {
            if ($matchbet->prediction == $prediction)
            {
                $coupons[] = $matchbet->bet->coupon;
            }           
        }

        return collect($coupons);
    }
}