<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChampionshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('championships')->insert([
            'name' => 'UEFA Euro 2016',
            'code' => 'euro2016',
	'start_date' => '2016-06-10',
	'end_date' => '2016-07-10',
	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
