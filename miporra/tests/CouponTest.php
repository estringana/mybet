<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\PlayerBet;
use App\Models\Championship;

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
        $championship = factory(Championship::class)->create();   
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
        $championship = factory(Championship::class)->create();   
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
        $championship = factory(Championship::class)->create();   
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
        $championship = factory(Championship::class)->create();   
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
        $championship = factory(Championship::class)->create();   
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

    /** @test */
    public function it_create_an_coupon_with_all_empty_bets()
    {
        $championship = create_real_championship();
        
        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $coupon->associateUser($user);
        $championship->addCoupon($coupon);        

        $coupon->createEmtpyBets();

        $this->assertEquals(74, $coupon->bets->count());
    }

    protected function playerbetsAllowedOnChampionship(Championship $championship)
    {
        return  $championship
            ->configurations()
            ->where('bet_mapping_class','=','App\Models\PlayerBet')
            ->first()
            ->number_of_bets;      
    }

    /** @test */
    public function it_does_not_create_more_player_bets_than_necesary()
    {    
        $championship = create_real_championship();

        $current_player_bets = PlayerBet::all()->count(); 
        $allowed_bets = $this->playerbetsAllowedOnChampionship($championship);
        $expted_bets_after_create_them = $current_player_bets + $allowed_bets;

        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $coupon->associateUser($user);
        $championship->addCoupon($coupon);        

        $coupon->createEmtpyBets();

        $this->assertEquals($expted_bets_after_create_them, PlayerBet::all()->count());
    }

    /** @test */
    public function it_should_return_true_if_all_the_bet_of_a_type_are_completed()
    {
        $championship = factory(Championship::class)->create();   
        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $coupon->associateUser($user);
        $championship->addCoupon($coupon);
        $coupon->save();

        $bet = new App\Models\Bet();        
        $player = factory(App\Models\Player::class)->create();
        $playerBet = new App\Models\PlayerBet();
        $playerBet->associatePlayer($player);
        $playerBet->save();
        $bet->addBettype($playerBet);
        $coupon->addBet($bet);
        $bet->save();

        $bet2 = new App\Models\Bet();        
        $playerBet2 = new App\Models\PlayerBet();
        $playerBet2->associatePlayer($player);
        $playerBet2->save();
        $bet2->addBettype($playerBet2);
        $coupon->addBet($bet2);
        $bet2->save();

        $this->assertTrue($coupon->isTypeCompleted(\App\Repositories\PlayerBetsRepository::PLAYER_BETS_TYPE));
    }

    /** @test */
    public function it_should_return_false_if_a_bet_of_a_type_is_not_completed()
    {
        $championship = factory(Championship::class)->create();   
        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $coupon->associateUser($user);
        $championship->addCoupon($coupon);
        $coupon->save();

        $bet = new App\Models\Bet();        
        $player = factory(App\Models\Player::class)->create();
        $playerBet = new App\Models\PlayerBet();
        $playerBet->associatePlayer($player);
        $playerBet->save();
        $bet->addBettype($playerBet);
        $coupon->addBet($bet);
        $bet->save();

        $bet2 = new App\Models\Bet();        
        $playerBet2 = new App\Models\PlayerBet();
        $playerBet2->save();
        $bet2->addBettype($playerBet2);
        $coupon->addBet($bet2);
        $bet2->save();

        $this->assertFalse($coupon->isTypeCompleted(\App\Repositories\PlayerBetsRepository::PLAYER_BETS_TYPE));
    }
}
