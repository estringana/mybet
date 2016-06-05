<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetConfiguration extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function round()
    {
        return $this->belongsTo('App\Models\Round');
    }

    public function associateRound(Round $round)
    {
           $this->round()->associate($round);
    }

    public function isRoundBet()
    {
           return $this->bet_mapping_class == 'App\Models\RoundBet';
    }
}
