<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Match;
use App\Models\MatchBet;

class MatchBetTest extends TestCase
{
    use DatabaseTransactions;
    
    protected $matchBet;
    protected $match;


    protected function setUp()
    {
        parent::setUp();

        $this->matchBet = new App\Models\MatchBet();
        $this->match = factory(Match::class)->create();

        $this->matchBet->associateMatch($this->match);
    }

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
    public function it_can_add_matches()
    {        
        $this->assertTrue($this->matchBet->match->id == $this->match->id);
    }

     /** @test */
     public function it_return_1_point_when_match_matches_score_with_1()
     {
         $this->match->addScore(5,1);
         $this->matchBet->setPrediction(Match::SIGN_1);

         $this->assertEquals(MatchBet::POINTS, $this->matchBet->points);
     }    

     /** @test */
     public function it_return_exception_if_invalid_prediction()
     {
        $this->setExpectedException('\App\Exceptions\InvalidPredictionException');

        $this->matchBet->setPrediction('B');
     }

     /** @test */
     public function it_returns_0_if_match_has_no_score_yet()
     {
         $this->matchBet->setPrediction(Match::SIGN_1);

         $this->assertEquals(0, $this->matchBet->points);
     }

     /** @test */
    public function it_get_the_right_identification_from_matchbet_subtype()
    {
        $bet = new App\Models\Bet();
        $matchBet = new App\Models\MatchBet();
        $match = factory(App\Models\Match::class)->create();

        $matchBet->associateMatch($match);        
        $bet->addBettype($matchBet);

        $this->assertEquals($bet->getIdentification(), \App\Interfaces\Identifiable::NO_IDENTIFICATION);
    }
}
