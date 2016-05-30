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

        $matches = [];

        $matches[] = [
            'date' => '2016-06-10',
            'local_team_id' => 'France',
            'away_team_id' => 'Romania',
        ];

        $matches[] = [
            'date' => '2016-06-11',
            'local_team_id' => 'Albania',
            'away_team_id' => 'Switzerland',
        ];
        $matches[] = [
            'date' => '2016-06-11',
            'local_team_id' => 'Wales',
            'away_team_id' => 'Slovakia',
        ];
        $matches[] = [
            'date' => '2016-06-11',
            'local_team_id' => 'England',
            'away_team_id' => 'Russia',
        ];

        $matches[] = [
            'date' => '2016-06-12',
            'local_team_id' => 'Turkey',
            'away_team_id' => 'Croatia',
        ];
        $matches[] = [
            'date' => '2016-06-12',
            'local_team_id' => 'Poland',
            'away_team_id' => 'NorthernIreland',
        ];
        $matches[] = [
            'date' => '2016-06-12',
            'local_team_id' => 'Germany',
            'away_team_id' => 'Ukraine',
        ];

        $matches[] = [
            'date' => '2016-06-13',
            'local_team_id' => 'Spain',
            'away_team_id' => 'CzechRepublic',
        ];
        $matches[] = [
            'date' => '2016-06-13',
            'local_team_id' => 'RepublicOfIreland',
            'away_team_id' => 'Sweden',
        ];
        $matches[] = [
            'date' => '2016-06-13',
            'local_team_id' => 'Belgium',
            'away_team_id' => 'Italy',
        ];

        $matches[] = [
            'date' => '2016-06-14',
            'local_team_id' => 'Austria',
            'away_team_id' => 'Hungary',
        ];
        $matches[] = [
            'date' => '2016-06-14',
            'local_team_id' => 'Portugal',
            'away_team_id' => 'Iceland',
        ];

        $matches[] = [
            'date' => '2016-06-15',
            'local_team_id' => 'Russia',
            'away_team_id' => 'Slovakia',
        ];
        $matches[] = [
            'date' => '2016-06-15',
            'local_team_id' => 'Romania',
            'away_team_id' => 'Switzerland',
        ];
        $matches[] = [
            'date' => '2016-06-15',
            'local_team_id' => 'France',
            'away_team_id' => 'Albania',
        ];

        $matches[] = [
            'date' => '2016-06-16',
            'local_team_id' => 'England',
            'away_team_id' => 'Wales',
        ];
        $matches[] = [
            'date' => '2016-06-16',
            'local_team_id' => 'Ukraine',
            'away_team_id' => 'NorthernIreland',
        ];
        $matches[] = [
            'date' => '2016-06-16',
            'local_team_id' => 'Germany',
            'away_team_id' => 'Poland',
        ];

         $matches[] = [
            'date' => '2016-06-17',
            'local_team_id' => 'Italy',
            'away_team_id' => 'Sweden',
        ];
        $matches[] = [
            'date' => '2016-06-17',
            'local_team_id' => 'CzechRepublic',
            'away_team_id' => 'Croatia',
        ];
        $matches[] = [
            'date' => '2016-06-17',
            'local_team_id' => 'Spain',
            'away_team_id' => 'Turkey',
        ];

        $matches[] = [
            'date' => '2016-06-18',
            'local_team_id' => 'Belgium',
            'away_team_id' => 'RepublicOfIreland',
        ];
        $matches[] = [
            'date' => '2016-06-18',
            'local_team_id' => 'Iceland',
            'away_team_id' => 'Hungary',
        ];
        $matches[] = [
            'date' => '2016-06-18',
            'local_team_id' => 'Portugal',
            'away_team_id' => 'Austria',
        ];

        $matches[] = [
            'date' => '2016-06-19',
            'local_team_id' => 'Romania',
            'away_team_id' => 'Albania',
        ];
        $matches[] = [
            'date' => '2016-06-19',
            'local_team_id' => 'Switzerland',
            'away_team_id' => 'France',
        ];

        $matches[] = [
            'date' => '2016-06-20',
            'local_team_id' => 'Russia',
            'away_team_id' => 'Wales',
        ];
        $matches[] = [
            'date' => '2016-06-20',
            'local_team_id' => 'Slovakia',
            'away_team_id' => 'England',
        ];

        $matches[] = [
            'date' => '2016-06-21',
            'local_team_id' => 'Ukraine',
            'away_team_id' => 'Poland',
        ];
        $matches[] = [
            'date' => '2016-06-21',
            'local_team_id' => 'NorthernIreland',
            'away_team_id' => 'Germany',
        ];
        $matches[] = [
            'date' => '2016-06-21',
            'local_team_id' => 'Croatia',
            'away_team_id' => 'Spain',
        ];
        $matches[] = [
            'date' => '2016-06-21',
            'local_team_id' => 'CzechRepublic',
            'away_team_id' => 'Turkey',
        ];

        $matches[] = [
            'date' => '2016-06-22',
            'local_team_id' => 'Hungary',
            'away_team_id' => 'Portugal',
        ];        
        $matches[] = [
            'date' => '2016-06-22',
            'local_team_id' => 'Iceland',
            'away_team_id' => 'Austria',
        ];        
        $matches[] = [
            'date' => '2016-06-22',
            'local_team_id' => 'Italy',
            'away_team_id' => 'RepublicOfIreland',
        ];        
        $matches[] = [
            'date' => '2016-06-22',
            'local_team_id' => 'Sweden',
            'away_team_id' => 'Belgium',
        ];        


        foreach ($matches as $match) {
            $local_id = \App\Models\Team::where('code','=',$match['local_team_id'])->FirstOrFail()->id;
            $away_id = \App\Models\Team::where('code','=',$match['away_team_id'])->FirstOrFail()->id;
            DB::table('matches')->insert([
                'date' => $match['date'],
                'championship_id' => $championship_id,
                'local_team_id' => $local_id,
                'away_team_id' => $away_id,
                'local_score' => null,
                'away_score' => null,
                'round_id' => $round_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }            
    }
}
