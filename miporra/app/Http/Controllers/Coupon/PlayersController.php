<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;
use App\Http\Requests;
use \App\Models\Player;
use \App\Repositories\PlayerBetsRepository;

class PlayersController extends \App\Http\Controllers\Controller
{    
    protected $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository = new PlayerBetsRepository($this->getCoupon());         
    }
    protected function getCoupon()
    {       
        return \Auth::user()->couponOfChampionsip($this->championship);
    }

    protected function getPlayersByName()
    {
        return $this->championship->players->sortBy('name');
    }

    public function index()
    {
        $players = $this->getPlayersByName();
        $bets_allowed = 8;

        return view('coupons.players.edit')
        ->with(
                compact(['players','bets_allowed'])
        );
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'player' => 'required|array'
        ]);

        $players = $request->get('player');

        $repository = new \App\Repositories\PlayerBetsRepository($this->getCoupon());

       $repository->updatePlayersBetsFromValues($players);        

       $request->session()->flash('status', 'Players have been saved!');

        return redirect('/coupon/players');
    }

    public function show()
    {
        $players = $this->repository->players();

        return view('coupons.players')
        ->with(
                compact(['players'])
        );
    }
}
