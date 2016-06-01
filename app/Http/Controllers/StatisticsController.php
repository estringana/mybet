<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PlayerStatisticsRepository;

class StatisticsController extends Controller
{
    private $playerRepository;

    public function __construct()
    {
        parent::__construct();
        $this->playerRepository = new PlayerStatisticsRepository($this->championship);
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
}
