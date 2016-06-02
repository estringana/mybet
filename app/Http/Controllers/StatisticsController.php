<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PlayerStatisticsRepository;
use App\Repositories\TeamStatisticsRepository;

class StatisticsController extends Controller
{
    private $playerRepository;
    private $teamRepository;

    public function __construct()
    {
        parent::__construct();
        $this->playerRepository = new PlayerStatisticsRepository($this->championship);
        $this->teamRepository = new TeamStatisticsRepository($this->championship);
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
