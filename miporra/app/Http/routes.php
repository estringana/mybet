<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/en');
});


Route::get('/{locale}', function ($locale) {
    if (! in_array($locale, ['es','en'])){
        return redirect('/en');
    }
    App::setLocale($locale);

    return view('pages.home');
});
