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

    public function assignToChampionship(Championship $championship)
    {
        $this->championship()->associate($championship);
    }

    public function guardAgaisntChampionship(Team $team)
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
            throw new \App\Exceptions\ChampionshipDontMatchException();;
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
}
