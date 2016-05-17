<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
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
    public function it_has_a_championship()
    {
        $team = factory(App\Models\Team::class)->make();
        $championship = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);

        $this->assertTrue($team->championship->code == $championship->code);        
    }

    /** @test */
    public function team_has_championship()
    {
        $team = factory(App\Models\Team::class)->make();
        $championship = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);

        $this->assertTrue($team->hasChampionship());        
    }

    /** @test */
    public function it_return_same_players_added()
    {
        $team = factory(App\Models\Team::class)->create();    
        $player = factory(App\Models\Player::class)->create();   

        $team->addPlayer($player);
        
        $this->assertEquals($team->players->toArray(), [$player->toArray()]);
    }

    /** @test */
    public function it_return_same_subscribed_teams()
    {
        $players = factory(App\Models\Player::class, 2)->create();    
        $team = factory(App\Models\Team::class)->create();   

        $team->addPlayer($players[0]);
        $team->addPlayer($players[1]);
        
        $this->assertEquals(
            $team->players->toArray(), 
            [
                $players[0]->toArray(),
                $players[1]->toArray()
            ]
        );

        $this->assertCount(2,$team->players);
    }
}
