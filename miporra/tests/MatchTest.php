<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MatchTest extends TestCase
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
    public function it_can_add_teams()    
    {
        $teams = factory(App\Models\Team::class,2)->create();

        $match = factory(App\Models\Match::class)->create();

        $match->addTeams($teams[0],$teams[1]);

        $this->assertTrue($match->local->id == $teams[0]->id);
        $this->assertTrue($match->away->id == $teams[1]->id);
    }

    /** @test */
    public function it_should_say_that_the_winner_is_local_with_2_1_score()    
    {
        $match = factory(App\Models\Match::class)->create();

        $match->addScore(2,1);

        $this->assertTrue($match->winner() == App\Models\Match::LOCAL);
    }

     /** @test */
    public function it_should_say_that_the_winner_is_away_with_1_4_score()    
    {
        $match = factory(App\Models\Match::class)->create();

        $match->addScore(1,4);

        $this->assertTrue($match->winner() == App\Models\Match::AWAY);
    }

    /** @test */
    public function it_should_say_draw_with_score_3_3()    
    {
        $match = factory(App\Models\Match::class)->create();

        $match->addScore(3,3);

        $this->assertTrue($match->winner() == App\Models\Match::DRAW);
    }

    /** @test */
    public function it_should_throw_an_exception_if_no_score_yet()    
    {
        $match = factory(App\Models\Match::class)->create();

        $this->setExpectedException('\App\Exceptions\ScoreNotProvidedYetException');

        $match->winner();
    }

    /** @test */
    public function it_should_throw_an_exception_with_invalid_scores_on_away()    
    {
        $match = factory(App\Models\Match::class)->create();

        $this->setExpectedException('\App\Exceptions\InvalidScoreException');

        $match->addScore(3,-3);
    }

    /** @test */
    public function it_should_throw_an_exception_with_invalid_scores_on_local()    
    {
        $match = factory(App\Models\Match::class)->create();

        $this->setExpectedException('\App\Exceptions\InvalidScoreException');

        $match->addScore('2',3);
    }
}
