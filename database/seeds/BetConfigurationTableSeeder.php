<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BetConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $championship_id = App\Models\Championship::where('code','=','euro2016')->firstOrFail()->id;

        $bet_configurations = [
            [ 
                'bet_mapping_class' => 'App\Models\MatchBet', 
                'order' => 1, 
                'number_of_bets' => 36,
                'points_per_guess' => 1,
                'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','GroupStage')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 2, 
                'number_of_bets' => 16,
                'points_per_guess' => 2,
                'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','RoundOf16')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 3, 
                'number_of_bets' => 8,
                'points_per_guess' => 3,
                'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','QuarterFinals')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 4, 
                'number_of_bets' => 4,
                'points_per_guess' => 4,
                'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','SemiFinals')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 5, 
                'number_of_bets' => 2,
                'points_per_guess' => 5,
                'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','Final')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 6, 
                'number_of_bets' => 1,
                'points_per_guess' => 2,
                'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','Champion')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 7, 
                'number_of_bets' => 1,
                'points_per_guess' => 3,
                'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','Runnersup')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\PlayerBet', 
                'order' => 6, 
                'number_of_bets' => 8,
                'points_per_guess' => 1,
                'round_id' => null,
                'championship_id' => $championship_id
            ]
        ];

        foreach ($bet_configurations as $configuration) {

            DB::table('bet_configurations')->insert([
                'bet_mapping_class' => $configuration['bet_mapping_class'], 
                'order' => $configuration['order'], 
                'number_of_bets' => $configuration['number_of_bets'], 
                'points_per_guess' => $configuration['points_per_guess'], 
                'championship_id' => $configuration['championship_id'], 
                'round_id' => $configuration['round_id'], 
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
