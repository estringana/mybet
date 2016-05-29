<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlayerBetTest extends TestCase
{
    use DatabaseTransactions;


    /**
* @test
* @group backend
*/
    public function it_can_add_players()
    {
        $playerBet = new App\Models\PlayerBet();
        $player = factory(App\Models\Player::class)->create();

        $playerBet->associatePlayer($player);

        $this->assertTrue($playerBet->player->id == $player->id);
    }

    /**
* @test
* @group backend
*/
    public function it_can_disassociate_player()
    {
        $playerBet = new App\Models\PlayerBet();
        $player = factory(App\Models\Player::class)->create();

        $playerBet->associatePlayer($player);

        $playerBet->save();

        $this->assertTrue($playerBet->player->id == $player->id);

        $playerBet->disassociatePlayer();        

        $this->assertEquals(null, $playerBet->player);
    }

    /**
* @test
* @group backend
*/
    public function it_counts_goals_from_a_player_bet_when_player_has_goals()
    {
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

        $this->assertEquals(2 , $playerBet->points);
    }

    /**
* @test
* @group backend
*/
    public function it_returns_0_from_a_player_bet_when_no_goals()
    {
        $playerBet = new App\Models\PlayerBet();

        $player = factory(App\Models\Player::class)->create();

        $playerBet->associatePlayer($player);

        $this->assertEquals(0 , $playerBet->points);
    }

    /**
* @test
* @group backend
*/
    public function it_get_the_right_identification_from_playerbet_subtype()
    {
        $bet = new App\Models\Bet();        
        $playerBet = new App\Models\PlayerBet();
        $player = factory(App\Models\Player::class)->create();

        $playerBet->associatePlayer($player);

        $bet->addBettype($playerBet);

        $this->assertEquals($bet->getIdentification(), \App\Interfaces\Identifiable::NO_IDENTIFICATION);
    }

    /**
* @test
* @group backend
*/
    public function it_does_not_save_identify()
    {
        $playerBet = new App\Models\PlayerBet();
        $playerBet->setIdentification('valueToNotBeSaved');

        $this->assertEquals($playerBet->getIdentification(), \App\Interfaces\Identifiable::NO_IDENTIFICATION);
    }
}
