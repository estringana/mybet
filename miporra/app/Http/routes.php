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

 Route::group(['prefix' => LaravelLocalization::setLocale()], function()
    {
        Route::auth();

        Route::get('/coupon/', [
            'middleware' => 'auth',
            'uses' => 'CouponController@index'
        ]);

        Route::get('/coupon/players/update', [
            'middleware' => 'auth',
            'uses' => 'Coupon\PlayersController@index'
        ]);

        Route::post('/coupon/players/store', [
            'middleware' => 'auth',
            'uses' => 'Coupon\PlayersController@store'
        ]);

        Route::get('/coupon/matches/update', [
            'middleware' => 'auth',
            'uses' => 'Coupon\MatchesController@index'
        ]);

        Route::post('/coupon/matches/store', [
            'middleware' => 'auth',
            'uses' => 'Coupon\MatchesController@store'
        ]);

        Route::get('/coupon/round/{round}/update', [
            'middleware' => 'auth',
            'uses' => 'Coupon\RoundsController@index'
        ]);

        Route::post('/coupon/round/store', [
            'middleware' => 'auth',
            'uses' => 'Coupon\RoundsController@store'
        ]);

        

        Route::get('/', function()
        {
            return view('pages.home');
        });
    });
