<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BetTest extends TestCase
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
    public function it_can_handle_a_bettype()
    {
        $bet = new App\Models\Bet();
        $playerBet = new App\Models\PlayerBet();
        
        $bet->addBettype($playerBet);

        $this->assertEquals( $bet->bettype->toArray() , $playerBet->toArray());
    }

    /** @test */
    public function it_return_the_right_subtype()
    {
        $bet = new App\Models\Bet();
        $playerBet = new App\Models\PlayerBet();
        
        $bet->addBettype($playerBet);

        $this->assertEquals( get_class($bet->bettype), get_class($playerBet) );
    }

    /** @test */
    public function it_return_the_right_subtype_again()
    {
        $bet = new App\Models\Bet();
        $matchBet = new App\Models\MatchBet();
        
        $bet->addBettype($matchBet);

        $this->assertEquals( get_class($bet->bettype), get_class($matchBet) );
    }

    /** @test */
    public function it_throw_an_exception_no_subtype_when_asking_for_identification()
    {
        $bet = new App\Models\Bet();

        $this->setExpectedException('\App\Exceptions\MissingSubtypeException');

        $bet->getIdentification();
    }

     /** @test */
    public function it_get_the_right_identification_from_a_subtype()
    {
        $bet = new App\Models\Bet();
        $matchBet = new App\Models\MatchBet();
        $match = factory(App\Models\Match::class)->create();

        $matchBet->associateMatch($match);        
        $bet->addBettype($matchBet);

        $this->assertEquals($bet->getIdentification(),$match->id);
    }
}
