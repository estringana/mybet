<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetConfiguration extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }
}
