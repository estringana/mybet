<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BetConfigurationTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
* @test
* @group backend
*/
    public function it_can_have_a_round()
    {
        $round = factory(App\Models\Round::class)->create();
        $betConfiguration = factory(App\Models\BetConfiguration::class)->create();

        $betConfiguration->associateRound($round);

        $this->assertEquals($round->id, $betConfiguration->round->id);      
    }
}
