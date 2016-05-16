<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChampionshipTest extends TestCase
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
    public function it_is_not_in_progress_if_it_is_before_start_date()
    {
	$championship = factory(App\Models\Championship::class,'notStarted')->create();

	$this->assertFalse($championship->inProgress());    	
    }

    /** @test */
    public function it_is_in_progress_if_it_is_after_start_date_but_before_end_date()
    {
    	$championship = factory(App\Models\Championship::class,'inProgress')->create();

	$this->assertTrue($championship->inProgress());    		
    }

    /** @test */
    public function it_is_not_in_progress_if_it_is_after_end_date()
    {
        $championship = factory(App\Models\Championship::class,'ended')->create();

        $this->assertFalse($championship->inProgress());    	
    }

    /** @test */
    public function it_return_same_subscribed_team()
    {
        $team = factory(App\Models\Team::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   

        $championship->subscribeTeam($team);
        
        $this->assertEquals($championship->teams->toArray(), [$team->toArray()]);
    }

    /** @test */
    public function it_return_same_subscribed_teams()
    {
        $teams = factory(App\Models\Team::class, 2)->create();    
        $championship = factory(App\Models\Championship::class)->create();   

        $championship->subscribeTeam($teams[0]);
        $championship->subscribeTeam($teams[1]);
        
        $this->assertEquals(
            $championship->teams->toArray(), 
            [
                $teams[0]->toArray(),
                $teams[1]->toArray()
            ]
        );

        $this->assertCount(2,$championship->teams);
    }

    /** @test */
    public function it_return_same_added_round()
    {
        $round = factory(App\Models\Round::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   

        $championship->addRound($round);
        
        $this->assertEquals($championship->rounds->toArray(), [$round->toArray()]);
    }

    /** @test */
    public function it_return_same_added_rounds()
    {
        $rounds = factory(App\Models\Round::class, 2)->create();    
        $championship = factory(App\Models\Championship::class)->create();   

        $championship->addRound($rounds[0]);
        $championship->addRound($rounds[1]);
        
        $this->assertEquals(
            $championship->rounds->toArray(), 
            [
                $rounds[0]->toArray(),
                $rounds[1]->toArray()
            ]
        );

        $this->assertCount(2,$championship->rounds);
    }

    /** @test */
    public function it_return_same_added_user()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $bet = new App\Models\Bet();

        $bet->associateUser($user);

        $championship->addBet($bet);
        
        $this->assertEquals($championship->bets()->firstOrFail()->user->id, $user->id);
    }

    /** @test */
    public function it_return_same_added_users()
    {
        $users = factory(App\Models\User::class, 2)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $bet01 = new App\Models\Bet();
        $bet02 = new App\Models\Bet();

        $bet01->associateUser($users[0]);
        $bet02->associateUser($users[1]);

        $championship->addBet($bet01);
        $championship->addBet($bet02);
        
        $this->assertEquals(
            $championship->bets->lists(['user_id'])->toArray(), 
            [
                $users[0]->id,
                $users[1]->id
            ]
        );

        $this->assertCount(2,$championship->bets);
    }

    /** @test */
    public function it_can_not_be_the_same_users_twice_on_a_championship()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $bet01 = new App\Models\Bet();
        $bet02 = new App\Models\Bet();

        $bet01->associateUser($user);
        $bet02->associateUser($user);

        $championship->addBet($bet01);        

        $this->setExpectedException('\App\Exceptions\UserTwiceOnChampionshipException');

        $championship->addBet($bet02);
    }
}
