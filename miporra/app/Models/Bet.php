<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Interfaces\Betable;

class Bet extends Model
{
    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon');
    }

    public function bettype()
    {
        return $this->morphTo();
    }

    public function addBettype(Betable $bettype){
        $this->bettype()->associate($bettype);
    }
}
