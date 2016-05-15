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
}
