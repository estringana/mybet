<?php

namespace App\Jobs;

use App\Models\Coupon;
use App\Models\Bet;
use App\Models\Championship;

class DeleteCoupon
{    
    protected function deleteBettype(Bet $bet)
    {
           $bet->bettype()->delete();
    }

    protected function deleteBets(Coupon $coupon)
    {
            foreach ($coupon->bets as $bet) {
                $this->deleteBettype($bet);
            }      

           $coupon->bets()->delete();
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Championship $championship , $coupon_id)
    {
        $coupon = $championship->coupons()->findOrFail($coupon_id);
        $this->deleteBets($coupon);
        $coupon->delete();
    }
}
