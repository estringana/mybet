<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function coupons()
    {
        return $this->hasMany('App\Models\Coupon');
    }

    protected function createCouponForUserOnChampionshio(Championship $championship)
    {
            $coupon = new Coupon();
            $coupon->associateUser($this);
            $championship->addCoupon($coupon);
            $coupon->save();

            return $coupon;
    }

    public function couponOfChampionsip(Championship $championship)
    {
        try {
            $coupon = $this->coupons()->where('championship_id',$championship->id)->firstOrFail();
        }
        catch (\Exception $e)
        {
            $coupon = $this->createCouponForUserOnChampionshio($championship);
        }

        return $coupon;
    }
}
