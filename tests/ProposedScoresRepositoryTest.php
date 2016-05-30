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
       $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(0, $match->propositions->count());

       $this->repository->save($match->id, 1, 2);

       $match = $this->championship->matches()->firstOrFail();

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
   public function it_should_throw_an_exception_if_the_same_player_propose_the_same_twice()
   {
       $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(0, $match->propositions->count());

       $this->repository->save($match->id, 1, 2);

       $this->setExpectedException('\App\Exceptions\DuplicatePredictionException');

      $this->repository->save($match->id, 1, 2);       
   }

   /**
* @test
* @group backend
*/
   public function it_should_not_set_the_score_when_user_is_not_admin()
   {
       $match = $this->championship->matches()->firstOrFail();

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
       $match = $this->championship->matches()->firstOrFail();

       $this->user->is_admin = true;
       $this->user->save();

       $this->assertEquals(0, $match->propositions->count());

       $match->addScore(7, 6);

       $this->repository->save($match->id, 1, 2);

       $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(1, $match->local_score);
       $this->assertEquals(2, $match->away_score);
   }

   /**
* @test
* @group backend
*/
   public function it_should_not_set_the_score_when_less_than_4_uses_predict()
   {
       $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(0, $match->propositions->count());

       $match->addScore(0, 0);

       $this->repository->save($match->id, 1, 2);

       //Second user
        $this->user = factory(App\Models\User::class)->create();

        $this->repository = new App\Repositories\ProposedScoresRepository($this->user, $this->championship);

        //Set same score
        $this->repository->save($match->id, 1, 2);

       $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(0, $match->local_score);
       $this->assertEquals(0, $match->away_score);
   }

   /**
* @test
* @group backend
*/
   public function it_should_set_the_score_when_4_uses_predict_the_same_and_delete_all()
   {
       $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(0, $match->propositions->count());

       $match->addScore(1, 1);

        $users = factory(App\Models\User::class,4)->create();
        foreach ($users as $user) {
            $this->repository = new App\Repositories\ProposedScoresRepository($user, $this->championship);
            $this->repository->save($match->id, 5, 6);
        }

      $match = $this->championship->matches()->firstOrFail();

       $this->assertEquals(5, $match->local_score);
       $this->assertEquals(6, $match->away_score);
       $this->assertEquals(0, $match->propositions->count());
   }   
}
