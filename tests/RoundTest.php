<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoundTest extends TestCase
{
    use DatabaseTransactions;



     /**
* @test
* @group backend
*/
    public function it_has_a_championship()
    {
        $round = factory(App\Models\Round::class)->create();
        $championship = factory(App\Models\Championship::class)->create();

        $round->assignToChampionship($championship);

        $this->assertTrue($round->championship->code == $championship->code);        
    }

    /**
* @test
* @group backend
*/
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

     /**
* @test
* @group backend
*/
    public function it_can_not_add_teams_without_championship()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $round->assignToChampionship($championship);  

        $this->setExpectedException('\App\Exceptions\TeamHasNoChampionshipException');

        $round->addTeam($team);
    }

    /**
* @test
* @group backend
*/
    public function it_can_not_add_teams_if_round_doesnt_have_championship()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);  

        $this->setExpectedException('\App\Exceptions\RoundHasNoChampionshipException');

        $round->addTeam($team);
    }

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
    public function it_can_set_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $round->setPoints(20);

        $this->assertEquals(20, $round->points);
    }

    /**
* @test
* @group backend
*/
    public function it_throws_an_exction_if_string_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $this->setExpectedException('\App\Exceptions\InvalidPointsException');

        $round->setPoints('aa');
    }

    /**
* @test
* @group backend
*/
    public function it_throws_an_exction_if_string_integer_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $this->setExpectedException('\App\Exceptions\InvalidPointsException');

        $round->setPoints('-2');
    }

    /**
* @test
* @group backend
*/
    public function it_throws_an_exction_if_negative_points()
    {
        $round = factory(App\Models\Round::class)->create(); 

        $this->setExpectedException('\App\Exceptions\InvalidPointsException');

        $round->setPoints(-1);
    }

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
    public function it_return_false_if_no_team_added()
    {
        $team = factory(App\Models\Team::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 
        $championship = factory(App\Models\Championship::class)->create();

        $team->addToChampionship($championship);  
        $round->assignToChampionship($championship);  

        $this->assertFalse($round->hasTeam($team));
    }

    /**
* @test
* @group backend
*/
    public function it_can_have_a_match()
    {
        $match = factory(App\Models\Match::class)->create();    
        $round = factory(App\Models\Round::class)->create(); 

        $round->addMatch($match);
        
        $this->assertEquals($round->matches->first()->id, $match->id);
    }

    /**
* @test
* @group backend
*/
    public function it_can_have_matches()
    {
        $matches = factory(App\Models\Match::class,2)->create();    
        $round = factory(App\Models\Round::class)->create(); 

        $round->addMatch($matches[0]);
        $round->addMatch($matches[1]);
        
        $this->assertEquals($round->matches->lists(['id']), $matches->lists(['id']));
    }

    /**
     * @test
     * @group backend
     */
    public function it_only_return_is_not_beable_if_has_no_configuration()
    {
        $round = factory(App\Models\Round::class)->create(); 
        $this->assertFalse($round->betable());
    }

    /**
     * @test
     * @group backend
     */
    public function it_return_false_to_betable_if_has_configuration_but_not_from_rounds()
    {
        $round = factory(App\Models\Round::class)->create(); 
        $configuration = factory(App\Models\BetConfiguration::class)->create(); 

        $configuration->associateRound($round);
        $configuration->save();
        
        $this->assertFalse($round->betable());
    }

    /**
     * @test
     * @group backend
     */
    public function it_return_true_to_betable_if_has_configuration_and_is_a_round_one()
    {
        $round = factory(App\Models\Round::class)->create(); 
        $configuration = factory(App\Models\BetConfiguration::class)->create(['bet_mapping_class' => 'App\Models\RoundBet']); 
        $configuration->associateRound($round);
        $configuration->save();
        
        $this->assertTrue($round->betable());
    }
}
