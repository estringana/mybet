<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Championship extends Model
{
    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }

    public function rounds()
    {
        return $this->hasMany('App\Models\Round');
    }

    public function configuration()
    {
        return $this->hasOne('App\Models\betConfiguration');
    }

    public function coupons()
    {
        return $this->hasMany('App\Models\Coupon');
    }

    public function inProgress()
    {
        return Carbon::now() >= $this->start_date && Carbon::now() <= $this->end_date;
    }

    public function subscribeTeam(Team $team)
    {
        $this->teams()->save($team);
    }

    public function addRound(Round $round){
        $this->rounds()->save($round);
    }

    private function guardAgainstUserTwiceOnChampionship(Coupon $coupon)
    {
        if ( $this->coupons()->where('user_id',$coupon->user_id)->count() > 0 )
        {
            throw new \App\Exceptions\UserTwiceOnChampionshipException();
        }
    }

    public function addCoupon(Coupon $coupon)
    {
        $this->guardAgainstUserTwiceOnChampionship($coupon);

        $this->coupons()->save($coupon);
    }

    public function addConfiguration(BetConfiguration $betConfiguration)
    {
        $this->configuration()->save($betConfiguration);
    }
}
