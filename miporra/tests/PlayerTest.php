<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlayerTest extends TestCase
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
    public function it_can_have_a_goal()
    {
        $goal = new App\Models\Goal();
        $match = factory(App\Models\Match::class)->create();
        $player = factory(App\Models\Player::class)->create();

        $goal->addPlayer($player);

        $match->addGoal($goal);

        $this->assertCount(1, $player->goals);      
    }

    /** @test */
    public function it_can_have_multiple_goals()
    {
        $goal01 = new App\Models\Goal();
        $goal02 = new App\Models\Goal();
        $goal03 = new App\Models\Goal();
        $match = factory(App\Models\Match::class)->create();
        $player = factory(App\Models\Player::class)->create();

        $goal01->addPlayer($player);
        $goal02->addPlayer($player);
        $goal03->addPlayer($player);

        $match->addGoal($goal01);
        $match->addGoal($goal02);
        $match->addGoal($goal03);

        $this->assertCount(3, $player->goals);      
    }

    /** @test */
    public function it_can_have_multiple_goals_on_different_games()
    {
        $goal01 = new App\Models\Goal();
        $goal02 = new App\Models\Goal();
        $goal03 = new App\Models\Goal();
        $match01 = factory(App\Models\Match::class)->create();
        $match02 = factory(App\Models\Match::class)->create();
        $player = factory(App\Models\Player::class)->create();

        $goal01->addPlayer($player);
        $goal02->addPlayer($player);
        $goal03->addPlayer($player);

        $match01->addGoal($goal01);
        $match02->addGoal($goal02);
        $match02->addGoal($goal03);

        $this->assertCount(3, $player->goals);      
    }

    /** @test */
    public function it_should_only_count_countable_goals()
    {
        $notCounableGoal = new App\Models\Goal();
        $notCounableGoal->own_goal = true;

        $goal02 = new App\Models\Goal();
        $goal03 = new App\Models\Goal();
        $match = factory(App\Models\Match::class)->create();
        $player = factory(App\Models\Player::class)->create();

        $notCounableGoal->addPlayer($player);
        $goal02->addPlayer($player);
        $goal03->addPlayer($player);

        $match->addGoal($notCounableGoal);
        $match->addGoal($goal02);
        $match->addGoal($goal03);

        $this->assertTrue($player->countableGoals == 2);
    }
}
