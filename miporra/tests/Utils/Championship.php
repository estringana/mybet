<?php

function create_real_championship_rounds()
{
    $rounds = [];

    $rounds[] = factory(App\Models\Round::class)->create(
        ['order' => 1, 'name' => 'Group Stage', 'identifier' => 'GroupStageTest']
    );
    $rounds[] = factory(App\Models\Round::class)->create(
            ['order' => 2, 'name' => 'Round of 16', 'identifier' => 'RoundOf16Test']
    );
    $rounds[] = factory(App\Models\Round::class)->create(
            ['order' => 3, 'name' => 'Quarter-Finals', 'identifier' => 'QuarterFinalsTest']
    );
    $rounds[] = factory(App\Models\Round::class)->create(
            ['order' => 4, 'name' => 'Semi-Finals', 'identifier' => 'SemiFinalsTest']
    );
    $rounds[] = factory(App\Models\Round::class)->create(
            ['order' => 5, 'name' => 'Final', 'identifier' => 'FinalTest']
    );

    return $rounds;
}

function create_real_championship_configurations()
{
    $configurations = [];

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\MatchBet', 
            'order' => 1, 
            'number_of_bets' => 36,
            'points_per_guess' => 1
    ]);

     $configurations[] = factory(App\Models\BetConfiguration::class)->create([
             'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 2, 
            'number_of_bets' => 16,
            'points_per_guess' => 2,
            'identifier_of_bet' => App\Models\Round::where('identifier','=','RoundOf16Test')->firstOrFail()->id,
    ]);

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 3, 
            'number_of_bets' => 8,
            'points_per_guess' => 3,
            'identifier_of_bet' => App\Models\Round::where('identifier','=','QuarterFinalsTest')->firstOrFail()->id,
    ]);

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 4, 
            'number_of_bets' => 4,
            'points_per_guess' => 4,
            'identifier_of_bet' => App\Models\Round::where('identifier','=','SemiFinalsTest')->firstOrFail()->id,
    ]);

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 5, 
            'number_of_bets' => 2,
            'points_per_guess' => 4,
            'identifier_of_bet' => App\Models\Round::where('identifier','=','FinalTest')->firstOrFail()->id,
    ]);

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\PlayerBet', 
            'order' => 6, 
            'number_of_bets' => 8,
            'points_per_guess' => 1,            
    ]);

    return $configurations;
}

function create_real_championship()
{
    $championship = factory(App\Models\Championship::class)->create();

    $rounds = create_real_championship_rounds();
    foreach ($rounds as $round) {
        $championship->addRound($round);
    }

    $configurations = create_real_championship_configurations();
    foreach ($configurations as $configuration) {
        $championship->addConfiguration($configuration);
    }

    return $championship;

}