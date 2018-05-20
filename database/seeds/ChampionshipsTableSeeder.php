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
            'name' => 'Worldcup 2018',
            'code' => 'worldcup2018',
	'start_date' => '2018-06-15 19:00',
            'end_date' => '2018-08-16',
            'end_inscription' => '2018-06-13 17:00',
	'active' => true,
	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
