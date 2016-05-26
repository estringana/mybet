<?php

namespace App\Championship;

use App\Models\Championship;

use App\Repositories\PlayerBetsRepository;
use App\Repositories\MatchBetsRepository;
use App\Repositories\RoundBetsRepository;

class TableGenerator
{
    private $championship;

    protected $playersRepository;
    protected $matchRepository;
    protected $roundRepository;

    public function __construct(Championship $championship)
    {
        $this->championship = $championship;
    }

    protected function coupons()
    {
           return $this->championship->coupons;
    }

    protected function instantiateRepositoriesFromCoupon($coupon)
    {
        $this->playersRepository = new PlayerBetsRepository($coupon);         
        $this->matchRepository = new MatchBetsRepository($coupon);         
        $this->roundRepository = new RoundBetsRepository($coupon);         
    }

    protected function getLine($coupon)
    {
        $line =  new \App\Championship\Table\Line();

        $line->userName = $coupon->user->name;
        $line->playerBets = $this->playersRepository->points();
        $line->matchBets = $this->matchRepository->points();
        $line->roundOf16Bets = $this->roundRepository->pointsOfRound(2);
        $line->quarterFinalsBets = $this->roundRepository->pointsOfRound(3);
        $line->semiFinals = $this->roundRepository->pointsOfRound(4);
        $line->final = $this->roundRepository->pointsOfRound(5);
        $line->champion = $this->roundRepository->pointsOfRound(6);
        $line->runnersup = $this->roundRepository->pointsOfRound(7);     

        return $line;
    }

    public function generate()
    {
        $result = [];

           foreach ($this->coupons() as $coupon) {
                $this->instantiateRepositoriesFromCoupon($coupon);

                $result[] = $this->getLine($coupon);          
           }

        return $result;
    }
    


}