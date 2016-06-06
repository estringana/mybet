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

function create_a_player_on_a_team_which_is_on_the_championship(App\Models\Championship $championship)
{
    $team = factory(App\Models\Team::class)->create();
    $championship->subscribeTeam($team);
    $player = factory(App\Models\Player::class)->create();
    $team->addPlayer($player);

    return $player;
}

function create_a_team_which_is_on_the_championship(App\Models\Championship $championship)
{
    $round = create_a_round_on_the_championship($championship);
    $team = create_a_team_on_round_of_championship($round, $championship);

    return $team;
}

function create_a_round_on_the_championship(App\Models\Championship $championship)
{
    $round = factory(App\Models\Round::class)->create();
    $championship->addRound($round);
    $championship->save();

    return $round;
}

function create_players_on_team(App\Models\Team $team)
{
    $players = factory(App\Models\Player::class, 24)->create();

    foreach ($players as $player) {
        $team->addPlayer($player);
    }

    return $team;
}

function create_a_team_on_round_of_championship(App\Models\Round $round, App\Models\Championship $championship)
{
    $team = factory(App\Models\Team::class)->create();
    $team = create_players_on_team($team);
    $championship->subscribeTeam($team);
    $round->addTeam($team);
    $round->save();

    return $team;
}

function create_a_match_on_championship(App\Models\Championship $championship)
{
    $match = factory(App\Models\Match::class)->create();
    $round = create_a_round_on_the_championship($championship);
    $round->addMatch($match);
    $round->save();

    $localTeam = create_a_team_on_round_of_championship($round, $championship);
    $awayTeam = create_a_team_on_round_of_championship($round, $championship);

    $match->addTeams($localTeam, $awayTeam);

    return $match;
}

function create_bet_of_matchbet_with_match_and_prediction(App\Models\Coupon $coupon, $prediction, App\Models\Match $match = null)
{
    if (is_null($match))
    {
        $match = create_a_match_on_championship($coupon->championship);
    }

    $bet = new App\Models\Bet();                
    $matchBet = new App\Models\MatchBet();
    $matchBet->setPrediction($prediction);
    $matchBet->associateMatch($match);
    $matchBet->save();

    $bet->addBettype($matchBet);

    $coupon->addBet($bet);

    $bet->save();

    return $bet;
}

function create_bet_of_roundbet_with_round_and_team_on_coupon(App\Models\Coupon $coupon, App\Models\Team $team = null, App\Models\Round $round = null)
{
    if ( is_null($round) )
    {
        $round = create_a_round_on_the_championship($coupon->championship);
    }
    
     if ( is_null($team) )
    {
        $team = create_a_team_on_round_of_championship($round, $coupon->championship);
    }

    $bet = new App\Models\Bet();        
        
    $roundBet = new App\Models\RoundBet();

    $roundBet->associateRound($round);
    $roundBet->associateTeam($team);
    $roundBet->save();

    $bet->addBettype($roundBet);

    $coupon->addBet($bet);

    $bet->save();

    return $bet;
}

function create_bet_of_playerbet_with_player_on_coupon(\App\Models\Coupon $coupon, App\Models\Player $player = null)
{
        $bet = new App\Models\Bet();        
        
        $playerBet = new App\Models\PlayerBet();
        
        if ( is_null($player) )
        {
            $player = create_a_player_on_a_team_which_is_on_the_championship($coupon->championship);
        }
        
        $playerBet->associatePlayer($player);
        $playerBet->save();
        
        $bet->addBettype($playerBet);

        $coupon->addBet($bet);

        $bet->save();

        return $bet;
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