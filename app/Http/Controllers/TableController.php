<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class TableController extends Controller
{
    public function index()
    {
           $table = new \App\Championship\TableGenerator($this->championship);

           return view('championship.pages.table')
                ->with([ 
                    'table' => $table->generate(),
                    'championship' => $this->championship
                ]);
    }
}
