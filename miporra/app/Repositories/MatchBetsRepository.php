<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\Match;

class MatchBetsRepository
{
    const MATCH_BETS_TYPE = 'App\Models\MatchBet';

    protected $coupon;
    protected $bets;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    protected function getCoupon()
    {
        return $this->coupon;
    }

    protected function getMatchBets()
    {
            if ( is_null($this->bets) )
            {
                $this->bets = $this->getCoupon()->subBetsOfType(MatchBetsRepository::MATCH_BETS_TYPE);
            }

            return $this->bets;
    }

    protected function findBet($id){
            $bet = $this->getMatchBets()->first(function($key, $bet) use($id){
                return $bet->id == $id;
            });

            if ( is_null($bet) )
            {
                throw new \App\Exceptions\BetNotFoundException();
            }

            return $bet;       
    }

    public function save($id, $value)
    {
        $matchbet = $this->findBet($id);

        $matchbet->setPrediction($value);

        $matchbet->save();
    }

    public function bets()
    {
        return $this->getMatchBets();
    }

}
