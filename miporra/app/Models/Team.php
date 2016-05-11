<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function addToChampionship(Championship $championship)
    {
        $this->championship()->associate($championship);
    }
}
