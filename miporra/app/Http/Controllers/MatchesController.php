<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MatchesController extends Controller
{
    public function index()
    {
           $matches = $this->championship->matches;

           return view('championship.pages.matches')
                ->with( compact(['matches']) );
    }
}
