<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }    

    public function teams(){
        return $this->belongsToMany('App\Models\Team');
    }

    public function matches(){
        return $this->hasMany('App\Models\Match');
    }

    public function assignToChampionship(Championship $championship)
    {
        $this->championship()->associate($championship);
    }

    protected function guardAgaisntChampionship(Team $team)
    {
        if ( ! $this->hasChampionship())
        {
            throw new \App\Exceptions\RoundHasNoChampionshipException();
        }

        if ( ! $team->hasChampionship())
        {
            throw new \App\Exceptions\TeamHasNoChampionshipException();
        }

        if ($team->championship->id !== $this->championship->id)
        {
            throw new \App\Exceptions\ChampionshipDontMatchException();
        }
    }

    public function hasChampionship()
    {
        return ! is_null($this->championship);
    }

    public function addTeam(Team $team){
        $this->guardAgaisntChampionship($team);

        $this->teams()->save($team);
    }

    public function addMatch(Match $match){
        $this->matches()->save($match);
    }

    protected function guardAgaisntInvalidPoints($points)
    {
        if ( ! is_int($points) || $points <= 0)
        {
            throw new \App\Exceptions\InvalidPointsException();;
        }
    }

    public function setPoints($points)
    {
        $this->guardAgaisntInvalidPoints($points);

        $this->points = $points;
    }

    public function hasTeam(Team $team)
    {
        return $this->teams()->where('team_id',$team->id)->count() > 0;
    }
}
