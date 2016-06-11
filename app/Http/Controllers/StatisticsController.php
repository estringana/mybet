<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PlayerStatisticsRepository;
use App\Repositories\TeamStatisticsRepository;
use App\Repositories\MatchStatisticsRepository;
use App\Championship\Statistics\BreakDownMatchWithPrediction;
use Cache;

class StatisticsController extends Controller
{
    private $playerRepository;
    private $teamRepository;
    private $matchRepository;

    public function __construct()
    {
        parent::__construct();
        $this->playerRepository = new PlayerStatisticsRepository($this->championship);
        $this->teamRepository = new TeamStatisticsRepository($this->championship);
        $this->matchRepository = new MatchStatisticsRepository($this->championship);
    }

    public function player($player_id)
    {
        try {
            $percentage = $this->playerRepository->percentage($player_id);
            $coupons = $this->playerRepository->couponsWithPlayer($player_id);
            $player = $this->playerRepository->getPlayer($player_id);

           return view('statistics.player')
                ->with( compact(['percentage','coupons','player']) );

        }
        catch (\Exceptions\PlayerNotFoundException $e) {
            alert()->error(trans('messages.Player not found'), 'Error');
        } 
        catch (\Exception $e) {
            alert()->error('Error', 'Error');
        }           

        return redirect('/');
    }

    public function players()
    {
        try {
                if ( ! Cache::has('players') )
                {
                    $players = $percentage = $this->playerRepository->all();
                    Cache::forever( 'players' , $players );
                }

                $players = Cache::get('players');
           return view('statistics.players')
                ->with( compact(['players']) );
        }
        catch (\Exception $error) {
            \Log::error($error);
            alert()->error('Error', 'Error');
        }           

        return redirect('/');
    }

    public function match($match_id)
    {
        try {
            $predictionsWith1 = new BreakDownMatchWithPrediction();
            $predictionsWith1->percentage = $this->matchRepository->percentageWithPrediction($match_id, 1);
            $predictionsWith1->coupons = $this->matchRepository->couponsWithMatchAndPrediction($match_id, 1);
            
            $predictionsWithX = new BreakDownMatchWithPrediction();
            $predictionsWithX->percentage = $this->matchRepository->percentageWithPrediction($match_id, 'X');
            $predictionsWithX->coupons = $this->matchRepository->couponsWithMatchAndPrediction($match_id, 'X');
            
            $predictionsWith2 = new BreakDownMatchWithPrediction();
            $predictionsWith2->percentage = $this->matchRepository->percentageWithPrediction($match_id, 2);
            $predictionsWith2->coupons = $this->matchRepository->couponsWithMatchAndPrediction($match_id, 2);
            
            $match = $this->matchRepository->getMatch($match_id);

           return view('statistics.match')
                ->with( compact(['predictionsWith1','predictionsWithX','predictionsWith2','match']) );

        }
        catch (\Exceptions\MatchNotFoundException $e) {
            alert()->error(trans('messages.Match not found'), 'Error');
        } 
        catch (\Exception $e) {
            alert()->error('Error', 'Error');
        }           

        return redirect('/');
    }

    public function team($team_id)
    {
        try {
            $team = $this->teamRepository->getTeam($team_id);
            $teamOnRounds = $this->teamRepository->getBreakDownOfTeam($team_id);

           return view('statistics.team')
                ->with( compact(['teamOnRounds','team']) );

        }
        catch (\Exception $e) {
            alert()->error('Error', 'Error');
        }           

        return redirect('/');
    }
}
