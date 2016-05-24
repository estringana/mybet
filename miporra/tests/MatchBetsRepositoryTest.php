<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\MatchBetsRepository;
use App\Models\Coupon;

class MatchBetsRepositoryTest extends TestCase
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
    
    protected function setUp()
    {
        parent::setUp();

        $this->championship = factory(App\Models\Championship::class)->create();
        $this->user = factory(App\Models\User::class)->create();
        $this->coupon = new App\Models\Coupon();
        $this->coupon->associateUser($this->user);
        $this->championship->addCoupon($this->coupon);
        $this->coupon->save();

        $this->bet_with_player_subtype = new App\Models\Bet();        
        $this->player_on_player_bet = factory(App\Models\Player::class)->create();
        $this->playerBet_on_bet = new App\Models\PlayerBet();
        $this->playerBet_on_bet->associatePlayer($this->player_on_player_bet);
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

        $this->repository = new App\Repositories\MatchBetsRepository($this->coupon);
    }

    /** @test */
    public function it_should_set_the_prediction_given_an_id()
    {
        $loaded_bet = App\Models\MatchBet::find($this->matchBet_on_bet->id);

        $this->assertTrue($loaded_bet->isEmpty());

        $this->repository->save($this->matchBet_on_bet->id, 'X');

        $loaded_bet = App\Models\MatchBet::find($this->matchBet_on_bet->id);

        $this->assertFalse($loaded_bet->isEmpty());
    }

    /** @test */
    public function it_should_only_return_matchbets_when_asking_for_bets()
    {
        $bet = new App\Models\Bet();        
        $matchbet = new App\Models\MatchBet();
        $matchbet->save();
        $bet->addBettype($matchbet);
        $this->coupon->addBet($bet);
        $bet->save();

        
        $bets = $this->repository->bets();

        $this->assertEquals(2, $this->repository->bets()->count());
        
        $this->assertEquals(
            $bets->lists(['id'])->toArray(),
            [
                $this->matchBet_on_bet->id,
                $matchbet->id
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
        $matchbet = new App\Models\MatchBet();
        $matchbet->save();
        $bet->addBettype($matchbet);
        $coupon->addBet($bet);
        $bet->save();

        $this->setExpectedException('\App\Exceptions\BetNotFoundException');

        $this->repository->save($matchbet->id, 'X');
    }

    /** @test */
    public function it_should_thrown_an_exception_when_saving_an_id_which_dont_exists_at_all()
    {
        $this->setExpectedException('\App\Exceptions\BetNotFoundException');

        $this->repository->save(1234567, 'X');
    }
}
