<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProposedScoresRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $repository;
    protected $championship;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->championship = create_real_championship();
        $this->user = factory(App\Models\User::class)->create();

        $this->repository = new App\Repositories\ProposedScoresRepository($this->user, $this->championship);
    }        

   /**
* @test
* @group backend
*/
   public function it_should_throw_exception_if_match_does_not_exist_in_championship()
   {
        $match = factory('App\Models\Match')->create();

        $this->setExpectedException('\App\Exceptions\MatchNotFoundException');

        $this->repository->save($match->id,1,2);
   }

   /**
* @test
* @group backend
*/
   public function it_should_throw_an_exception_if_match_does_not_exists_at_all()
   {
        $this->setExpectedException('\App\Exceptions\MatchNotFoundException');

        $this->repository->save(12341234,1,2);
   }

   /**
* @test
* @group backend
*/
   public function it_should_create_a_proposition()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();
       
       $this->assertEquals(0, $match->propositions->count());

       $playerFromMatch01 = $match->local->players->random();
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);

       $this->repository->save($match->id, 1, 2);

       $match = $this->championship->matches()->findOrFail($match->id);

       $proposition_founded = $match
          ->propositions
          ->where('user_id', $this->user->id)
          ->where('match_id', $match->id)
          ->where('local_score',1)
          ->where('away_score',2)
          ->count();

       $this->assertEquals(1, $proposition_founded);
   }

      /**
* @test
* @group backend
*/
   public function it_should_throw_an_exception_if_the_same_player_propose_0_0_score_twice()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $this->assertEquals(0, $match->propositions->count());

       $this->repository->save($match->id, 0, 0);

       $this->setExpectedException('\App\Exceptions\DuplicatePredictionException');

      $this->repository->save($match->id, 0, 0);
   }

   /**
* @test
* @group backend
*/
   public function it_should_throw_an_exception_if_the_same_player_propose_the_same_twice()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $this->assertEquals(0, $match->propositions->count());

       $playerFromMatch01 = $match->local->players->random();
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);

       $this->repository->save($match->id, 1, 2);

       $this->setExpectedException('\App\Exceptions\DuplicatePredictionException');

       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);

      $this->repository->save($match->id, 1, 2);       
   }

/**
* @test
* @group backend
*/
   public function it_should_not_throw_an_exception_if_the_same_player_propose_the_same_score_twice_but_with_different_players()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $this->assertEquals(0, $match->propositions->count());

       $playerFromMatch01 = $match->local->players()->first();
       $playerFromMatch02 = $match->local->players()->whereNotIn('id',[$playerFromMatch01->id])->first();

       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1);

       $this->repository->save($match->id, 1, 2);

       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1);

      $this->repository->save($match->id, 1, 2);       
   }

   /**
* @test
* @group backend
*/
   public function it_should_throw_an_exception_if_same_score_proposed_twice_mixed_with_same_score_different_players()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $this->assertEquals(0, $match->propositions->count());

       $playerFromMatch01 = $match->local->players()->first();
       $playerFromMatch02 = $match->local->players()->whereNotIn('id',[$playerFromMatch01->id])->first();

       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1);

       $this->repository->save($match->id, 1, 2);

       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1);

      $this->repository->save($match->id, 1, 2);      

       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1);

       $this->setExpectedException('\App\Exceptions\DuplicatePredictionException'); 

       $this->repository->save($match->id, 1, 2);
   }


   /**
* @test
* @group backend
*/
   public function it_should_not_set_the_score_when_user_is_not_admin()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $playerFromMatch01 = $match->local->players->random();
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);

       $this->assertEquals(0, $match->propositions->count());

       $match->addScore(0, 0);

       $this->repository->save($match->id, 1, 2);

       $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(0, $match->local_score);
       $this->assertEquals(0, $match->away_score);
   }

   /**
* @test
* @group backend
*/
   public function it_should_set_the_score_when_user_is_admin()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $playerFromMatch01 = $match->local->players->random();
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1);

       $this->user->is_admin = true;
       $this->user->save();

       $this->assertEquals(0, $match->propositions->count());

       $match->addScore(7, 6);

       $this->repository->save($match->id, 1, 2);

       $match = $this->championship->matches()->findOrFail($match->id);

       $this->assertEquals(1, $match->local_score);
       $this->assertEquals(2, $match->away_score);
       $this->assertEquals(3, $match->goals()->count());
   }

