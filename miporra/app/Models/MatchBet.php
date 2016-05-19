<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchBet extends Model implements \App\Interfaces\Betable, \App\Interfaces\Identifiable
{
    const POINTS = 1;

    public function match()
    {
        return $this->belongsTo('App\Models\Match');
    }

    public function associateMatch(Match $match)
    {
        $this->match()->associate($match);
    }

    public static function validPredictions()
    {
        return [ Match::SIGN_1,  Match::SIGN_X,  Match::SIGN_2];
    }

    protected  function guardAgainstInvalidPredictions($prediction)
    {
        if ( ! in_array($prediction, MatchBet::validPredictions()) )
        {
            throw new \App\Exceptions\InvalidPredictionException();
        }
    }

    public function setPrediction($prediction)
    {
        $this->guardAgainstInvalidPredictions($prediction);

        $this->prediction = $prediction;
    }

    protected function isPredictionGuessed()
    {
        try
        {
            return $this->prediction == $this->match->get1X2();    
        }
        catch (\App\Exceptions\ScoreNotProvidedYetException $exception)
        {
            return false;
        }        
    }

    public function getPointsAttribute()
    {
        if ( $this->isPredictionGuessed() )
        {            
            return MatchBet::POINTS;
        }

        return 0;
    }

    public function getIdentification()
    {
        return $this->match->id;
    }
}
