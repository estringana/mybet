<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App\Repositories\MatchBetsRepository;

class MatchesController extends \App\Http\Controllers\Controller
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository = new MatchBetsRepository($this->getCoupon());         
    }

    protected function getCoupon()
    {       
        return \Auth::user()->couponOfChampionsip($this->championship);
    }

    public function index()
    {
        $matchBets = $this->repository->bets();

        return view('coupons.matches.edit')
        ->with(
                compact(['matchBets'])
        );
    }

    public function store(Request $request)
    {
        $saved_completely = true;

         $this->validate($request, [
                'bet.*' => 'in:1,X,2',
            ]);
           
           $userBets = $this->repository->bets();

           foreach($request->input('bet') as $id => $value){
                try{
                    $this->repository->save($id,$value);
                }
                catch (\Exception $e)
                {
                    $saved_completely = false;
                }
           }
            
            if ($saved_completely)
            {
                alert()->success(trans('messages.Matches have been saved'), 'Saved');
            }
            else
            {
                alert()->warning(trans('messages.Matches has been partially saved'), 'Saved with errors');
            }

           return redirect('/coupon');
    }
}
