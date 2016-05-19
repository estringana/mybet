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

    /** @test */
    public function it_returns_types_A_and_B_when_asking_for_types()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $betA = factory(App\Models\Bet::class)->make(['bettype_type'=>'A']);   
        $betB = factory(App\Models\Bet::class)->make(['bettype_type'=>'B']);   
        $betB2 = factory(App\Models\Bet::class)->make(['bettype_type'=>'B']);   

        $coupon->associateUser($user);
        $championship->addCoupon($coupon);

        $coupon->addBet($betA);        
        $coupon->addBet($betB);    
        $coupon->addBet($betB2);    

        $this->assertEquals(
            $coupon->typesOfBet()->toArray(),
            ['A', 'B']
        );
    }

    /** @test */
    public function it_returns_right_bets_when_asking_for_bets_of_type_B()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $betA = factory(App\Models\Bet::class)->make(['bettype_type'=>'A']);   
        $betB = factory(App\Models\Bet::class)->make(['bettype_type'=>'B']);   
        $betB2 = factory(App\Models\Bet::class)->make(['bettype_type'=>'B']);   

        $coupon->associateUser($user);
        $championship->addCoupon($coupon);

        $coupon->addBet($betA);        
        $coupon->addBet($betB);    
        $coupon->addBet($betB2);

        $this->assertEquals(
            $coupon->betsOfType('B')->pluck('id')->toArray(),
            [ $betB->id, $betB2->id ]
        );
    }

    /** @test */
    public function it_returns_2_when_asking_for_bets_of_type_B_count()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $betA = factory(App\Models\Bet::class)->make(['bettype_type'=>'A']);   
        $betB = factory(App\Models\Bet::class)->make(['bettype_type'=>'B']);   
        $betB2 = factory(App\Models\Bet::class)->make(['bettype_type'=>'B']);   

        $coupon->associateUser($user);
        $championship->addCoupon($coupon);

        $coupon->addBet($betA);        
        $coupon->addBet($betB);    
        $coupon->addBet($betB2);

        $this->assertEquals(
            $coupon->numberOfbetsOfType('B'),
            2
        );
    }
}
