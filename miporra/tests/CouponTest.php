<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CouponTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_return_same_added_bet()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $coupon = new App\Models\Coupon();
        $bet = factory(App\Models\Bet::class)->make();   

        $coupon->associateUser($user);
        $championship->addCoupon($coupon);

        $coupon->addBet($bet);        

        $this->assertEquals($coupon->bets->toArray(), [$bet->toArray()]);
    }

    /** @test */
    public function it_return_same_added_bets()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $coupon = new App\Models\Coupon();
        $bets = factory(App\Models\Bet::class,2)->make();   

        $coupon->associateUser($user);
        $championship->addCoupon($coupon);

        $coupon->addBet($bets[0]);        
        $coupon->addBet($bets[1]);        
        
        $this->assertEquals(
            $coupon->bets->toArray(), 
            $bets->toArray()
        );

        $this->assertCount(2,$coupon->bets);
    }
}
