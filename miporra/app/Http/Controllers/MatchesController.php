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
}
