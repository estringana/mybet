<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchBet extends Model implements \App\Interfaces\Betable
{
    public function match()
    {
        return $this->belongsTo('App\Models\Match');
    }

    public function associateMatch(Match $match)
    {
        $this->match->associate($match);
    }

    public function getPointsAttribute()
    {
        
    }
}
