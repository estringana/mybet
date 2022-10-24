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
            'name' => 'Eurocup 2020',
            'code' => 'eurocup2020',
    'start_date' => '2021-06-11 21:00',
            'end_date' => '2021-07-11',
            'end_inscription' => '2021-06-05 17:00',
    'active' => true,
    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
