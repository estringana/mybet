<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Match;
use App\Models\ProposedScore;
use App\Models\Championship;

class ProposedScoresRepository
{
    const PROPOSITION_NEEDED_TO_BECOME_REAL = 4;

    protected $user;
    protected $championship;

    public function __construct(User $user, Championship $championship)
    {
        $this->user = $user;
        $this->championship = $championship;
    }

    protected function guardAgainstMatchNotFound($match_id)
    {
        $occurences_found = $this->championship
            ->matches
            ->where('id',$match_id)
            ->count();

           if ( $occurences_found == 0 )
           {
                throw new \App\Exceptions\MatchNotFoundException();
           }
    }

    protected function guardAgainstSameUserGivingSameScore($match_id, $local_score, $away_score)
    {
        $occurences_found = $this->user
            ->propositions()
            ->where('match_id',$match_id)
            ->where('local_score',$local_score)
            ->where('away_score',$away_score)
            ->count();

        if ( $occurences_found > 0 )
           {
                throw new \App\Exceptions\DuplicatePredictionException();
           }
    }

    protected function shouldItBecomeAScore($match_id, $local_score, $away_score)
    {
        if ($this->user->is_admin)
        {
            return true;
        }
        
        return ProposedScore::where('match_id',$match_id)
            ->where('local_score',$local_score)
            ->where('away_score',$away_score)
            ->count() >= ProposedScoresRepository::PROPOSITION_NEEDED_TO_BECOME_REAL;
    }

    protected function removeOldPrepositions($match_id, $local_score, $away_score)
    {
          $propositionsToDelete = ProposedScore::where('match_id',$match_id)
            ->where('local_score',$local_score)
            ->where('away_score',$away_score)
            ->get();

            foreach ($propositionsToDelete as $proposition) {
                $proposition->delete();
            }
    }

    protected function setScoreToMatch($match_id, $local_score, $away_score)
    {
           $match = $this->championship
                ->matches
                ->where('id',$match_id)
                ->first();

            $match->addScore($local_score, $away_score);
            $match->save();
            $this->removeOldPrepositions($match_id, $local_score, $away_score);
    }

    protected function create_proposed_score($match, $local_score, $away_score)
    {
           $proposedScore = new ProposedScore();
           $proposedScore->local_score = $local_score;
           $proposedScore->away_score = $away_score;
           $proposedScore->addMatch($match);
           $proposedScore->addUser($this->user);
           $proposedScore->save();
    }

    protected function guardAgainstInvalidScore($score)
    {
        if ( ! is_integer($score) || $score<0){
            throw new \App\Exceptions\InvalidScoreException();
        }
    }

    public function save($match_id, $local_score, $away_score)
    {
           $this->guardAgainstMatchNotFound($match_id);
           $this->guardAgainstInvalidScore($local_score);
           $this->guardAgainstInvalidScore($away_score);
           $this->guardAgainstSameUserGivingSameScore($match_id, $local_score, $away_score);

           $match = $this->championship->matches->where('id',$match_id)->first();

           $this->create_proposed_score($match, $local_score, $away_score);

            if ( $this->shouldItBecomeAScore($match_id, $local_score, $away_score) )
            {
                $this->setScoreToMatch($match_id, $local_score, $away_score);
            }
    }
}