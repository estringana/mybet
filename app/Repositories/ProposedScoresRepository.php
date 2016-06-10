<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Match;
use App\Models\Player;
use App\Models\ProposedScore;
use App\Models\Championship;
use App\Models\ProposedGoal;

class ProposedScoresRepository
{
    const PROPOSITION_NEEDED_TO_BECOME_REAL = 4;

    protected $user;
    protected $championship;
    protected $goals;
    protected $local_score;
    protected $away_score;

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

    protected function areProposedGoalsSameAsProposedScore(ProposedScore $proposedScore)
    {      
          $proposedGoals = collect($this->goals);
          $proposedGoalsPreviously = $proposedScore->proposedGoals;
           if ( count($this->goals) == 0 &&  ($proposedScore->localScore+$proposedScore->away_score == 0))
           {
              return true;
           }

           if( $proposedScore->proposedGoals->isEmpty() )
           {
              return false;              
           }

           if ($proposedGoals->count() !== $proposedScore->proposedGoals->count())
           {
              return false;
           }
           
           $ids = [];
           $resul = $proposedGoals->filter(function ($goal, $key) use ($proposedGoalsPreviously, &$ids) {
                $goalFound =  $proposedGoalsPreviously->where('player_id',$goal->player_id)->reject(function ($goal, $key) use ($ids) {
                            return in_array($goal->id,$ids);
                      })->first();

                if ( ! is_null($goalFound) )
                {
                  $ids[] = $goalFound->id;
                  return true;
                }

                return false;
           });

           return $resul->count() == $proposedScore->proposedGoals->count();
           
    }

    protected function guardAgainstSameSameScore($match_id, $local_score, $away_score)
    {
        $match =$this->championship
            ->matches()
            ->findOrFail($match_id);

        $proposedScoresMatchingScore = $match->propositions()
            ->where('local_score',$local_score)
            ->where('away_score',$away_score)->get();
            

         foreach ($proposedScoresMatchingScore as $proposedScore) {
            if ( $this->areProposedGoalsSameAsProposedScore( $proposedScore ) )
            {
                throw new \App\Exceptions\DuplicatePredictionException();
            }
         }        
    }

    protected function setGoalsToMatch(Match $match, ProposedScore $proposedScore)
    {
           foreach ($proposedScore->proposedGoals as $proposedGoal) {
              $goal = \App\Transformers\ProposedGoalToGoal::transform($proposedGoal);
              $match->addGoal($goal);
           }

          $match->save();
    }

    protected function setScoreToMatch(Match $match, ProposedScore $proposedScore)
    {
            $match->goals()->delete();
            $match->addScore($proposedScore->local_score, $proposedScore->away_score);
            $this->setGoalsToMatch($match, $proposedScore);
            $match->save();
            $proposedScore->delete();
            \Cache::flush();
    }

    protected function create_proposed_score($match, $local_score, $away_score)
    {
          $this->guardAgainstScoreDontMatchingGoals($away_score, $local_score);
          $this->guardAgainstSameSameScore($match->id, $local_score, $away_score);

           $proposedScore = new ProposedScore();
           $proposedScore->local_score = $local_score;
           $proposedScore->away_score = $away_score;
           $proposedScore->addMatch($match);
           $proposedScore->addUser($this->user);
           $proposedScore->save();

           if (count($this->goals) > 0){
               foreach ($this->goals as $proposedGoal) {
                  $proposedScore->addGoal($proposedGoal);
               }

               $proposedScore->save();
           }

           $this->goals = [];

           return $proposedScore;
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
           $allPlayersOnMatch = $match->players();

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

    protected function playerBelongsToLocalOrAway(Match $match, Player $player)
    {
           if ($match->local->hasPlayer($player))
           {
                return Match::LOCAL;
           }
           elseif ($match->away->hasPlayer($player))
           {
              return Match::AWAY;
           }

           throw new \App\Exceptions\PlayerNotFoundException();
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

           return $this->playerBelongsToLocalOrAway($match, $player);
    }

    protected function shouldItBecomeAScore()
    {
           return $this->user->is_admin;
    }

    public function save($match_id, $local_score, $away_score)
    {
           $this->guardAgainstInvalidScore($local_score);
           $this->guardAgainstInvalidScore($away_score);

           $match = $this->getMatch($match_id);

           $proposedScore = $this->create_proposed_score($match, $local_score, $away_score);

            if ( $this->shouldItBecomeAScore() )
            {
                $this->setScoreToMatch($match, $proposedScore);
            }
    }
}