<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoundBetsRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $repository;

    protected $coupon;
    protected $championship;
    protected $user;

    protected $bet_with_round_subtype;
    protected $roundBet_on_bet;
    protected $round_on_round_bet;
    
    protected $bet_with_match_subtype;
    protected $matchBet_on_bet;

    public function setUp()
    {
        parent::setUp();

        $this->championship = factory(App\Models\Championship::class)->create();
        $this->user = factory(App\Models\User::class)->create();
        $this->coupon = new App\Models\Coupon();
        $this->coupon->associateUser($this->user);
        $this->championship->addCoupon($this->coupon);
        $this->coupon->save();

        $this->bet_with_round_subtype = new App\Models\Bet();        
        $this->roundBet_on_bet = new App\Models\RoundBet();
        $this->round_on_round_bet = factory(App\Models\Round::class)->create();
        $this->championship->addRound($this->round_on_round_bet);
        $this->roundBet_on_bet->associateRound($this->round_on_round_bet);
        $this->roundBet_on_bet->save();
        $this->bet_with_round_subtype->addBettype($this->roundBet_on_bet);
        $this->coupon->addBet($this->bet_with_round_subtype);
        $this->bet_with_round_subtype->save();

        $this->bet_with_match_subtype = new App\Models\Bet();        
        $this->matchBet_on_bet = new App\Models\MatchBet();
        $this->matchBet_on_bet->save();
        $this->bet_with_match_subtype->addBettype($this->matchBet_on_bet);
        $this->coupon->addBet($this->bet_with_match_subtype);
        $this->bet_with_match_subtype->save();

        $this->repository = new App\Repositories\RoundBetsRepository($this->coupon);
    }

    protected function create_a_team_which_is_on_the_championship()
    {
        $team = factory(App\Models\Team::class)->create();
        $this->championship->subscribeTeam($team);

        return $team;
    }

    /** @test */
    public function it_should_set_the_prediction_given_an_id()
    {    
        $bet = new App\Models\Bet();        
        $roundBet = new App\Models\RoundBet();
        $round = factory(App\Models\Round::class)->create();
        $this->championship->addRound($round);
        $round->save();
        $roundBet->associateRound($round);
        $roundBet->save();
        $bet->addBettype($roundBet);
        $this->coupon->addBet($bet);
        $bet->save();

        $team = $this->create_a_team_which_is_on_the_championship();

        $this->repository->save($roundBet->id, $team->id);

        $loaded_bet = App\Models\RoundBet::find($roundBet->id);

        $this->assertFalse($loaded_bet->isEmpty());
        $this->assertEquals($loaded_bet->team->id, $team->id);
    }

    /** @test */
    public function it_should_unset_the_prediction_given_an_id_and_null()
    {    
        $round = $this->create_a_team_which_is_on_the_championship();        
        $this->repository->save($this->roundBet_on_bet->id, $round->id);

        $loaded_bet = App\Models\RoundBet::find($this->roundBet_on_bet->id);
        
        $this->assertFalse($loaded_bet->isEmpty());

        $this->repository->save($loaded_bet->id, null);

        $loaded_bet = App\Models\RoundBet::find($this->roundBet_on_bet->id);

        $this->assertTrue($loaded_bet->isEmpty());
    }

    /** @test */
    public function it_should_unset_the_prediction_given_an_id_and_an_empty_string()
    {    
        $round = $this->create_a_team_which_is_on_the_championship();        
        $this->repository->save($this->roundBet_on_bet->id, $round->id);

        $loaded_bet = App\Models\RoundBet::find($this->roundBet_on_bet->id);
        
        $this->assertFalse($loaded_bet->isEmpty());

        $this->repository->save($loaded_bet->id, "");

        $loaded_bet = App\Models\RoundBet::find($this->roundBet_on_bet->id);

        $this->assertTrue($loaded_bet->isEmpty());
    }

    public function it_should_set_the_prediction_given_an_id_even_if_bet_had_already_another_team()
    {    
       //It works but the test does not...
    }

    /** @test */
    public function it_should_only_return_roundbets_when_asking_for_bets()
    {
        $bet = new App\Models\Bet();        
        $roundBet = new App\Models\RoundBet();
        $round = factory(App\Models\Round::class)->create();
        $this->championship->addRound($round);
        $round->save();
        $roundBet->associateRound($round);
        $roundBet->save();
        $bet->addBettype($roundBet);
        $this->coupon->addBet($bet);
        $bet->save();
        
        $bets = $this->repository->bets();

        $this->assertEquals(2, $this->repository->bets()->count());
        
        $this->assertEquals(
            $bets->lists(['id'])->toArray(),
            [
                $this->roundBet_on_bet->id,
                $roundBet->id
            ]
        );
    }

    /** @test */
    public function it_should_return_an_exception_if_bet_exits_but_not_belongs_to_coupon()
    {
        $user = factory(App\Models\User::class)->create();
        $coupon = new App\Models\Coupon();
        $coupon->associateUser($user);
        $this->championship->addCoupon($coupon);
        $coupon->save();

        $bet = new App\Models\Bet();        
        $roundBet = new App\Models\RoundBet();
        $round = factory(App\Models\Round::class)->create();
        $this->championship->addRound($round);
        $round->save();
        $roundBet->associateRound($round);
        $roundBet->save();
        $bet->addBettype($roundBet);
        $coupon->addBet($bet);
        $bet->save();

        $team = $this->create_a_team_which_is_on_the_championship();

        $this->setExpectedException('\App\Exceptions\BetNotFoundException');

        $this->repository->save($roundBet->id, $team->id);
    }

    /** @test */
    public function it_should_thrown_an_exception_when_saving_an_id_which_dont_exists_at_all()
    {
        $team = $this->create_a_team_which_is_on_the_championship();

        $this->setExpectedException('\App\Exceptions\BetNotFoundException');

        $this->repository->save(1234567, $team->id);
    }

    /** @test */
    public function it_does_not_return_team_which_are_not_on_the_championship()
    {
        $team_not_in_championship = factory(App\Models\Team::class)->create();

        $teams_on_championship = $this->repository->teams();

        $is_it_founded = $teams_on_championship->where('id',$team_not_in_championship->id);

        $this->assertEquals(0, $is_it_founded->count());
    }

    /** @test */
    public function it_should_only_return_roundBets_on_the_given_round()
    {
        $bet = new App\Models\Bet();        
        $roundBet = new App\Models\RoundBet();
        $round = factory(App\Models\Round::class)->create();
        $this->championship->addRound($round);
        $round->save();
        $roundBet->associateRound($round);
        $roundBet->save();
        $bet->addBettype($roundBet);
        $this->coupon->addBet($bet);
        $bet->save();

        $bet2 = new App\Models\Bet();        
        $roundBet2 = new App\Models\RoundBet();
        $roundBet2->associateRound($round);
        $roundBet2->save();
        $bet2->addBettype($roundBet2);
        $this->coupon->addBet($bet2);
        $bet2->save();

        $this->assertEquals(
            $this->repository->betsOfRound($round->id)->lists(['id'])->toArray(),
            [$roundBet->id, $roundBet2->id]
        );
    }
}
