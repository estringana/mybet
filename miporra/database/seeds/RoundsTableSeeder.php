<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rounds = [
            ['order' => 1, 'name' => 'Group Stage'],
            ['order' => 2, 'name' => 'Round of 16'],
            ['order' => 3, 'name' => 'Quarter-Finals'],
            ['order' => 4, 'name' => 'Semi-Finals'],
            ['order' => 5, 'name' => 'Final']
        ];

        foreach ($rounds as $round) {
            DB::table('rounds')->insert([
                'name' => $round['name'],
                'order' => $round['order'],
                'points' => $round['order'],
                'championship_id' => 
                    App\Models\Championship::where('code', '=', 'euro2016')
                    ->firstOrFail()
                    ->id,
           'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ]);
        }
    }
}
