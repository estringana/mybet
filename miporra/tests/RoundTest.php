<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoundTest extends TestCase
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
        $round = factory(App\Models\Round::class)->create();
        $championship = factory(App\Models\Championship::class)->create();

        $round->assignToChampionship($championship);

        $this->assertTrue($round->championship->code == $championship->code);        
    }

    /** @test */
    public function it_can_have_teams()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $round->assignToChampionship($championship);  
        $team->addToChampionship($championship);  

        $round->addTeam($team);
        
        $this->assertEquals($round->teams->first()->id, $team->id);
    }

     /** @test */
    public function it_can_not_add_teams_without_championship()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $round->assignToChampionship($championship);  

        $this->setExpectedException('\App\Exceptions\TeamHasNoChampionshipException');

        $round->addTeam($team);
    }

    /** @test */
    public function it_can_not_add_teams_if_round_doesnt_have_championship()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);  

        $this->setExpectedException('\App\Exceptions\RoundHasNoChampionshipException');

        $round->addTeam($team);
    }

    /** @test */
    public function it_can_not_add_teams_if_championship_dont_match()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();
        $championshipAlternative = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);  
        $round->assignToChampionship($championshipAlternative);  

        $this->setExpectedException('\App\Exceptions\ChampionshipDontMatchException');

        $round->addTeam($team);
    }
}
