<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlayerStatisticsRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    
    protected $repository;

    protected $championship;

    public function setUp()
    {
        parent::setUp();

        $this->championship = factory(App\Models\Championship::class)->create();        

        $this->repository = new App\Repositories\PlayerStatisticsRepository($this->championship);
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_say_100_if_there_is_only_a_coupon_and_it_has_the_player()
    {
        $coupon = create_coupon($this->championship);
        $bet = create_bet_of_playerbet_with_player_on_coupon($coupon);
        $player = $bet->bettype->player;
        $coupon->addBet($bet);

        $this->assertEquals(100, $this->repository->percentage($player->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_0_if_the_player_havent_bee_added_to_any_bet()
    {
        $coupon = create_coupon($this->championship);

        $player = create_a_player_on_a_team_which_is_on_the_championship($this->championship);

        $this->assertEquals(0, $this->repository->percentage($player->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_50_if_the_player_is_only_on_one_of_two_bets()
    {
        $coupon_with_player = create_coupon($this->championship);
        $bet = create_bet_of_playerbet_with_player_on_coupon($coupon_with_player);
        $player = $bet->bettype->player;
        $coupon_with_player->addBet($bet);

        $coupon_without_player = create_coupon($this->championship);

        $this->assertEquals(50, $this->repository->percentage($player->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_the_coupon_which_has_the_player()
    {
        $coupon_with_player = create_coupon($this->championship);
        $bet = create_bet_of_playerbet_with_player_on_coupon($coupon_with_player);
        $player = $bet->bettype->player;
        $coupon_with_player->addBet($bet);

        $playerbet = $bet->bettype;

        $this->assertEquals(
            $this->repository->couponsWithPlayer($player->id)->lists(['id'])->toArray(),
            [$coupon_with_player->id]
        );
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_the_coupons_which_has_the_player()
    {
        $coupon01 = create_coupon($this->championship);
        $bet01 = create_bet_of_playerbet_with_player_on_coupon($coupon01);
        $player = $bet01->bettype->player;
        $coupon01->addBet($bet01);

        $coupon02 = create_coupon($this->championship);
        $bet02 = create_bet_of_playerbet_with_player_on_coupon($coupon02, $player);
        $coupon02->addBet($bet02);

        $this->assertEquals(
            $this->repository->couponsWithPlayer($player->id)->lists(['id'])->toArray(),
            [$coupon01->id, $coupon02->id]
        );
    }

    /**
     * @test
     * @group backend
     */
    public function it_only_return_the_coupons_which_has_the_player()
    {
        $coupon01 = create_coupon($this->championship);
        $bet01 = create_bet_of_playerbet_with_player_on_coupon($coupon01);
        $player = $bet01->bettype->player;
        $coupon01->addBet($bet01);

        $coupon02 = create_coupon($this->championship);
        $bet02 = create_bet_of_playerbet_with_player_on_coupon($coupon02, $player);
        $coupon02->addBet($bet02);

        $coupon_without_player = create_coupon($this->championship);

        $this->assertEquals(
            $this->repository->couponsWithPlayer($player->id)->lists(['id'])->toArray(),
            [$coupon01->id, $coupon02->id]
        );
    }
}
