<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposedScore extends Model
{
    public function match()
    {
        return $this->belongsTo('App\Models\Match');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function addMatch(Match $match)
    {
           $this->match()->associate($match);
    }

    public function addUser(User $user)
    {
           $this->user()->associate($user);
    }

    protected function guardAgainstInvalidScores($score)
    {
           if ( empty($score) || $score < 0)
            {
                throw new \App\Exceptions\InvalidScoreException();
            }
    }

    public function setLocalScoreAttribute($score)
    {
        $this->guardAgainstInvalidScores($score);   

        $this->attributes['local_score'] = $score;
    }

     public function setAwayScoreAttribute($score)
    {
        $this->guardAgainstInvalidScores($score);   

        $this->attributes['away_score'] = $score;
    }
}
