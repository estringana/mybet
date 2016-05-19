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
                'identifier_of_bet' => \App\Interfaces\Identifiable::NO_IDENTIFICATION,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 2, 
                'number_of_bets' => 16,
                'points_per_guess' => 2,
                'identifier_of_bet' => App\Models\Round::where('identifier','=','RoundOf16')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 3, 
                'number_of_bets' => 8,
                'points_per_guess' => 3,
                'identifier_of_bet' => App\Models\Round::where('identifier','=','QuarterFinals')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 4, 
                'number_of_bets' => 4,
                'points_per_guess' => 4,
                'identifier_of_bet' => App\Models\Round::where('identifier','=','SemiFinals')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\RoundBet', 
                'order' => 5, 
                'number_of_bets' => 2,
                'points_per_guess' => 4,
                'identifier_of_bet' => App\Models\Round::where('identifier','=','Final')->firstOrFail()->id,
                'championship_id' => $championship_id
            ],
            [ 
                'bet_mapping_class' => 'App\Models\PlayerBet', 
                'order' => 6, 
                'number_of_bets' => 8,
                'points_per_guess' => 1,
                'identifier_of_bet' => \App\Interfaces\Identifiable::NO_IDENTIFICATION,
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
                'identifier_of_bet' => $configuration['identifier_of_bet'], 
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
