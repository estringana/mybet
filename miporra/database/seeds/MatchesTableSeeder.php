<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $championship_id = App\Models\Championship::where('code','=','euro2016')->firstOrFail()->id;
        $round_id = App\Models\Round::where('order','=',1)
            ->where('championship_id','=',$championship_id)
            ->firstOrFail()
            ->id;

        DB::table('matches')->insert([
            'date' => '2016-06-10',
            'championship_id' => $championship_id,
            'local_score' => null,
            'away_score' => null,
            'local_team_id' => 7,
            'away_team_id' => 16,
            'round_id' => $round_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('matches')->insert([
            'date' => '2016-06-11',
            'championship_id' => $championship_id,
            'local_score' => null,
            'away_score' => null,
            'local_team_id' => 1,
            'away_team_id' => 21,
            'round_id' => $round_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('matches')->insert([
            'date' => '2016-06-15',
            'championship_id' => $championship_id,
            'local_score' => null,
            'away_score' => null,
            'local_team_id' => 16,
            'away_team_id' => 21,
            'round_id' => $round_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('matches')->insert([
            'date' => '2016-06-15',
            'championship_id' => $championship_id,
            'local_score' => null,
            'away_score' => null,
            'local_team_id' => 7,
            'away_team_id' => 1,
            'round_id' => $round_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('matches')->insert([
            'date' => '2016-06-19',
            'championship_id' => $championship_id,
            'local_score' => null,
            'away_score' => null,
            'local_team_id' => 21,
            'away_team_id' => 7,
            'round_id' => $round_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('matches')->insert([
            'date' => '2016-06-19',
            'championship_id' => $championship_id,
            'local_score' => null,
            'away_score' => null,
            'local_team_id' => 16,
            'away_team_id' => 1,
            'round_id' => $round_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
