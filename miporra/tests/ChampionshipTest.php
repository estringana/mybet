<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChampionshipTest extends TestCase
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
    public function it_is_not_in_progress_if_it_is_before_start_date()
    {
	$championship = factory(App\Models\Championship::class,'notStarted')->create();

	$this->assertFalse($championship->inProgress());    	
    }

    /** @test */
    public function it_is_in_progress_if_it_is_after_start_date_but_before_end_date()
    {
    	$championship = factory(App\Models\Championship::class,'inProgress')->create();

	$this->assertTrue($championship->inProgress());    		
    }

    /** @test */
       public function it_is_not_in_progress_if_it_is_after_end_date()
       {
       	$championship = factory(App\Models\Championship::class,'ended')->create();

	$this->assertFalse($championship->inProgress());    	
       }   
}
