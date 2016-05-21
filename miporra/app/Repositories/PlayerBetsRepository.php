<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Player;

class PlayerBetsRepository
{
    const PLAYER_BETS_TYPE = 'App\Models\PlayerBet';

    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    protected function getCoupon()
    {
        return $this->coupon;
    }    

    protected function numberOfBets()
    {
        return $this->getCoupon()->numberOfbetsOfType(PlayerBetsRepository::PLAYER_BETS_TYPE);
    }

    protected function guardAgainstInvalidNumberOfPlayers($values)
    {
        if ( count($values) !==  $this->numberOfBets() )
        {
            throw new \App\Exceptions\NumberOfPlayetBetsDontMatchException();
        }
    }

    protected function getPlayerBets()
    {
           return $this->getCoupon()->betsOfType(PlayerBetsRepository::PLAYER_BETS_TYPE);
    }

    protected function getPlayerFromId($id)
    {
        return Player::findOrFail($id);
    }

    public function updatePlayersBetsFromValues($values)
    {
        $this->guardAgainstInvalidNumberOfPlayers($values);

        foreach ($this->getPlayerBets()->get() as $bet) {
            $player = $this->getPlayerFromId( array_shift($values) );

            $bet->bettype->associatePlayer($player);

            $bet->bettype->save();
        }
    }

    public function players()
    {
            $players = [];

            foreach ($this->getPlayerBets()->get() as $bet) {
                if ( $bet->isFilled() )
                {
                    $players[] = $bet->bettype->player;
                }                
            }

            return collect($players);
    }
}
