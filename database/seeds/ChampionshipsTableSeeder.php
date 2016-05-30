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
	'start_date' => '2016-06-10 19:00',
            'end_date' => '2016-08-10',
            'end_inscription' => '2016-06-09 17:00',
	'active' => true,
	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
