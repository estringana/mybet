<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Interfaces\Fillable;
use \App\Interfaces\Betable;
use \App\Interfaces\Identifiable;

class Bet extends Model implements Identifiable, Fillable, \App\Interfaces\Betable
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

    public function setIdentification($id)
    {
        $this->bettype->setIdentification($id);
    }

    public function getIdentification()
    {
        if ( ! $this->hasSubtype() )
        {
            throw new \App\Exceptions\MissingSubtypeException();
        }

        return $this->bettype->getIdentification();
    }

    public function isEmpty()
    {
        return $this->bettype->isEmpty();
    }

    public function isFilled()
    {
        return $this->bettype->isFilled();
    }

    protected function guardAgainstAccessingToSubtypeWhenNotExists()
    {
        if ( ! $this->hasSubtype() )
        {
            throw new \App\Exceptions\MissingSubtypeException();
        }
    }

    public function getPointsAttribute()
    {
        $this->guardAgainstAccessingToSubtypeWhenNotExists();

        if ( $this->isEmpty() )
        {
            return 0;
        }

        return $this->bettype->points;
    }
}
