<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Player;

class PlayerBetsRepository extends BetRepositoryAbstract
{
    const PLAYER_BETS_TYPE = 'App\Models\PlayerBet';

    protected function getIdentifier(){
        return PlayerBetsRepository::PLAYER_BETS_TYPE;
    }

    public function players()
    {
        return $this->championship()->players;
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

    protected function isRemovingPlayer($value)
    {
        return  is_null($value) || empty($value);   
    }    

    public function save($id, $value)
    {
        $playerbet = $this->findBet($id);
        
        if ($this->isRemovingPlayer($value))
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
