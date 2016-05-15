<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function rounds(){
        return $this->belongsToMany('App\Models\Round');
    }

    public function addToChampionship(Championship $championship)
    {
        $this->championship()->associate($championship);
    }    

    public function hasChampionship()
    {
        return ! is_null($this->championship);
    }
}
