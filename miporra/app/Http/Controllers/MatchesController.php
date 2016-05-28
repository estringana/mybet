<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
                'local'=> 'required|numeric',
                'away' => 'required|numeric'
            ]);

           $this->guardAgainstMatchNotFound($match_id);

           $repository = new \App\Repositories\ProposedScoresRepository(\Auth::user(), $this->championship);

           $repository->save($match_id, (int) $request->get('local'), (int) $request->get('away'));

           return redirect('/matches');
    }
}
