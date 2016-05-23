<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PlayerBetsRepository;
use App\Repositories\MatchBetsRepository;

class CouponController extends Controller
{
    protected $playersRepository;
    protected $matchRepository;

    public function __construct()
    {
        parent::__construct();

        $this->playersRepository = new PlayerBetsRepository($this->getCoupon());         
        $this->matchRepository = new MatchBetsRepository($this->getCoupon());         
    }

    protected function getCoupon()
    {       
        return \Auth::user()->couponOfChampionsip($this->championship);
    }

    public function index()
    {
        $playerBets = $this->playersRepository->bets();
        $matchBets = $this->matchRepository->bets();

        return view('coupons.view')
        ->with(
                compact(['playerBets','matchBets'])
        );   
    }
}
