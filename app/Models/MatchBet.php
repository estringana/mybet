<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchBet extends Model implements \App\Interfaces\Betable, \App\Interfaces\Identifiable, \App\Interfaces\Fillable
{
    protected $table = 'matchBets';
    
    public function match()
    {
        return $this->belongsTo('App\Models\Match');
    }

    public function bet()
    {
        return $this->morphOne('App\Models\Bet', 'bettype');
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
            return 1;
        }

        return 0;
    }

    public function setIdentification($id){}

    public function getIdentification()
    {
        return \App\Interfaces\Identifiable::NO_IDENTIFICATION;
    }

    public function isEmpty()
    {
        return is_null($this->prediction);
    }

    public function isFilled()
    {
        return ! $this->isEmpty();
    }
}
