<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MatchStatisticsRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $repository;

    protected $championship;

    public function setUp()
    {
        parent::setUp();

        $this->championship = factory(App\Models\Championship::class)->create();        

        $this->repository = new App\Repositories\MatchStatisticsRepository($this->championship);
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_say_100_if_only_one_coupon_and_it_has_the_prediction()
    {
        $coupon = create_coupon($this->championship);
        $bet = create_bet_of_matchbet_with_match_and_prediction($coupon, 1);

        $matchBet = $bet->bettype;

        $this->assertEquals(100, $this->repository->percentageWithPrediction($matchBet->match->id, 1));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_the_coupon_with_that_prediction()
    {
        $coupon = create_coupon($this->championship);
        $bet = create_bet_of_matchbet_with_match_and_prediction($coupon, 1);

        $matchBet = $bet->bettype;

        $this->assertEquals(
            [ $coupon->id ], 
            $this->repository->couponsWithMatchAndPrediction($matchBet->match->id, 1)->lists(['id'])->toArray()
        );
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_say_0_if_only_one_coupon_and_it_has_not_the_prediction()
    {
        $coupon = create_coupon($this->championship);
        $bet = create_bet_of_matchbet_with_match_and_prediction($coupon, 2);

        $matchBet = $bet->bettype;

        $this->assertEquals(0, $this->repository->percentageWithPrediction($matchBet->match->id, 1));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_0_coupons_if_only_one_coupon_and_it_has_not_the_prediction()
    {
        $coupon = create_coupon($this->championship);
        $bet = create_bet_of_matchbet_with_match_and_prediction($coupon, 2);

        $matchBet = $bet->bettype;

        $this->assertEquals(
            [],
            $this->repository->couponsWithMatchAndPrediction($matchBet->match->id, 1)->toArray()
        );
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_say_50_if_only_one_coupon_has_the_prediction()
    {
        $coupon = create_coupon($this->championship);
        $bet = create_bet_of_matchbet_with_match_and_prediction($coupon, 1);

        $match = $bet->bettype->match;

        $coupon2 = create_coupon($this->championship);
        $bet2 = create_bet_of_matchbet_with_match_and_prediction($coupon2, 2, $match);

        $this->assertEquals(50, $this->repository->percentageWithPrediction($match->id, 1));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_only_2_coupons_the_prediction()
    {
        $coupon_with_prediction = create_coupon($this->championship);
        $bet_with_prediction = create_bet_of_matchbet_with_match_and_prediction($coupon_with_prediction, 1);

        $match = $bet_with_prediction->bettype->match;

        $coupon_with_prediction_02 = create_coupon($this->championship);
        $bet_with_prediction_02 = create_bet_of_matchbet_with_match_and_prediction($coupon_with_prediction_02, 1,$match);

        $coupon2 = create_coupon($this->championship);
        $bet2 = create_bet_of_matchbet_with_match_and_prediction($coupon2, 2,$match);


        $this->assertEquals(
            [$coupon_with_prediction->id, $coupon_with_prediction_02->id],
            $this->repository->couponsWithMatchAndPrediction($match->id, 1)->lists(['id'])->toArray()
        );
    }

}
