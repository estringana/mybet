<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Player;

class PlayerBetsRepository
{
    const PLAYER_BETS_TYPE = 'App\Models\PlayerBet';

    protected $coupon;
    protected $bets;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->championship = $coupon->championship;
    }

    protected function getCoupon()
    {
        return $this->coupon;
    }

    protected function getPlayerBets()
    {
            if ( is_null($this->bets) )
            {
                $this->bets = $this->getCoupon()->subBetsOfType(PlayerBetsRepository::PLAYER_BETS_TYPE);
            }

            return $this->bets;
    }

    public function bets()
    {
        return $this->getPlayerBets();
    }

    protected function findBet($id){
            $bet = $this->getPlayerBets()->first(function($key, $bet) use($id){
                return $bet->id == $id;
            });

            if ( is_null($bet) )
            {
                throw new \App\Exceptions\BetNotFoundException();
            }

            return $bet;       
    }

    public function players()
    {
        return $this->championship->players;
    }

    protected function getPlayer($player_id)
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

    public function save($id, $value)
    {
        $playerbet = $this->findBet($id);
        
        if ( is_null($value) || empty($value) )
        {
            $playerbet->disassociatePlayer();
        }
        else
        {
            $player = $this->getPlayer($value);
            
            $playerbet->associatePlayer($player);            
        }


        $playerbet->save();
    }
}
