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
            ['order' => 1, 'name' => 'Group Stage', 'identifier' => 'GroupStage'],
            ['order' => 2, 'name' => 'Round of 16', 'identifier' => 'RoundOf16'],
            ['order' => 3, 'name' => 'Quarter-Finals', 'identifier' => 'QuarterFinals'],
            ['order' => 4, 'name' => 'Semi-Finals', 'identifier' => 'SemiFinals'],
            ['order' => 5, 'name' => 'Final', 'identifier' => 'Final'],
            ['order' => 6, 'name' => 'Champion', 'identifier' => 'Champion'],
            ['order' => 7, 'name' => 'Runners-up', 'identifier' => 'Runnersup']
        ];

        foreach ($rounds as $round) {
            DB::table('rounds')->insert([
                'name' => $round['name'],
                'order' => $round['order'],
                'identifier' => $round['identifier'],
                'points' => $round['order'],
                'championship_id' => 
                    App\Models\Championship::where('code', '=', 'worldcup2018')
                    ->firstOrFail()
                        ->id,
               'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
               'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
