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

Route::group(['namespace' => 'Api\V1'], function (){
    Route::group(['prefix' => 'api'], function () {

        Route::group(['prefix'=>'token'],function (){
            Route::post('/', 'TokenController@store');
        });

        Route::group(['middleware' => ['jwt.auth']],function (){

            Route::group(['prefix'=>'menu'],function (){
                Route::resource('/', 'MenuController@store');
            });
        });
    });
});






Route::get('/', function () {
    return view('welcome');
});
