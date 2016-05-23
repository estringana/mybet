<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Coupon extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function bets()
    {
        return $this->hasMany('App\Models\Bet');
    }

    public function typesOfBet()
    {
        return $this->bets
            ->groupBy('bettype_type')
            ->keys();
    }

    public function betsOfType($type)
    {
        return $this->bets()->where('bettype_type', '=', $type);
    }

    public function subBetsOfType($type)
    {
        return $this->betsOfType($type)->get()->map(function ($bet, $key){
            return $bet->bettype;
        });
    }

    public function isTypeCompleted($type)
    {
           $bets = $this->betsOfType($type)->get();

           $empty = $bets->first(function ($key, $bet) {
                return $bet->isEmpty();
            });

           return is_null($empty);
    }

    public function numberOfbetsOfType($type)
    {
        return $this->betsOfType($type)->count();
    }

    public function associateUser(User $user)
    {
        $this->user()->associate($user);
    }

    public function addBet(Bet $bet)
    {
        $this->bets()->save($bet);
    }

    protected function createEmtpyMatchBets(BetConfiguration $configuration)
    {
           if ($configuration->round->matches->count() !== $configuration->number_of_bets)
           {
                throw new \Exception('Matches dont match configuration bets');
           }

            foreach ($configuration->round->matches as $match) {
                $betType = new $configuration->bet_mapping_class();

                $betType->setIdentification($configuration->round_id);

                $betType->associateMatch($match);

                $betType->save();

                $bet = new Bet();

                $this->addBet($bet);

                $bet->addBettype($betType);
                $bet->save();
            }
    }

    protected function createEmptySubtypeBets(BetConfiguration $configuration){
        for ($i=0; $i < $configuration->number_of_bets; $i++) { 
                $betType = new $configuration->bet_mapping_class();

                $betType->setIdentification($configuration->round_id);

                $betType->save();

                $bet = new Bet();

                $this->addBet($bet);

                $bet->addBettype($betType);
                $bet->save();                
            }
    }

    public function createEmtpyBets()
    {
        foreach ($this->championship->configurations as $configuration)
        {
            if ($configuration->bet_mapping_class == MatchBet::class){
                $this->createEmtpyMatchBets($configuration);
            }
            else
            {
                $this->createEmptySubtypeBets($configuration);
            }

        }
    }
}
