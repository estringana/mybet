<?php

namespace App\Transformers;

use App\Models\ProposedGoal;
use App\Models\Goal;

class ProposedGoalToGoal
{
    public static function transform(ProposedGoal $proposed)
    {
        $goal = new Goal();
        $goal->addPlayer($proposed->player);
        $goal->penalty = $proposed->penalty;
        $goal->own_goal = $proposed->own_goal;
        $goal->penalty_round = $proposed->penalty_round;

        return $goal;
    }
}