<?php

function create_real_matches_for_round(App\Models\BetConfiguration $configuration)
{
    $matches = factory(App\Models\Match::class,$configuration->number_of_bets)->create();

    $matches->each(function ($match, $key) use ($configuration) {
        $configuration->round->addMatch($match);
    });
}

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

function create_real_championship_configurations($championship_id)
{
    $configurations = [];

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\MatchBet', 
            'order' => 1, 
            'number_of_bets' => 36,
            'points_per_guess' => 1,
            'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','GroupStageTest')->firstOrFail()->id,
    ]);

    create_real_matches_for_round($configurations[0]);

     $configurations[] = factory(App\Models\BetConfiguration::class)->create([
             'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 2, 
            'number_of_bets' => 16,
            'points_per_guess' => 2,
            'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','RoundOf16Test')->firstOrFail()->id,
    ]);

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 3, 
            'number_of_bets' => 8,
            'points_per_guess' => 3,
            'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','QuarterFinalsTest')->firstOrFail()->id,
    ]);

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 4, 
            'number_of_bets' => 4,
            'points_per_guess' => 4,
            'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','SemiFinalsTest')->firstOrFail()->id,
    ]);

    $configurations[] = factory(App\Models\BetConfiguration::class)->create([
            'bet_mapping_class' => 'App\Models\RoundBet', 
            'order' => 5, 
            'number_of_bets' => 2,
            'points_per_guess' => 4,
            'round_id' => App\Models\Round::where('championship_id','=',$championship_id)
                    ->where('identifier','=','FinalTest')->firstOrFail()->id,
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

    $configurations = create_real_championship_configurations($championship->id);
    foreach ($configurations as $configuration) {
        $championship->addConfiguration($configuration);
    }

    return $championship;
}

function create_playerbet_with_points($number_of_goals)
{
       $playerBet = new App\Models\PlayerBet();

        $match = factory(App\Models\Match::class)->create();
        $player = factory(App\Models\Player::class)->create();


        for ($i=0; $i < $number_of_goals; $i++) { 
            $goal = new App\Models\Goal();
            $goal->addPlayer($player);
            $goal->addPlayer($player);
            $match->addGoal($goal);
        }

        $playerBet->associatePlayer($player);

        return $playerBet;
}

function create_matchbet_with_points()
{
       $matchBet = new App\Models\MatchBet();
       $matchBet->setPrediction('1');
       
        $match = factory(App\Models\Match::class)->create(['local_score'=>2,'away_score'=>0]);

        $matchBet->associateMatch($match);

        return $matchBet;
}

function create_coupon($championship = null)
{
    if ( is_null($championship) )
    {
        $championship = factory(Championship::class)->create();           
    }
    
    $user = factory(App\Models\User::class)->create();
    $coupon = new App\Models\Coupon();
    $coupon->associateUser($user);
    $championship->addCoupon($coupon);
    $coupon->save();

    return $coupon;
}