<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class Match extends Model
{
    const LOCAL = 'local';
    const AWAY = 'away';
    const DRAW = 'draw';

    const SIGN_1 = '1';
    const SIGN_X = 'X';
    const SIGN_2 = '2';

    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function local()
    {
        return $this->belongsTo('App\Models\Team','local_team_id');
    }

    public function away()
    {
        return $this->belongsTo('App\Models\Team','away_team_id');
    }

    public function round()
    {
        return $this->belongsTo('App\Models\Round');
    }

    public function goals()
    {
        return $this->hasMany('App\Models\Goal');
    }

    public function bets()
    {
        return $this->hasMany('App\Models\MatchBet');
    }

    public function propositions()
    {
        return $this->hasMany('App\Models\ProposedScore');
    }

    public function addTeams(Team $local, Team $away)
    {
        $this->local()->associate($local);
        $this->away()->associate($away);
    }

    protected function guardAgainstInvalidScore($score)
    {
        if ( ! is_integer($score) || $score<0){
            throw new \App\Exceptions\InvalidScoreException();
        }
    }

    public function addScore($local, $away)
    {
        $this->guardAgainstInvalidScore($local);
        $this->guardAgainstInvalidScore($away);

        $this->local_score = $local;
        $this->away_score = $away;
    }

    public function addGoal(Goal $goal)
    {
        $this->goals()->save($goal);
    }

    public function addProposition(ProposedScore $proposition)
    {
        $this->propositions()->save($proposition);
    }

    protected function guardAgainstScoreNotProvidedYet()
    {
        if ( is_null($this->local_score) || is_null($this->away_score) )
        {
            throw new \App\Exceptions\ScoreNotProvidedYetException();
        }
    }

    public function winner()
    {
        $this->guardAgainstScoreNotProvidedYet();

        if ($this->local_score > $this->away_score)
        {
            return Match::LOCAL;
        }
        else if ($this->local_score < $this->away_score)
        {
            return Match::AWAY;
        }
        else
        {
            return Match::DRAW;
        }
    }

    public function get1X2()
    {
        switch ($this->winner()) {
            case Match::LOCAL:
                return Match::SIGN_1;
                break;
            case Match::DRAW:
                return Match::SIGN_X;
                break;
            default:
                return Match::SIGN_2;
                break;
        }
    }

}
