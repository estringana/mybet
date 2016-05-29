<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BetTest extends TestCase
{
    use DatabaseTransactions;



    /**
* @test
* @group backend
*/
    public function it_can_handle_a_bettype()
    {
        $bet = new App\Models\Bet();
        $playerBet = new App\Models\PlayerBet();
        
        $bet->addBettype($playerBet);

        $this->assertEquals( $bet->bettype->toArray() , $playerBet->toArray());
    }

    /**
* @test
* @group backend
*/
    public function it_return_the_right_subtype()
    {
        $bet = new App\Models\Bet();
        $playerBet = new App\Models\PlayerBet();
        
        $bet->addBettype($playerBet);

        $this->assertEquals( get_class($bet->bettype), get_class($playerBet) );
    }

    /**
* @test
* @group backend
*/
    public function it_return_the_right_subtype_again()
    {
        $bet = new App\Models\Bet();
        $matchBet = new App\Models\MatchBet();
        
        $bet->addBettype($matchBet);

        $this->assertEquals( get_class($bet->bettype), get_class($matchBet) );
    }

    /**
* @test
* @group backend
*/
    public function it_throw_an_exception_no_subtype_when_asking_for_identification()
    {
        $bet = new App\Models\Bet();

        $this->setExpectedException('\App\Exceptions\MissingSubtypeException');

        $bet->getIdentification();
    }

    /**
* @test
* @group backend
*/
    public function it_should_return_0_points_if_subtype_empty()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $coupon = new App\Models\Coupon();
        $bet = factory(App\Models\Bet::class)->make();   

        $coupon->associateUser($user);
        $championship->addCoupon($coupon);

        $coupon->addBet($bet); 

        $playerBet = new App\Models\PlayerBet();
        $playerBet->save();

        $bet->addBettype($playerBet);

        $bet->save();

        $this->assertEquals(0, $bet->points);
    }

    /**
* @test
* @group backend
*/
    public function it_should_return_the_points_of_the_subtype()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $coupon = new App\Models\Coupon();
        $bet = factory(App\Models\Bet::class)->make();   

        $coupon->associateUser($user);
        $championship->addCoupon($coupon);

        $coupon->addBet($bet); 

        $playerBet = new App\Models\PlayerBet();
        
        $goal01 = new App\Models\Goal();
        $goal02 = new App\Models\Goal();
        $match = factory(App\Models\Match::class)->create();
        $player = factory(App\Models\Player::class)->create();

        $goal01->addPlayer($player);
        $goal02->addPlayer($player);

        $playerBet->associatePlayer($player);

        $match->addGoal($goal01);
        $match->addGoal($goal02);

        $bet->addBettype($playerBet);

        $bet->save();

        $this->assertEquals(2, $bet->points);
    }

    /**
* @test
* @group backend
*/
    public function it_should_throw_an_excption_if_no_subtype()
    {
        $bet = factory(App\Models\Bet::class)->make(); 

        $this->setExpectedException('\App\Exceptions\MissingSubtypeException');

        $bet->points;
    }
}
