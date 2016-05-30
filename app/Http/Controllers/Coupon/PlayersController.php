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
        return $this->repository->players()->sortBy('name');
    }

    public function index()
    {
        $players = $this->getPlayersByName();

        $playerBets = $this->repository->bets();

        return view('coupons.players.edit')
        ->with(
                compact(['players','playerBets'])
        );
    }

    protected function guardAgainstPlayersPickedTwice($players_picked, $player_id)
    {
           if ( in_array($player_id,$players_picked) )
           {
                throw new \App\Exceptions\PlayerPickedTwiceException();
           }
    }

    public function store(Request $request)
    {
        $message = 'Players have been saved!';

         $this->validate($request, [
                'bet.*' => 'numeric',
            ]);

         $players_picked = [];

           foreach($request->input('bet') as $id => $value){
                try{
                    $this->guardAgainstPlayersPickedTwice($players_picked,$value);
                    $this->repository->save($id,$value);
                    $players_picked[] = $value;
                }
                catch (\Exception $e)
                {
                    $this->repository->save($id,"");
                    $message = 'Players has been partially saved.';
                }
           }
            
            $request->session()->flash('status', $message);

           return redirect('/coupon');
    }
}
