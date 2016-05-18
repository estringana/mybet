<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoundBetTest extends TestCase
{
    use DatabaseTransactions;
    
    protected $team;
    protected $round;
    protected $roundBet;
    protected $championship;


    protected function setUp()
    {
        parent::setUp();

        $this->roundBet = new App\Models\RoundBet();
        $this->round = factory(App\Models\Round::class)->create();
        $this->team = factory(App\Models\Team::class)->make();

        $this->championship = factory(App\Models\Championship::class)->create();

        $this->round->assignToChampionship($this->championship);
        $this->championship->subscribeTeam($this->team);

        $this->roundBet->associateRound($this->round);
        $this->roundBet->associateTeam($this->team);
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
    public function it_can_associate_a_round()
    {
        $this->assertTrue($this->roundBet->round->id == $this->round->id);   
    }

    /** @test */
    public function it_can_associate_a_team()
    {
        $this->assertTrue($this->roundBet->team->id == $this->team->id);   
    }

    /** @test */
    public function it_return_3_points_if_the_round_is_set_to_3_points_and_the_team_is_on_it()
    {
        $this->round->setPoints(3);
        $this->round->addTeam($this->team);

        $this->assertEquals($this->round->points,$this->roundBet->points);
    }

    /** @test */
    public function it_return_0_points_if_the_team_is_not_on_it()
    {
        $this->assertEquals(0,$this->roundBet->points);
    }
}
