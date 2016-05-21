<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;
use App\Http\Requests;
use \App\Models\Player;

class PlayersController extends \App\Http\Controllers\Controller
{    
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

        return view('coupons.players')
        ->with(
                compact(['players','bets_allowed'])
        );
    }

    protected function createBet(Player $player)
    {
            $bet = new \App\Models\Bet();  
            $playerBet = new \App\Models\PlayerBet();

            $playerBet->associatePlayer($player);            
            $playerBet->save();

            $bet->addBettype($playerBet);

            return $bet;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'player' => 'required|array'
        ]);

        $coupon = $this->getCoupon();

        foreach ($request->get('player') as $id) {
            $player = Player::findOrFail($id)->first();
            
            $bet = $this->createBet($player);

            $coupon->addBet($bet);
        }

        $coupon->save();

        return redirect('/')->with('status', 'Players have been saved');
    }
}
