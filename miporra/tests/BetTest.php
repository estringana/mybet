<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BetTest extends TestCase
{
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
}