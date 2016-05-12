<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoundTest extends TestCase
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
    public function it_has_a_championship()
    {
        $round = factory(App\Models\Round::class)->create();
        $championship = factory(App\Models\Championship::class)->create();

        $round->assignToChampionship($championship);

        $this->assertTrue($round->championship->code == $championship->code);        
    }
}
