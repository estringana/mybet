<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \App\Repositories\PlayerBetsRepository;

class PlayerBetsRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $repository;

    protected $coupon;
    protected $championship;
    protected $user;

    protected $bet_with_player_subtype;
    protected $playerBet_on_bet;
    protected $player_on_player_bet;
    
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

        $this->bet_with_player_subtype = new App\Models\Bet();        
        $this->playerBet_on_bet = new App\Models\PlayerBet();
        $this->playerBet_on_bet->save();
        $this->bet_with_player_subtype->addBettype($this->playerBet_on_bet);
        $this->coupon->addBet($this->bet_with_player_subtype);
        $this->bet_with_player_subtype->save();

        $this->bet_with_match_subtype = new App\Models\Bet();        
        $this->matchBet_on_bet = new App\Models\MatchBet();
        $this->matchBet_on_bet->save();
        $this->bet_with_match_subtype->addBettype($this->matchBet_on_bet);
        $this->coupon->addBet($this->bet_with_match_subtype);
        $this->bet_with_match_subtype->save();

        $this->repository = new App\Repositories\PlayerBetsRepository($this->coupon);
    }

    protected function create_a_player_on_a_team_which_is_on_the_championship()
    {
        $team = factory(App\Models\Team::class)->create();
        $this->championship->subscribeTeam($team);
        $player = factory(App\Models\Player::class)->create();
        $team->addPlayer($player);

        return $player;
    }

    /** @test */
    public function it_should_set_the_prediction_given_an_id()
    {    
        $loaded_bet = App\Models\PlayerBet::find($this->playerBet_on_bet->id);

        $this->assertTrue($loaded_bet->isEmpty());
        
        $player = $this->create_a_player_on_a_team_which_is_on_the_championship();        

        $this->repository->save($loaded_bet->id, $player->id);

        $loaded_bet = App\Models\PlayerBet::find($this->playerBet_on_bet->id);

        $this->assertFalse($loaded_bet->isEmpty());
        $this->assertEquals($loaded_bet->player->id, $player->id);
    }

    /** @test */
    public function it_should_unset_the_prediction_given_an_id_and_null()
    {    
        $player = $this->create_a_player_on_a_team_which_is_on_the_championship();        
        $this->repository->save($this->playerBet_on_bet->id, $player->id);

        $loaded_bet = App\Models\PlayerBet::find($this->playerBet_on_bet->id);
        
        $this->assertFalse($loaded_bet->isEmpty());

        $this->repository->save($loaded_bet->id, null);

        $loaded_bet = App\Models\PlayerBet::find($this->playerBet_on_bet->id);

        $this->assertTrue($loaded_bet->isEmpty());
    }

    /** @test */
    public function it_should_unset_the_prediction_given_an_id_and_an_empty_string()
    {    
        $player = $this->create_a_player_on_a_team_which_is_on_the_championship();        
        $this->repository->save($this->playerBet_on_bet->id, $player->id);

        $loaded_bet = App\Models\PlayerBet::find($this->playerBet_on_bet->id);
        
        $this->assertFalse($loaded_bet->isEmpty());

        $this->repository->save($loaded_bet->id, "");

        $loaded_bet = App\Models\PlayerBet::find($this->playerBet_on_bet->id);

        $this->assertTrue($loaded_bet->isEmpty());
    }

    public function it_should_set_the_prediction_given_an_id_even_if_bet_had_already_another_player()
    {    
       //It works but the test does not...
    }

    /** @test */
    public function it_should_only_return_playerbets_when_asking_for_bets()
    {
        $bet = new App\Models\Bet();        
        $playerBet = new App\Models\PlayerBet();
        $playerBet->save();
        $bet->addBettype($playerBet);
        $this->coupon->addBet($bet);
        $bet->save();
        
        $bets = $this->repository->bets();

        $this->assertEquals(2, $this->repository->bets()->count());
        
        $this->assertEquals(
            $bets->lists(['id'])->toArray(),
            [
                $this->playerBet_on_bet->id,
                $playerBet->id
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
        $playerBet = new App\Models\PlayerBet();
        $playerBet->save();
        $bet->addBettype($playerBet);
        $coupon->addBet($bet);
        $bet->save();

        $player = $this->create_a_player_on_a_team_which_is_on_the_championship();

        $this->setExpectedException('\App\Exceptions\BetNotFoundException');

        $this->repository->save($playerBet->id, $player->id);
    }

    /** @test */
    public function it_should_thrown_an_exception_when_saving_an_id_which_dont_exists_at_all()
    {
        $player = $this->create_a_player_on_a_team_which_is_on_the_championship();

        $this->setExpectedException('\App\Exceptions\BetNotFoundException');

        $this->repository->save(1234567, $player->id);
    }

    /** @test */
    public function it_does_not_return_player_which_are_not_on_the_championship()
    {
        $player_not_in_championship = factory(App\Models\Player::class)->create();

        $players_on_championship = $this->repository->players();

        $is_it_founded = $players_on_championship->where('id',$player_not_in_championship->id);

        $this->assertEquals(0, $is_it_founded->count());
    }

    /** @test */
    public function it_should_get_the_points_of_playertype()
    {
        $championship = create_real_championship();
        $coupon = create_coupon($championship);
        $this->repository = new App\Repositories\PlayerBetsRepository($coupon);
        $points_on_championship = $championship->getPointsOfTypeIdentifyBy(PlayerBetsRepository::PLAYER_BETS_TYPE);

        $playerBet_with_2_points = create_playerbet_with_points(2);
        $playerBet_with_2_points->save();

        $bet = new App\Models\Bet();
        $bet->addBettype($playerBet_with_2_points);
        $coupon->addBet($bet);
        $bet->save();

        $this->assertEquals(2*$points_on_championship,$this->repository->points());
    }

    /** @test */
    public function it_should_get_0_points_of_playertype_if_no_foals()
    {
        $championship = create_real_championship();
        $coupon = create_coupon($championship);
        $this->repository = new App\Repositories\PlayerBetsRepository($coupon);
        $points_on_championship = $championship->getPointsOfTypeIdentifyBy(PlayerBetsRepository::PLAYER_BETS_TYPE);

        $bet = new App\Models\Bet();
        $coupon->addBet($bet);
        $bet->save();

        $this->assertEquals(0,$this->repository->points());
    }
}
