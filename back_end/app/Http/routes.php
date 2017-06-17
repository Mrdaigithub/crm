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

$api = app('Dingo\Api\Routing\Router');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/', 'Api\V1\UserController@index');

$api->version('v1', function ($api) {
    $api->group(['namespace'=>'App\Http\Controllers\Api\V1'],function ($api){

        $api->post('/token', 'TokenController@store');

        $api->group(['middleware'=>['jwt.auth']],function ($api){

            $api->group(['prefix'=>'roles'],function ($api){
                $api->get('/{name}', 'RoleController@store');
            });

            $api->group(['prefix'=>'users'],function ($api){
                $api->get('/', 'UserController@index');
                $api->post('/', 'UserController@store');
            });
        });
    });
});
