<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Match;

class MatchesController extends Controller
{
    public function index()
    {
           $matchesGropedByRoundName = $this->championship->matchesByRoundOrderedByDate();

           return view('championship.pages.matches')
                ->with( compact(['matchesGropedByRoundName']) );
    }

    protected function getMatchFromId($match_id)
    {
           return $this->championship
            ->matches
            ->find($match_id);
    }

    protected function guardAgainstMatchNotFound($match_id)
    {
            $match = $this->getMatchFromId($match_id);

           if ( is_null($match) )
           {
                throw new \App\Exceptions\MatchNotFoundException();
           }
    }

    public function propose($match_id)
    {
        $this->guardAgainstMatchNotFound($match_id);

        $match = $this->getMatchFromId($match_id);

        $proposedScores = $match->propositions()->select('local_score','away_score', \DB::raw('count(*) as times'))->groupBy('local_score','away_score')->get();

             return view('championship.actions.proposeScore')
                ->with( compact(['match','proposedScores']) );
    }

    public function storeProposition(Request $request,int $match_id)
    {
            $this->validate($request, [
                'player.*'=> 'numeric'
            ]);

          $playersWithGoals = cleanEmptyValues($request->input('player'));
          
          try {
               $this->guardAgainstMatchNotFound($match_id);

               $repository = new \App\Repositories\ProposedScoresRepository(\Auth::user(), $this->championship);
        
                $local = 0;
                $away = 0;

                foreach ($playersWithGoals as $player_id => $goals) {
                      for ($i = 0; $i < $goals; $i++ )
                      {
                            $team = $repository->addGoal($match_id, $player_id, false, false, false);

                            if ($team == Match::LOCAL)
                            {
                                $local++;
                            }
                            else
                            {
                                $away++;
                            }
                      }
                }

               $repository->save($match_id, $local, $away);

                alert()->success(trans('messages.It have been saved'), 'Saved');
            } catch (Exception $e) {
                alert()->error(trans('messages.There has been a error'), 'Error');
            }

           return redirect('/matches');
    }
}
