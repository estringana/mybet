<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamStatisticsRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    
    protected $repository;

    protected $championship;

    public function setUp()
    {
        parent::setUp();

        $this->championship = factory(App\Models\Championship::class)->create();        

        $this->repository = new App\Repositories\TeamStatisticsRepository($this->championship);
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_say_100_if_there_is_only_a_coupon_and_it_has_the_team_a_round()
    {
        $coupon = create_coupon($this->championship);
        $bet = create_bet_of_roundbet_with_round_and_team_on_coupon($coupon);

        $team = $bet->bettype->team;
        $round = $bet->bettype->round;

        $this->assertEquals(100, $this->repository->percentageOfTeamOnRound($team->id, $round->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_0_if_the_team_havent_been_added_to_any_bet()
    {
        $coupon = create_coupon($this->championship);
        $round = create_a_round_on_the_championship($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);

        $this->assertEquals(0, $this->repository->percentageOfTeamOnRound($team->id, $round->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_0_if_the_team_havent_been_added_to_any_bet_on_that_round()
    {
        $coupon = create_coupon($this->championship);
        $round = create_a_round_on_the_championship($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);

        $bet = create_bet_of_roundbet_with_round_and_team_on_coupon($coupon, $team);

        $this->assertEquals(0, $this->repository->percentageOfTeamOnRound($team->id, $round->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_100_if_the_team_have_been_added_to_a_bet_on_that_round_and_there_another_round()
    {
        $coupon = create_coupon($this->championship);
        $round = create_a_round_on_the_championship($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);

        $bet = create_bet_of_roundbet_with_round_and_team_on_coupon($coupon, $team);

        $this->assertEquals(100, $this->repository->percentageOfTeamOnRound($team->id, $bet->bettype->round->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_100_if_a_coupon_has_two_teams()
    {
        $coupon = create_coupon($this->championship);
        $round = create_a_round_on_the_championship($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);

        $bet = create_bet_of_roundbet_with_round_and_team_on_coupon($coupon, $team, $round);

        $this->assertEquals(100, $this->repository->percentageOfTeamOnRound($team->id, $bet->bettype->round->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_50_if_two_coupons_and_team_only_on_one()
    {
        $round = create_a_round_on_the_championship($this->championship);
        
        $coupon = create_coupon($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);
        $bet = create_bet_of_roundbet_with_round_and_team_on_coupon($coupon, $team, $round);

        $coupon02 = create_coupon($this->championship);
        $bet02 = create_bet_of_roundbet_with_round_and_team_on_coupon($coupon02);

        $this->assertEquals(50, $this->repository->percentageOfTeamOnRound($team->id, $round->id));
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_the_coupon_which_has_the_team()
    {
        $round = create_a_round_on_the_championship($this->championship);        
        $coupon = create_coupon($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);
        $bet = create_bet_of_roundbet_with_round_and_team_on_coupon($coupon, $team, $round);

        $this->assertEquals(
            $this->repository->couponsWithTeamOnRound($team->id, $round->id)->lists(['id'])->toArray(),
            [$coupon->id]
        );
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_return_the_two_coupons_with_the_team()
    {
        $coupon = create_coupon($this->championship);
        $coupon02 = create_coupon($this->championship);
        $round = create_a_round_on_the_championship($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);

        create_bet_of_roundbet_with_round_and_team_on_coupon($coupon, $team, $round);
        create_bet_of_roundbet_with_round_and_team_on_coupon($coupon02, $team, $round);

       $this->assertEquals(
            $this->repository->couponsWithTeamOnRound($team->id, $round->id)->lists(['id'])->toArray(),
            [$coupon->id, $coupon02->id]
        );
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_only_return_the_coupon_which_has_the_team()
    {
        $coupon = create_coupon($this->championship);
        $coupon02 = create_coupon($this->championship);
        $round = create_a_round_on_the_championship($this->championship);
        $team = create_a_team_on_round_of_championship($round, $this->championship);

        create_bet_of_roundbet_with_round_and_team_on_coupon($coupon, $team, $round);
        create_bet_of_roundbet_with_round_and_team_on_coupon($coupon02, null, $round);

       $this->assertEquals(
            $this->repository->couponsWithTeamOnRound($team->id, $round->id)->lists(['id'])->toArray(),
            [$coupon->id]
        );
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_throw_an_exception_if_team_does_not_exist()
    {
        $this->setExpectedException('\App\Exceptions\TeamNotFoundException');

        $this->repository->getTeam(12341234);
    }

    /**
     * @test
     * @group backend
     */
    public function it_should_throw_an_exception_if_round_does_not_exist()
    {
        $this->setExpectedException('\App\Exceptions\RoundNotFoundException');
        
        $this->repository->getRound(12341234);
    }
}
