<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

     public function goals()
    {
        return $this->hasMany('App\Models\Goal');
    }

    public function countableGoals()
    {
        $goals = 0;

        foreach ($this->goals as $goal) {
            if ($goal->shouldCount()){
                $goals++;
            }
        }

        return $goals;
    }
}
