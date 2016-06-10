<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class TableController extends Controller
{

    protected function getTable()
    {
           if ( ! Cache::has('table') )
            {
                $table = new \App\Championship\TableGenerator($this->championship);
                Cache::forever('table',$table);
            }

            return Cache::get('table');
    }
    public function index()
    {
           $table = $this->getTable();

           return view('championship.pages.table')
                ->with([ 
                    'table' => $table->generate(),
                    'championship' => $this->championship
                ]);
    }
}
