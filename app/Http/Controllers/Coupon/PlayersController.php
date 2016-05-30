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

    public function store(Request $request)
    {
        $saved_completely = true;
        $message = 'Players have been saved!';

         $this->validate($request, [
                'bet.*' => 'numeric',
            ]);
           
           $userBets = $this->repository->bets();

           foreach($request->input('bet') as $id => $value){
                try{
                    $this->repository->save($id,$value);
                }
                catch (\Exception $e)
                {
                    $saved_completely = false;
                    $message = 'Players has been partially saved.';
                }
           }
            
            $request->session()->flash('status', $message);

           return redirect('/coupon');
    }
}
