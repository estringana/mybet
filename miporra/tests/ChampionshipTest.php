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
        $coupon = new App\Models\Coupon();

        $coupon->associateUser($user);

        $championship->addCoupon($coupon);
        
        $this->assertEquals($championship->coupons()->firstOrFail()->user->id, $user->id);
    }

    /** @test */
    public function it_return_same_added_users()
    {
        $users = factory(App\Models\User::class, 2)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $coupon01 = new App\Models\Coupon();
        $coupon02 = new App\Models\Coupon();

        $coupon01->associateUser($users[0]);
        $coupon02->associateUser($users[1]);

        $championship->addCoupon($coupon01);
        $championship->addCoupon($coupon02);
        
        $this->assertEquals(
            $championship->coupons->lists(['user_id'])->toArray(), 
            [
                $users[0]->id,
                $users[1]->id
            ]
        );

        $this->assertCount(2,$championship->coupons);
    }

    /** @test */
    public function it_can_not_be_the_same_users_twice_on_a_championship()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $coupon01 = new App\Models\Coupon();
        $coupon02 = new App\Models\Coupon();

        $coupon01->associateUser($user);
        $coupon02->associateUser($user);

        $championship->addCoupon($coupon01);        

        $this->setExpectedException('\App\Exceptions\UserTwiceOnChampionshipException');

        $championship->addCoupon($coupon02);
    }

    /** @test */
    public function it_can_add_configuration()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $betConfiguration = new App\Models\BetConfiguration();

        $championship->addConfiguration($betConfiguration);

        $this->assertEquals(
            $championship->configurations->lists(['id'])->toArray(),
            [$betConfiguration->id]
        );
    }

    /** @test */
    public function it_can_add_configurations()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $betConfigurations = factory(App\Models\BetConfiguration::class,4)->create();

        $championship->addConfiguration($betConfigurations[0]);
        $championship->addConfiguration($betConfigurations[1]);
        $championship->addConfiguration($betConfigurations[2]);
        $championship->addConfiguration($betConfigurations[3]);

        $this->assertEquals(
            $championship->configurations->lists(['id'])->toArray(),
            $betConfigurations->lists(['id'])->toArray()
        );
    }

    /** @test */
    public function it_will_tell_me_the_points_of_a_spefic_round()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $betConfigurations = factory(App\Models\BetConfiguration::class,3)->create();
        $betConfigurationsForCheck = factory(App\Models\BetConfiguration::class)->create();

        $championship->addConfiguration($betConfigurations[0]);
        $championship->addConfiguration($betConfigurations[1]);
        $championship->addConfiguration($betConfigurations[2]);
        $championship->addConfiguration($betConfigurationsForCheck);

        $this->assertEquals(
            $championship->pointsForMappingIdentifiedBy(
                    $betConfigurationsForCheck->bet_mapping_class,
                    $betConfigurationsForCheck->identifier_of_bet                    
                ),
            $betConfigurationsForCheck->points_per_guess
        );
    }


    /** @test */
    public function it_will_tell_me_the_bets_of_a_spefic_round()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $betConfigurations = factory(App\Models\BetConfiguration::class,3)->create();
        $betConfigurationsForCheck = factory(App\Models\BetConfiguration::class)->create();

        $championship->addConfiguration($betConfigurations[0]);
        $championship->addConfiguration($betConfigurations[1]);
        $championship->addConfiguration($betConfigurations[2]);
        $championship->addConfiguration($betConfigurationsForCheck);

        $this->assertEquals(
            $championship->betsAllowedForMappingIdentifiedBy(
                    $betConfigurationsForCheck->bet_mapping_class,
                    $betConfigurationsForCheck->identifier_of_bet                    
                ),
            $betConfigurationsForCheck->number_of_bets
        );
    }
}
