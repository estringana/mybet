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
        $championship_id = App\Models\Championship::where('code','=','worldcup2018')->firstOrFail()->id;
        $round_id = App\Models\Round::where('order','=',1)
            ->where('championship_id','=',$championship_id)
            ->firstOrFail()
            ->id;

        $matches = [];

        $matches[] = [
          'id' => 1,
          'local_team_id' => 1,
          'away_team_id' => 2,
          'date' => '2018-06-14',
        ]; 
        $matches[] = [
          'id' => 2,
          'local_team_id' => 3,
          'away_team_id' => 4,
          'date' => '2018-06-15',
        ]; 
        $matches[] = [
          'id' => 17,
          'local_team_id' => 1,
          'away_team_id' => 3,
          'date' => '2018-06-19',
        ]; 
        $matches[] = [
          'id' => 18,
          'local_team_id' => 4,
          'away_team_id' => 2,
          'date' => '2018-06-20',
        ]; 
        $matches[] = [
          'id' => 33,
          'local_team_id' => 4,
          'away_team_id' => 1,
          'date' => '2018-06-25',
        ]; 
        $matches[] = [
          'id' => 34,
          'local_team_id' => 2,
          'away_team_id' => 3,
          'date' => '2018-06-25',
        ]; 
        $matches[] = [
          'id' => 3,
          'local_team_id' => 5,
          'away_team_id' => 6,
          'date' => '2018-06-15',
        ]; 
        $matches[] = [
          'id' => 4,
          'local_team_id' => 7,
          'away_team_id' => 8,
          'date' => '2018-06-15',
        ]; 
        $matches[] = [
          'id' => 19,
          'local_team_id' => 5,
          'away_team_id' => 7,
          'date' => '2018-06-20',
        ]; 
        $matches[] = [
          'id' => 20,
          'local_team_id' => 8,
          'away_team_id' => 6,
          'date' => '2018-06-20',
        ]; 
        $matches[] = [
          'id' => 35,
          'local_team_id' => 8,
          'away_team_id' => 5,
          'date' => '2018-06-25',
        ]; 
        $matches[] = [
          'id' => 36,
          'local_team_id' => 6,
          'away_team_id' => 7,
          'date' => '2018-06-25',
        ]; 
        $matches[] = [
          'id' => 5,
          'local_team_id' => 9,
          'away_team_id' => 10,
          'date' => '2018-06-16',
        ]; 
        $matches[] = [
          'id' => 6,
          'local_team_id' => 11,
          'away_team_id' => 12,
          'date' => '2018-06-16',
        ]; 
        $matches[] = [
          'id' => 21,
          'local_team_id' => 9,
          'away_team_id' => 11,
          'date' => '2018-06-21',
        ]; 
        $matches[] = [
          'id' => 22,
          'local_team_id' => 12,
          'away_team_id' => 10,
          'date' => '2018-06-21',
        ]; 
        $matches[] = [
          'id' => 37,
          'local_team_id' => 12,
          'away_team_id' => 9,
          'date' => '2018-06-26',
        ]; 
        $matches[] = [
          'id' => 38,
          'local_team_id' => 10,
          'away_team_id' => 11,
          'date' => '2018-06-26',
        ]; 
        $matches[] = [
          'id' => 7,
          'local_team_id' => 13,
          'away_team_id' => 14,
          'date' => '2018-06-16',
        ]; 
        $matches[] = [
          'id' => 8,
          'local_team_id' => 15,
          'away_team_id' => 16,
          'date' => '2018-06-16',
        ]; 
        $matches[] = [
          'id' => 23,
          'local_team_id' => 13,
          'away_team_id' => 15,
          'date' => '2018-06-21',
        ]; 
        $matches[] = [
          'id' => 24,
          'local_team_id' => 16,
          'away_team_id' => 14,
          'date' => '2018-06-22',
        ]; 
        $matches[] = [
          'id' => 39,
          'local_team_id' => 16,
          'away_team_id' => 13,
          'date' => '2018-06-26',
        ]; 
        $matches[] = [
          'id' => 40,
          'local_team_id' => 14,
          'away_team_id' => 15,
          'date' => '2018-06-26',
        ]; 
        $matches[] = [
          'id' => 9,
          'local_team_id' => 17,
          'away_team_id' => 18,
          'date' => '2018-06-17',
        ]; 
        $matches[] = [
          'id' => 10,
          'local_team_id' => 19,
          'away_team_id' => 20,
          'date' => '2018-06-17',
        ]; 
        $matches[] = [
          'id' => 25,
          'local_team_id' => 17,
          'away_team_id' => 19,
          'date' => '2018-06-22',
        ]; 
        $matches[] = [
          'id' => 26,
          'local_team_id' => 20,
          'away_team_id' => 18,
          'date' => '2018-06-22',
        ]; 
        $matches[] = [
          'id' => 41,
          'local_team_id' => 20,
          'away_team_id' => 17,
          'date' => '2018-06-27',
        ]; 
        $matches[] = [
          'id' => 42,
          'local_team_id' => 18,
          'away_team_id' => 19,
          'date' => '2018-06-27',
        ]; 
        $matches[] = [
          'id' => 11,
          'local_team_id' => 21,
          'away_team_id' => 22,
          'date' => '2018-06-17',
        ]; 
        $matches[] = [
          'id' => 12,
          'local_team_id' => 23,
          'away_team_id' => 24,
          'date' => '2018-06-18',
        ]; 
        $matches[] = [
          'id' => 27,
          'local_team_id' => 21,
          'away_team_id' => 23,
          'date' => '2018-06-23',
        ]; 
        $matches[] = [
          'id' => 28,
          'local_team_id' => 24,
          'away_team_id' => 22,
          'date' => '2018-06-23',
        ]; 
        $matches[] = [
          'id' => 43,
          'local_team_id' => 24,
          'away_team_id' => 21,
          'date' => '2018-06-27',
        ]; 
        $matches[] = [
          'id' => 44,
          'local_team_id' => 22,
          'away_team_id' => 23,
          'date' => '2018-06-27',
        ]; 
        $matches[] = [
          'id' => 13,
          'local_team_id' => 25,
          'away_team_id' => 26,
          'date' => '2018-06-18',
        ]; 
        $matches[] = [
          'id' => 14,
          'local_team_id' => 27,
          'away_team_id' => 28,
          'date' => '2018-06-18',
        ]; 
        $matches[] = [
          'id' => 29,
          'local_team_id' => 25,
          'away_team_id' => 27,
          'date' => '2018-06-23',
        ]; 
        $matches[] = [
          'id' => 30,
          'local_team_id' => 28,
          'away_team_id' => 26,
          'date' => '2018-06-24',
        ]; 
        $matches[] = [
          'id' => 45,
          'local_team_id' => 28,
          'away_team_id' => 25,
          'date' => '2018-06-28',
        ]; 
        $matches[] = [
          'id' => 46,
          'local_team_id' => 26,
          'away_team_id' => 27,
          'date' => '2018-06-28',
        ]; 
        $matches[] = [
          'id' => 15,
          'local_team_id' => 29,
          'away_team_id' => 30,
          'date' => '2018-06-19',
        ]; 
        $matches[] = [
          'id' => 16,
          'local_team_id' => 31,
          'away_team_id' => 32,
          'date' => '2018-06-19',
        ]; 
        $matches[] = [
          'id' => 31,
          'local_team_id' => 29,
          'away_team_id' => 31,
          'date' => '2018-06-24',
        ]; 
        $matches[] = [
          'id' => 32,
          'local_team_id' => 32,
          'away_team_id' => 30,
          'date' => '2018-06-24',
        ]; 
        $matches[] = [
          'id' => 47,
          'local_team_id' => 32,
          'away_team_id' => 29,
          'date' => '2018-06-28',
        ]; 
        $matches[] = [
          'id' => 48,
          'local_team_id' => 30,
          'away_team_id' => 31,
          'date' => '2018-06-28',
        ]; 

        foreach ($matches as $match) {
            DB::table('matches')->insert([
                'id' => $match['id'],
                'date' => $match['date'],
                'championship_id' => $championship_id,
                'local_team_id' => $match['local_team_id'],
                'away_team_id' => $match['away_team_id'],
                'local_score' => null,
                'away_score' => null,
                'round_id' => $round_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }            
    }
}
