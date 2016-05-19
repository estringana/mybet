<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlayerBetTest extends TestCase
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
    public function it_can_add_players()
    {
        $playerBet = new App\Models\PlayerBet();
        $player = factory(App\Models\Player::class)->create();

        $playerBet->associatePlayer($player);

        $this->assertTrue($playerBet->player->id == $player->id);
    }

    /** @test */
    public function it_counts_goals_from_a_player_bet_when_player_has_goals()
    {
        $matchBet = new App\Models\PlayerBet();
        
        $goal01 = new App\Models\Goal();
        $goal02 = new App\Models\Goal();
        $match = factory(App\Models\Match::class)->create();
        $player = factory(App\Models\Player::class)->create();

        $goal01->addPlayer($player);
        $goal02->addPlayer($player);

        $matchBet->associatePlayer($player);

        $match->addGoal($goal01);
        $match->addGoal($goal02);

        $this->assertEquals(2 , $matchBet->points);
    }

    /** @test */
    public function it_returns_0_from_a_player_bet_when_no_goals()
    {
        $matchBet = new App\Models\PlayerBet();

        $player = factory(App\Models\Player::class)->create();

        $matchBet->associatePlayer($player);

        $this->assertEquals(0 , $matchBet->points);
    }

    /** @test */
    public function it_get_the_right_identification_from_playerbet_subtype()
    {
        $bet = new App\Models\Bet();        
        $matchBet = new App\Models\PlayerBet();
        $player = factory(App\Models\Player::class)->create();

        $matchBet->associatePlayer($player);

        $bet->addBettype($matchBet);

        $this->assertEquals($bet->getIdentification(), \App\Interfaces\Identifiable::NO_IDENTIFICATION);
    }
}
