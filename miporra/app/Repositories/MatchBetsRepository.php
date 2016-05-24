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
}
