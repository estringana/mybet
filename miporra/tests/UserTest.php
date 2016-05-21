<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    
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
    public function it_should_not_have_a_coupon_if_new_user()
    {
        $user = factory(\App\Models\User::class)->create();

        $this->assertEquals(0, $user->coupons()->count());
    }

    /** @test */
    public function it_should_create_a_coupon()    
    {
        $championship = factory(\App\Models\Championship::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $user->couponOfChampionsip($championship);

        $this->assertEquals(1, $user->coupons()->count());
    }
}
