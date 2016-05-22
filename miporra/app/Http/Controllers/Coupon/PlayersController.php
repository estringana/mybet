<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;
use App\Http\Requests;
use \App\Models\Player;
use \App\Repositories\PlayerBetsRepository;
use \App\Http\Requests\PlayerBetsRequest;

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

        $selected_players = $this->repository->players()->lists(['id']);

        return view('coupons.players.edit')
        ->with(
                compact(['players','bets_allowed','selected_players'])
        );
    }
    
    public function store(PlayerBetsRequest $request)
    {
        $players = $request->except('_token');

       $this->repository->updatePlayersBetsFromValues($players);        

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
