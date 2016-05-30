<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChampionshipTest extends TestCase
{
    use DatabaseTransactions;



    /**
* @test
* @group backend
*/
    public function it_is_not_in_progress_if_it_is_before_start_date()
    {
	$championship = factory(App\Models\Championship::class,'notStarted')->create();

	$this->assertFalse($championship->inProgress());    	
    }

    /**
* @test
* @group backend
*/
    public function it_is_in_progress_if_it_is_after_start_date_but_before_end_date()
    {
    	$championship = factory(App\Models\Championship::class,'inProgress')->create();

	$this->assertTrue($championship->inProgress());    		
    }

    /**
* @test
* @group backend
*/
    public function it_is_not_in_progress_if_it_is_after_end_date()
    {
        $championship = factory(App\Models\Championship::class,'ended')->create();

        $this->assertFalse($championship->inProgress());    	
    }

    /**
* @test
* @group backend
*/
    public function it_return_same_subscribed_team()
    {
        $team = factory(App\Models\Team::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   

        $championship->subscribeTeam($team);
        
        $this->assertEquals($championship->teams->toArray(), [$team->toArray()]);
    }

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
    public function it_return_same_added_round()
    {
        $round = factory(App\Models\Round::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   

        $championship->addRound($round);
        
        $this->assertEquals($championship->rounds->toArray(), [$round->toArray()]);
    }

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
    public function it_return_same_added_user()
    {
        $user = factory(App\Models\User::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   
        $coupon = new App\Models\Coupon();

        $coupon->associateUser($user);

        $championship->addCoupon($coupon);
        
        $this->assertEquals($championship->coupons()->firstOrFail()->user->id, $user->id);
    }

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
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

    /**
* @test
* @group backend
*/
    public function it_return_all_the_player_who_belong_to_the_subscribed_teams()
    {
        $team_a = factory(App\Models\Team::class)->create();    
        $team_b = factory(App\Models\Team::class)->create();    
        $player_a = factory(App\Models\Player::class)->create();    
        $player_b = factory(App\Models\Player::class)->create();    
        $championship = factory(App\Models\Championship::class)->create();   

        $team_a->addPlayer($player_a);
        $team_b->addPlayer($player_b);

        $championship->subscribeTeam($team_a);
        $championship->subscribeTeam($team_b);        

        $this->assertCount(2,$championship->players);
    }

    /**
* @test
* @group backend
*/
    public function it_should_return_the_points_of_the_type()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $betConfigurations = factory(App\Models\BetConfiguration::class,4)->create();

        $championship->addConfiguration($betConfigurations[0]);
        $championship->addConfiguration($betConfigurations[1]);
        $championship->addConfiguration($betConfigurations[2]);
        $championship->addConfiguration($betConfigurations[3]);

        $mapping_class = $betConfigurations[0]->bet_mapping_class;

        $this->assertEquals(
                $championship->getPointsOfTypeIdentifyBy($mapping_class),
                $betConfigurations[0]->points_per_guess
        );        
    }

    /**
* @test
* @group backend
*/
    public function it_should_return_the_points_of_the_type_identifies_by()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $round = new App\Models\Round();
        $round->save();

        $championship->addRound($round);

        $betConfigurations = factory(App\Models\BetConfiguration::class,4)->create();

        $betConfigurations[2]->round_id = $round->id;

        $championship->addConfiguration($betConfigurations[0]);
        $championship->addConfiguration($betConfigurations[1]);
        $championship->addConfiguration($betConfigurations[2]);
        $championship->addConfiguration($betConfigurations[3]);

        $mapping_class = $betConfigurations[2]->bet_mapping_class;
        $identification = $betConfigurations[2]->round_id;

        $this->assertEquals(
                $championship->getPointsOfTypeIdentifyBy($mapping_class, $identification),
                $betConfigurations[2]->points_per_guess
        );        
    }

     /**
* @test
* @group backend
*/
    public function it_should_throw_an_exception_if_no_configuration_when_asking_for_points()
    {
        $championship = factory(App\Models\Championship::class)->create();           

        $this->setExpectedException('\App\Exceptions\NoConfigurationOnChampionshipException');

        $championship->getPointsOfTypeIdentifyBy('whatever');
    }

    /**
* @test
* @group backend
*/
    public function it_should_return_the_matches_on_the_championship()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $round = new App\Models\Round();
        $round->save();
        $championship->addRound($round);
        $match_on_championship_01 = factory(App\Models\Match::class)->create();
        $match_on_championship_02 = factory(App\Models\Match::class)->create();
        $match_not_on_championship = factory(App\Models\Match::class)->create();

        $round->addMatch($match_on_championship_01);
        $round->addMatch($match_on_championship_02);

        $this->assertEquals(
            $championship->matches->lists(['id'])->toArray(),
            [$match_on_championship_01->id, $match_on_championship_02->id]
        );
    }

    /**
* @test
* @group backend
*/
    public function it_should_return_the_matches_on_the_championship_by_date()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $round01 = new App\Models\Round();
        $round01->save();
        $championship->addRound($round01);
        $match_01_on_championship = factory(App\Models\Match::class)->create(['date' => '2016-06-11']);
        $match_02_on_championship = factory(App\Models\Match::class)->create(['date' => '2016-06-10']);
        $match_not_in_championship = factory(App\Models\Match::class)->create(['date' => '2016-06-10']);

        $round01->addMatch($match_01_on_championship);
        $round01->addMatch($match_02_on_championship);

        $this->assertEquals(
            $championship->matchesOrderedByDate()->lists(['id'])->toArray(),
            [$match_02_on_championship->id, $match_01_on_championship->id]
        );
    }


    /**
* @test
* @group backend
*/
    public function it_should_return_the_matches_on_the_championship_by_date_and_grouped_by_round()
    {
        $championship = factory(App\Models\Championship::class)->create();   
        $round01 = new App\Models\Round();
        $round01->name = 'round 01';
        $round01->identifier = 'round01';
        $round01->save();
        $round02 = new App\Models\Round();
        $round02->name = 'round 02';
        $round02->identifier = 'round02';
        $round02->save();
        $championship->addRound($round01);
        $championship->addRound($round02);
        $match_01_on_round_01 = factory(App\Models\Match::class)->create(['date' => '2016-06-11']);
        $match_02_on_round_01 = factory(App\Models\Match::class)->create(['date' => '2016-06-10']);
        $match_01_on_round_02 = factory(App\Models\Match::class)->create(['date' => '2016-06-15']);
        $match_02_on_round_02 = factory(App\Models\Match::class)->create(['date' => '2016-06-16']);

        $round01->addMatch($match_01_on_round_01);
        $round01->addMatch($match_02_on_round_01);
        $round02->addMatch($match_01_on_round_02);
        $round02->addMatch($match_02_on_round_02);

        $round01->save();
        $round02->save();

        $this->assertEquals(
            $championship->matchesByRoundOrderedByDate()->keys()->toArray(),
            [$round01->name, $round02->name]
        );
    }

    /**
* @test
* @group backend
*/
    public function it_return_false_if_date_is_later_than_end_inscription()
    {
        $championship = factory(App\Models\Championship::class)->create(['end_inscription' => '2016-05-20']);

        $this->assertFalse($championship->isInscriptionOpen());
    }

    /**
* @test
* @group backend
*/
    public function it_return_true_if_date_is_later_than_end_inscription()
    {
        $faker = Faker\Factory::create();

        $championship = factory(App\Models\Championship::class)->create();

        $championship->end_inscription = $faker->dateTimeBetween('+10 day', '+1 month');

        $this->assertTrue($championship->isInscriptionOpen());
    }

    /**
* @test
* @group backend
*/
    public function it_return_false_if_has_not_started()
    {
        $faker = Faker\Factory::create();
        $championship = factory(App\Models\Championship::class)->create();

        $championship->start_date = $faker->dateTimeBetween('+10 day', '+1 month');

        $this->assertFalse($championship->hasStarted());
    }

    /**
* @test
* @group backend
*/
    public function it_return_true_if_has_started()
    {
        $faker = Faker\Factory::create();

        $championship = factory(App\Models\Championship::class)->create();

        $championship->start_date = $faker->dateTimeBetween('-10 day', '-1 day');

        $this->assertTrue($championship->hasStarted());
    }
}
