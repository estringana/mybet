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

        $this->instantiateRepositoriesFromCoupon($this->getCoupon());         
    }

    protected function instantiateRepositoriesFromCoupon($coupon)
    {           
        $this->playersRepository = new PlayerBetsRepository($coupon);         
        $this->matchRepository = new MatchBetsRepository($coupon);         
        $this->roundRepository = new RoundBetsRepository($coupon);    
    }

    protected function getCoupon()
    {       
        return \Auth::user()->couponOfChampionsip($this->championship);
    }

    protected function getData()
    {
        $data = [];
        $data['playerBets'] = $this->playersRepository->bets();
        $data['matchBets'] = $this->matchRepository->bets();
        $data['roundOf16Bets'] = $this->roundRepository->betsOfRound(2);
        $data['quarterFinalsBets'] = $this->roundRepository->betsOfRound(3);
        $data['semiFinals'] = $this->roundRepository->betsOfRound(4);
        $data['final'] = $this->roundRepository->betsOfRound(5);
        $data['champion'] = $this->roundRepository->betsOfRound(6);
        $data['runnersup'] = $this->roundRepository->betsOfRound(7);
        $data['user'] = $this->getCoupon()->user;

        return $data;
    }

    public function index()
    {
        $data = $this->getData();

        $data['editable'] = true;

        return view('coupons.own')
        ->with($data);   
    }

    public function view($user_id)
    {
        $coupon = $this->championship->coupons()->where('user_id',$user_id)->firstOrFail();

        $this->instantiateRepositoriesFromCoupon($coupon);

        $data = $this->getData();
        $data['editable'] = false;
        $data['user'] = $coupon->user;

        return view('coupons.view')
        ->with($data);   
    }

    public function all()
    {
        $coupons = $this->championship->coupons;

         return view('coupons.users')
                ->with(['coupons'=>$coupons]);  
    }

    public function printable()
    {
           $coupons = [];

           foreach ($this->championship->coupons as $coupon)
           {
               $this->instantiateRepositoriesFromCoupon($coupon);
               $couponData = $this->getData();
               $couponData['user'] = $coupon->user;

               $coupons [] = $couponData;
           }

           return view('coupons.printable')
                ->with([ 'coupons' => $coupons ]);
    }
}
