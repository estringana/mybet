<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function assignToChampionship(Championship $championship)
    {
        $this->championship()->associate($championship);
    }
}
