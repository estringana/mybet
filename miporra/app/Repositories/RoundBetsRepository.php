<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\Match;

class RoundBetsRepository extends BetRepositoryAbstract
{
    const ROUND_BETS_TYPE = 'App\Models\RoundBet';

    protected function getIdentifier(){
        return RoundBetsRepository::ROUND_BETS_TYPE;
    }

    public function teams()
    {
        return $this->championship()->teams;
    }

   protected function getTeam($team_id)
    {
        $team = $this->teams()->first(function ($key, $team) use ($team_id) {
                return $team->id == $team_id;
        });        

        if ( is_null($team) )
        {
            throw new \App\Exceptions\TeamNotFoundException();
        }

        return $team;
    }

    protected function isRemovingBet($value)
    {
        return  is_null($value) || empty($value);   
    }    

    public function save($id, $value)
    {
        $roundbet = $this->findBet($id);
        
        if ($this->isRemovingBet($value))
        {
            $roundbet->disassociateTeam();
        }
        else
        {
            $team = $this->getTeam($value);
            
            $roundbet->associateTeam($team);            
        }

        $roundbet->save();
    }

    public function betsOfRound($round_id)
    {
        return $this->bets()->where('round_id',$round_id);
    }
}
