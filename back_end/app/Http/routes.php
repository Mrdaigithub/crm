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

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {

        // token
        $api->post('/token/create', 'TokenController@create');

        // users
        $api->group(['prefix' => 'users', 'middleware' => 'jwt.auth'], function ($api) {
            $api->get('/{id}', 'UserController@show');
        });
    });
});


Route::get('/', function () {
    return view('welcome');
});
