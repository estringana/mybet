<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\PlayerBetsRepository;

class CouponController extends Controller
{
    protected $playersRepository;

    public function __construct()
    {
        parent::__construct();

        $this->playersRepository = new PlayerBetsRepository($this->getCoupon());         
    }

    protected function getCoupon()
    {       
        return \Auth::user()->couponOfChampionsip($this->championship);
    }

    public function index()
    {
        $players = $this->playersRepository->players();

        return view('coupons.view')
        ->with(
                compact(['players'])
        );   
    }
}
