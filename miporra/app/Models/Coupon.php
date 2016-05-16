<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function championship()
    {
        return $this->belongsTo('App\Models\Championship');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function associateUser(User $user)
    {
        $this->user()->associate($user);
    }
}
