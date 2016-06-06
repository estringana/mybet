<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Match;
use App\Models\ProposedScore;
use App\Models\Championship;
use App\Models\ProposedGoal;

class ProposedScoresRepository
{
    const PROPOSITION_NEEDED_TO_BECOME_REAL = 4;

    protected $user;
    protected $championship;
    protected $goals;

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

    protected function guardAgainstScoreDontMatchingGoals($away_score, $local_score)
    {
           if ( ($away_score + $local_score) != count($this->goals) )
           {
              throw new \App\Exceptions\AmountOfGoalsDifferentFromMatchScoreException();
           }
    }
    
    protected function getPlayerFromMatch(Match $match, $player_id)
    {
           $allPlayersOnMatch = $match->local->players->merge($match->away->players);

           $player = $allPlayersOnMatch->where('id',$player_id);

           if ( $player->isEmpty() )
           {
              throw new \App\Exceptions\PlayerNotFoundException();
           }

           return $player->first();
    }

    protected function getMatch($match_id)
    {
            $this->guardAgainstMatchNotFound($match_id);

           return $this->championship->matches->where('id',$match_id)->first();
    }

    public function addGoal($match_id, $player_id, $penalty, $own_goal, $penalty_round)
    {
           $match = $this->getMatch($match_id);

           $player = $this->getPlayerFromMatch($match, $player_id);

           $proposedGoal = new ProposedGoal();
           $proposedGoal->addPlayer($player);
           $proposedGoal->penalty = $penalty;
           $proposedGoal->own_goal = $own_goal;
           $proposedGoal->penalty_round = $penalty_round;

           $this->goals[] = $proposedGoal;

           return count($this->goals);
    }

    public function save($match_id, $local_score, $away_score)
    {
           $this->guardAgainstInvalidScore($local_score);
           $this->guardAgainstInvalidScore($away_score);
           // $this->guardAgainstScoreDontMatchingGoals($away_score, $local_score);
           $this->guardAgainstSameUserGivingSameScore($match_id, $local_score, $away_score);

           $match = $this->getMatch($match_id);

           $this->create_proposed_score($match, $local_score, $away_score);

            if ( $this->shouldItBecomeAScore($match_id, $local_score, $away_score) )
            {
                $this->setScoreToMatch($match_id, $local_score, $away_score);
            }
    }
}