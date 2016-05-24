<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\Match;

abstract class BetRepositoryAbstract
{
    protected $coupon;

    abstract protected function getIdentifier();

    abstract protected function save($id, $value);

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }
    
    protected function championship()
    {
        return $this->coupon->championship;
    }

    protected function getCoupon()
    {
        return $this->coupon;
    }

    protected function findBet($id){
        $bet = $this->bets()->first(function($key, $bet) use($id){
            return $bet->id == $id;
        });

        if ( is_null($bet) )
        {
            throw new \App\Exceptions\BetNotFoundException();
        }

        return $bet;       
    }

    public function bets()
    {
            return $this->getCoupon()->subBetsOfType($this->getIdentifier());
    }

}