<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProposedScoreTest extends TestCase
{
    use DatabaseTransactions;
    
    /** @test */
    public function it_should_set_local_and_away_score_with_valid_scores()
    {
        $proposedScore = new App\Models\ProposedScore();

        $proposedScore->local_score = 1;
        $proposedScore->away_score = 1;

        $this->assertEquals(1, $proposedScore->local_score);
        $this->assertEquals(1, $proposedScore->away_score);
    }

    /** @test */
    public function it_should_throw_an_exception_with_invalid_local_scores()
    {
        $proposedScore = new App\Models\ProposedScore();

        $this->setExpectedException('\App\Exceptions\InvalidScoreException');

        $proposedScore->local_score = -1;
    }

     /** @test */
    public function it_should_throw_an_exception_with_invalid_away_scores()
    {
        $proposedScore = new App\Models\ProposedScore();

        $this->setExpectedException('\App\Exceptions\InvalidScoreException');

        $proposedScore->away_score = -1;
    }

    /** @test */
    public function it_should_throw_an_exception_with_invalid_local_scores_2()
    {
        $proposedScore = new App\Models\ProposedScore();

        $this->setExpectedException('\App\Exceptions\InvalidScoreException');

        $proposedScore->local_score = "";
    }

     /** @test */
    public function it_should_throw_an_exception_with_invalid_away_scores_2()
    {
        $proposedScore = new App\Models\ProposedScore();

        $this->setExpectedException('\App\Exceptions\InvalidScoreException');

        $proposedScore->away_score = "";
    }
}
