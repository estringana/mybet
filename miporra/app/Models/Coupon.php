<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public function bets()
    {
        return $this->hasMany('App\Models\Bet');
    }

    public function typesOfBet()
    {
        return $this->bets
            ->groupBy('bettype_type')
            ->keys();
    }

    public function betsOfType($type)
    {
        return $this->bets()->where('bettype_type', '=', $type);
    }

    public function numberOfbetsOfType($type)
    {
        return $this->betsOfType($type)->count();
    }

    public function associateUser(User $user)
    {
        $this->user()->associate($user);
    }

    public function addBet(Bet $bet)
    {
        $this->bets()->save($bet);
    }
}
