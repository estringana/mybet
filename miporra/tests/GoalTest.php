<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalTest extends TestCase
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
        $goal = new App\Models\Goal();
        $player = factory(App\Models\Player::class)->create();

        $goal->addPlayer($player);

        $this->assertTrue($goal->player->id == $player->id);
    }

    /** @test */
    public function it_should_count_by_default()
    {
        $goal = new App\Models\Goal();

        $this->assertTrue($goal->shouldCount());
    }

    /** @test */
    public function it_should_not_count_if_own_goal()
    {
        $goal = new App\Models\Goal();
        $goal->own_goal = true;

        $this->assertFalse($goal->shouldCount());
    }

    /** @test */
    public function it_should_not_count_if_penalty_round()
    {
        $goal = new App\Models\Goal();
        $goal->penalty_round = true;

        $this->assertFalse($goal->shouldCount());
    }

    /** @test */
    public function it_should_count_if_penalty()
    {
        $goal = new App\Models\Goal();
        $goal->penalty = true;

        $this->assertTrue($goal->shouldCount());
    }
}
