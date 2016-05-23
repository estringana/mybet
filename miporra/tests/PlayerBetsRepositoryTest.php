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
}
