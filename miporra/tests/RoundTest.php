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

    /** @test */
    public function it_can_set_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $round->setPoints(20);

        $this->assertEquals(20, $round->points);
    }

    /** @test */
    public function it_throws_an_exction_if_string_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $this->setExpectedException('\App\Exceptions\InvalidPointsException');

        $round->setPoints('aa');
    }

    /** @test */
    public function it_throws_an_exction_if_string_integer_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $this->setExpectedException('\App\Exceptions\InvalidPointsException');

        $round->setPoints('-2');
    }

    /** @test */
    public function it_throws_an_exction_if_negative_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $this->setExpectedException('\App\Exceptions\InvalidPointsException');

        $round->setPoints(-1);
    }

    /** @test */
    public function it_check_if_team_added_is_on_it()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);  
        $round->assignToChampionship($championship);  

        $round->addTeam($team);

        $this->assertTrue($round->hasTeam($team));
    }

    /** @test */
    public function it_check_if_team_added_is_on_it_when_more_than_one_team_added()
    {
        $teams = factory(App\Models\Team::class,2)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $teams[0]->addToChampionship($championship);  
        $teams[1]->addToChampionship($championship);  
        $round->assignToChampionship($championship);  

        $round->addTeam($teams[0]);
        $round->addTeam($teams[1]);

        $this->assertTrue($round->hasTeam($teams[1]));
    }

    /** @test */
    public function it_check_if_team_added_is_on_it_when_not_all_the_teams_added()
    {
        $teamsIncluded = factory(App\Models\Team::class,2)->create();    
        $teamNotIncluded = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $teamsIncluded[0]->addToChampionship($championship);  
        $teamsIncluded[1]->addToChampionship($championship);  
        $teamNotIncluded->addToChampionship($championship);  
        $round->assignToChampionship($championship);  

        $round->addTeam($teamsIncluded[0]);
        $round->addTeam($teamsIncluded[1]);

        $this->assertTrue($round->hasTeam($teamsIncluded[0]));
        $this->assertTrue($round->hasTeam($teamsIncluded[1]));

        $this->assertFalse($round->hasTeam($teamNotIncluded));
    }

    /** @test */
    public function it_return_false_if_no_team_added()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);  
        $round->assignToChampionship($championship);  

        $this->assertFalse($round->hasTeam($team));
    }
}
