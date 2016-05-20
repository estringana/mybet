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

        Route::get('/coupon/create', [
                'middleware' => 'auth',
               'uses' => 'CouponController@create'
        ]);

        Route::get('/', function()
        {
            return view('pages.home');
        });
    });
