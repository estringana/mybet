<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RoundsController extends Controller
{
    protected function getRounds()
    {
           return $this->championship->rounds()->where('identifier','!=','GroupStage')->get();
    }

    public function index()
    {
           $rounds = $this->getRounds();

           return view('championship.pages.rounds')->with('rounds',$rounds);
    }
}
