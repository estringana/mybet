<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;
use App\Http\Requests;
use \App\Models\Round;

use \App\Repositories\RoundBetsRepository;

class RoundsController extends \App\Http\Controllers\Controller
{    
    protected $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository = new RoundBetsRepository($this->getCoupon());         
    }
    
    protected function getCoupon()
    {       
        return \Auth::user()->couponOfChampionsip($this->championship);
    }

    protected function getTeamsByName()
    {
        return $this->repository->teams()->sortBy('name');
    }

    public function index($round)
    {
        $round = Round::where('championship_id',$this->championship->id)
            ->where('identifier',$round)
            ->firstOrFail();

        $title = $round->name;

        $teams = $this->getTeamsByName();

        $roundBets = $this->repository->betsOfRound($round->id);

        return view('coupons.rounds.edit')
        ->with(
                compact(['teams','roundBets','title'])
        );
    }

    public function store(Request $request)
    {
        $saved_completely = true;
        $message = 'Teams have been saved!';

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
                    dd($e);
                    $saved_completely = false;
                    $message = 'Team has been partially saved.';
                }
           }
            
            $request->session()->flash('status', $message);

           return redirect('/coupon');
    }
}
