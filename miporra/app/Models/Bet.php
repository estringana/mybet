<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon');
    }    
}