/**
* @test
* @group backend
*/
   public function it_should_throw_exception_if_match_does_not_exist_in_championship_when_adding_goals()
   {
        $match = factory('App\Models\Match')->create();

        $this->setExpectedException('\App\Exceptions\MatchNotFoundException');

        $this->repository->addGoal($match->id, 1, 1, 1, 1);
   }

   /**
* @test
* @group backend
*/
   public function it_should_throw_an_exception_if_match_does_not_exists_at_all_when_adding_goals()
   {
        $this->setExpectedException('\App\Exceptions\MatchNotFoundException');

        $this->repository->addGoal(123123123, 1, 1, 1, 1);
   }

   /**
    * @test
    * @group backend
    */
   public function it_should_throw_exception_if_player_not_found_on_match()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

        $this->setExpectedException('\App\Exceptions\PlayerNotFoundException');

        $this->repository->addGoal($match->id, 11234, 1, 1, 1);
   }

   /**
    * @test
    * @group backend
    */
   public function it_should_return_1_when_adding_the_first_goal_of_a_match()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $playerFromMatch = $match->local->players->random();

        $this->assertEquals('local', $this->repository->addGoal($match->id, $playerFromMatch->id, 1, 1, 1));
   }

   /**
    * @test
    * @group backend
    */
   public function it_should_return_2_when_adding_the_second_goal_of_a_match()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $playerFromMatch01 = $match->local->players->random();
       $playerFromMatch02 = $match->away->players->random();

        $this->assertEquals('local', $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 1, 1));
        $this->assertEquals('away', $this->repository->addGoal($match->id, $playerFromMatch02->id, 1, 1, 1));
   }   

/**
* @test
* @group backend
*/
   public function it_should_throw_an_exception_if_goals_on_match_dont_match_goals_passed()
   {
      $match = $this->championship->matches()->firstOrFail();
      
      $this->setExpectedException('\App\Exceptions\AmountOfGoalsDifferentFromMatchScoreException');

        $this->repository->save($match->id,1,2);
   }

   /**
    * @test
    * @group backend
    */
   public function it_show_create_score_if_admin()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $playerFromMatch01 = $match->local->players->random();
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 0, 1);

       $this->user->is_admin = true;
       $this->user->save();

       $this->repository->save($match->id, 1, 0);

       $match = $this->championship->matches()->findOrFail($match->id);

       $this->assertEquals(1, $match->local_score);
       $this->assertEquals(0, $match->away_score);
       $this->assertEquals(1, $match->goals->count());

       $realGoal = $match->goals->first();
       $this->assertEquals($playerFromMatch01->id , $realGoal->player_id);
       $this->assertEquals(1, $realGoal->penalty);
       $this->assertEquals(0, $realGoal->own_goal);
       $this->assertEquals(1, $realGoal->penalty_round);
   }

   /**
    * @test
    * @group backend
    */
   public function it_show_create_score_if_admin_more_than_one_goal()
   {
       $match = create_a_match_on_championship($this->championship);
       $match->save();

       $playerFromMatch01 = $match->local->players->random();
       $this->repository->addGoal($match->id, $playerFromMatch01->id, 1, 0, 1);
       $playerFromMatch02 = $match->local->players()->whereNotIn('id',[$playerFromMatch01->id])->first();
       $this->repository->addGoal($match->id, $playerFromMatch02->id, 0, 1, 0);

       $this->user->is_admin = true;
       $this->user->save();

       $this->repository->save($match->id, 2, 0);

       $match = $this->championship->matches()->findOrFail($match->id);

       $this->assertEquals(2, $match->local_score);
       $this->assertEquals(0, $match->away_score);
       $this->assertEquals(2, $match->goals->count());

       $realGoal01 = $match->goals->get(0); //First
       $this->assertEquals($playerFromMatch01->id , $realGoal01->player_id);
       $this->assertEquals(1, $realGoal01->penalty);
       $this->assertEquals(0, $realGoal01->own_goal);
       $this->assertEquals(1, $realGoal01->penalty_round);

       $realGoal02 = $match->goals->get(1); //Second
       $this->assertEquals($playerFromMatch02->id , $realGoal02->player_id);
       $this->assertEquals(0, $realGoal02->penalty);
       $this->assertEquals(1, $realGoal02->own_goal);
       $this->assertEquals(0, $realGoal02->penalty_round);
   }
}
