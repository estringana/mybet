<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Bet;
use App\Models\PlayerBet;
use App\Models\MatchBet;
use App\Models\RoundBet;
use App\Models\Coupon;
use App\Jobs\DeleteCoupon;

class DeleteCouponTest extends TestCase
{
    use DatabaseTransactions;


    /**
    * @test
    * @group backend
    */
    public function it_should_leave_the_tables_as_they_were_before_when_deleting_a_coupon()
    {
        $numberOfBets = Bet::count();
        $numberOfPlayerBets = PlayerBet::count();
        $numberOfMatchBets = MatchBet::count();
        $numberOfRoundBets = RoundBet::count();
        $numberOfCoupons = Coupon::count();

       $championship = create_championship_with_users(1);

       $coupon = $championship->coupons()->first();

       $deleteCouponAction = new DeleteCoupon();
       $deleteCouponAction->handle($championship, $coupon->id);

        $this->assertEquals($numberOfBets , Bet::count());
        $this->assertEquals($numberOfPlayerBets , PlayerBet::count());
        $this->assertEquals($numberOfMatchBets , MatchBet::count());
        $this->assertEquals($numberOfRoundBets , RoundBet::count());
        $this->assertEquals($numberOfCoupons , Coupon::count());
    }


    /**
    * @test
    * @group backend
    */
    public function it_should_leave_the_tables_as_they_were_before_when_deleting_coupons()
    {
        $numberOfBets = Bet::count();
        $numberOfPlayerBets = PlayerBet::count();
        $numberOfMatchBets = MatchBet::count();
        $numberOfRoundBets = RoundBet::count();
        $numberOfCoupons = Coupon::count();

       $championship = create_championship_with_users(5);

       $deleteCouponAction = new DeleteCoupon();

       foreach ($championship->coupons as $coupon) {
            $deleteCouponAction->handle($championship, $coupon->id);
       }

        $this->assertEquals($numberOfBets , Bet::count());
        $this->assertEquals($numberOfPlayerBets , PlayerBet::count());
        $this->assertEquals($numberOfMatchBets , MatchBet::count());
        $this->assertEquals($numberOfRoundBets , RoundBet::count());
        $this->assertEquals($numberOfCoupons , Coupon::count());
    }

    /**
    * @test
    * @group backend
    */
    public function it_should_only_leave_one_new_coupon_on_the_tables_if_creating_two_and_deleting_one()
    {
        $numberOfBets = Bet::count();
        $numberOfPlayerBets = PlayerBet::count();
        $numberOfMatchBets = MatchBet::count();
        $numberOfRoundBets = RoundBet::count();
        $numberOfCoupons = Coupon::count();

       $championship = create_championship_with_users(2);

       $deleteCouponAction = new DeleteCoupon();

       
       $deleteCouponAction->handle($championship, $championship->coupons()->first()->id);

        $this->assertEquals($numberOfBets + 74 , Bet::count());
        $this->assertEquals($numberOfPlayerBets + 8, PlayerBet::count());
        $this->assertEquals($numberOfMatchBets + 36 , MatchBet::count());
        $this->assertEquals($numberOfRoundBets + 30, RoundBet::count());
        $this->assertEquals($numberOfCoupons + 1, Coupon::count());
    }

    /**
    * @test
    * @group backend
    */
    public function it_should_leave_the_tables_as_they_were_before_when_deleting_coupons_suming_ids()
    {
        $numberOfBets = DB::table('bets')->sum('id');
        $numberOfPlayerBets = DB::table('playerBets')->sum('id');
        $numberOfMatchBets = DB::table('matchBets')->sum('id');
        $numberOfRoundBets = DB::table('roundBets')->sum('id');
        $numberOfCoupons = DB::table('coupons')->sum('id');

       $championship = create_championship_with_users(5);

       $deleteCouponAction = new DeleteCoupon();

       foreach ($championship->coupons as $coupon) {
            $deleteCouponAction->handle($championship, $coupon->id);
       }

        $this->assertEquals($numberOfBets , DB::table('bets')->sum('id'));
        $this->assertEquals($numberOfPlayerBets , DB::table('playerBets')->sum('id'));
        $this->assertEquals($numberOfMatchBets , DB::table('matchBets')->sum('id'));
        $this->assertEquals($numberOfRoundBets , DB::table('roundBets')->sum('id'));
        $this->assertEquals($numberOfCoupons , DB::table('coupons')->sum('id'));
    }

    /**
    * @test
    * @group backend
    */
    public function it_throws_an_exception_if_coupon_not_found()
    {     
       $championship = create_championship_with_users(5);

       $deleteCouponAction = new DeleteCoupon();

       $this->setExpectedException('\Exception');

        $deleteCouponAction->handle($championship, 123412341234);
    }
}
