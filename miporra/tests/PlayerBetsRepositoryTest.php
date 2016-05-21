<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \App\Repositories\PlayerBetsRepository;

class PlayerBetsRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $coupon;

    public function setUp()
    {
        parent::setUp();

        $championship = create_real_championship();
        
        $user = factory(App\Models\User::class)->create();
        $this->coupon = new App\Models\Coupon();
        $this->coupon->associateUser($user);
        $championship->addCoupon($this->coupon);        

        $this->coupon->createEmtpyBets();
    }

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
    public function it_throws_an_exception_if_the_values_passed_dont_match_number_of_bets()
    {
        $players = [4, 2, 1];

       $repository = new PlayerBetsRepository($this->coupon);

       $this->setExpectedException('\App\Exceptions\NumberOfPlayetBetsDontMatchException');

       $repository->updatePlayersBetsFromValues($players);
    }

    /** @test */
    public function it_associate_the_player_bets_of_the_coupon_with_the_array_given()
    {
        $number_of_bets = $this->coupon->numberOfbetsOfType(PlayerBetsRepository::PLAYER_BETS_TYPE);

        $players = \App\Models\Player::all()->take($number_of_bets)->lists(['id'])->toArray();

       $repository = new PlayerBetsRepository($this->coupon);

       $repository->updatePlayersBetsFromValues($players);

       $id_on_bets = [];
       foreach ($this->coupon->betsOfType(PlayerBetsRepository::PLAYER_BETS_TYPE)->get() as $bet) 
       {
            $id_on_bets[] = $bet->bettype->player_id;
       }

       $this->assertEquals( sort($id_on_bets), sort($id_on_bets) );
    }
}
