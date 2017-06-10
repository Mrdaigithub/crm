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
        $api->group(['prefix' => 'token'], function ($api) {
            $api->post('/create', 'TokenController@create'); // 创建token
        });

        // user
//        , 'middleware' => 'jwt.refresh'
        $api->group(['prefix' => 'users','middleware'=>'jwt.auth'], function ($api) {
            $api->get('/{id}', 'UserController@show'); // 获取当前用户信息
        });
    });
});


Route::get('/', function () {
    return view('welcome');
});
