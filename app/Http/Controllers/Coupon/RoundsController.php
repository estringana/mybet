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

    protected function guardAgainstTeamsPickedTwice($teams_picked, $team_id)
    {
           if ( in_array($team_id,$teams_picked) )
           {
                throw new \App\Exceptions\TeamPickedTwiceException();
           }
    }

    public function store(Request $request)
    {
         $saved_completely = true;
         
         $this->validate($request, [
                'bet.*' => 'numeric',
            ]);
            throw new \Exception(); //No more update available
         $teams_picked = [];

           foreach($request->input('bet') as $id => $value){
                try{
                    $this->guardAgainstTeamsPickedTwice($teams_picked,$value);
                    $this->repository->save($id,$value);
                    if ( ! empty($value))
                    {
                        $teams_picked[] = $value;
                    }
                }
                catch (\Exception $e)
                {
                    $this->repository->save($id,"");
                    $saved_completely = false;
                }
           }
            
            if ($saved_completely)
            {
                alert()->success(trans('messages.Teams have been saved'), 'Saved');
            }
            else
            {
                alert()->warning(trans('messages.Teams has been partially saved'), 'Saved with errors');
            }

           return redirect('/coupon');
    }
}
