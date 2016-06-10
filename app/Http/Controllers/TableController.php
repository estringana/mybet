<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class TableController extends Controller
{
    public function index()
    {
            if ( ! Cache::has('table') )
            {
                $table = new \App\Championship\TableGenerator($this->championship);
                Cache::forever( 'table' , $table->generate() );
            }

            $table = Cache::get('table');

           return view('championship.pages.table')
                ->with([ 
                    'table' => $table,
                    'championship' => $this->championship
                ]);
    }
}
