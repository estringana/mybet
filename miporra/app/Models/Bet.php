<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Interfaces\Betable;
use \App\Interfaces\Identifiable;

class Bet extends Model implements Identifiable
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

    protected function hasSubtype()
    {
        return ! is_null($this->bettype);
    }

    public function getIdentification()
    {
        if ( ! $this->hasSubtype() )
        {
            throw new \App\Exceptions\MissingSubtypeException();
        }

        return $this->bettype->getIdentification();
    }
}
