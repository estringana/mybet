<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposedScore extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    public function match()
    {
        return $this->belongsTo('App\Models\Match');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function proposedGoals()
    {
           return $this->hasMany('App\Models\ProposedGoal');
    }

    public function addGoal(ProposedGoal $goal)
    {
        $this->proposedGoals()->save($goal);
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
           if ( ! is_numeric($score) || $score < 0 )
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
