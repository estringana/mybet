<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repositories\PlayerBetsRepository;
use App\Repositories\MatchBetsRepository;
use App\Repositories\RoundBetsRepository;

class CouponController extends Controller
{
    protected $playersRepository;
    protected $matchRepository;
    protected $roundRepository;

    public function __construct()
    {
        parent::__construct();

        $this->playersRepository = new PlayerBetsRepository($this->getCoupon());         
        $this->matchRepository = new MatchBetsRepository($this->getCoupon());         
        $this->roundRepository = new RoundBetsRepository($this->getCoupon());         
    }

    protected function getCoupon()
    {       
        return \Auth::user()->couponOfChampionsip($this->championship);
    }

    public function index()
    {
        $data['playerBets'] = $this->playersRepository->bets();
        $data['matchBets'] = $this->matchRepository->bets();
        $data['roundOf16Bets'] = $this->roundRepository->betsOfRound(2);
        $data['quarterFinalsBets'] = $this->roundRepository->betsOfRound(3);
        $data['semiFinals'] = $this->roundRepository->betsOfRound(4);
        $data['final'] = $this->roundRepository->betsOfRound(5);
        $data['champion'] = $this->roundRepository->betsOfRound(6);
        $data['runnersup'] = $this->roundRepository->betsOfRound(7);

        return view('coupons.view')
        ->with($data);   
    }

    public function test()
    {
        $data['playerBets'] = $this->playersRepository->points();
        $data['matchBets'] = $this->matchRepository->points();
        $data['roundOf16Bets'] = $this->roundRepository->pointsOfRound(2);
        $data['quarterFinalsBets'] = $this->roundRepository->pointsOfRound(3);
        $data['semiFinals'] = $this->roundRepository->pointsOfRound(4);
        $data['final'] = $this->roundRepository->pointsOfRound(5);
        $data['champion'] = $this->roundRepository->pointsOfRound(6);
        $data['runnersup'] = $this->roundRepository->pointsOfRound(7);

       dd($data);
    }
}
