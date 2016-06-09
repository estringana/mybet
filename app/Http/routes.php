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

 Route::group([
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
        ], function() {
            
        Route::auth();



//All the time        
        Route::get('/message', [
            'middleware' => 'auth',
            'uses' => 'MessagesController@index'
        ]);

        Route::post('/message', [
            'middleware' => 'auth',
            'uses' => 'MessagesController@store'
        ]);

        Route::get('/matches', [
            'middleware' => 'auth',
            'uses' => 'MatchesController@index'
        ]);

        Route::group(['middleware' => ['user.admin']], function () {
            Route::get('/users/printable', [
                'middleware' => 'auth',
                'uses' => 'CouponController@printable'
            ]);

            Route::get('/messages', [
                'middleware' => 'auth',
                'uses' => 'MessagesController@list'
            ]);

            Route::get('/users/list', [
                'middleware' => 'auth',
                'uses' => 'AdminController@listsUsers'
            ]);

            Route::get('/users/edit/{id}', [
                'middleware' => 'auth',
                'uses' => 'AdminController@editUser'
            ]);

            Route::post('/users/edit/{id}', [
                'middleware' => 'auth',
                'uses' => 'AdminController@saveUser'
            ]);
        });

        Route::group(['middleware' => ['championship.hasStarted']], function () {
                Route::get('/matches/propose/{match_id}', [
                    'middleware' => 'auth',
                    'uses' => 'MatchesController@propose'
                ]);

                Route::post('/matches/propose/{match_id}', [
                    'middleware' => 'auth',
                    'uses' => 'MatchesController@storeProposition'
                ]);

                Route::get('/coupon/all', [
                    'middleware' => 'auth',
                    'uses' => 'CouponController@all'
                ]);

                Route::get('/coupon/view/{user_id}', [
                    'middleware' => 'auth',
                    'uses' => 'CouponController@view'
                ]);

                Route::get('/statistics/player/{player_id}', [
                    'middleware' => 'auth',
                    'uses' => 'StatisticsController@player'
                ]);

                Route::get('/statistics/team/{team_id}', [
                    'middleware' => 'auth',
                    'uses' => 'StatisticsController@team'
                ]);

                Route::get('/statistics/match/{match_id}', [
                    'middleware' => 'auth',
                    'uses' => 'StatisticsController@match'
                ]);

                 Route::get('/table', [
                    'middleware' => 'auth',
                    'uses' => 'TableController@index'
                ]);
        });


        Route::group(['middleware' => ['championship.open']], function () {
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
        });     

        Route::get('/', function()
        {
            return view('pages.home');
        });
    });
