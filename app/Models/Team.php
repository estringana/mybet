<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function bets()
    {
        return $this->hasMany('App\Models\RoundBet');
    }

    public function rounds(){
        return $this->belongsToMany('App\Models\Round');
    }

    public function players(){
        return $this->hasMany('App\Models\Player');
    }

    public function addToChampionship(Championship $championship)
    {
        $this->championship()->associate($championship);
    }    

    public function hasChampionship()
    {
        return ! is_null($this->championship);
    }

    public function addPlayer(Player $player)
    {
        $this->players()->save($player);
    }

    public function hasPlayer(Player $player)
    {
        return $this->players()->where( 'id', $player->id )->count() == 1;
    }
}
