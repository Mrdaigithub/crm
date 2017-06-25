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
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {

        // token
        $api->post('/token', 'TokenController@store');

        $api->group(['middleware' => ['jwt.auth']], function ($api) {

            // menus
            $api->group(['prefix' => 'menus'], function ($api) {
                $api->get('/', 'MenuController@index');
                $api->post('/', 'MenuController@store');
            });

            // roles
            $api->group(['prefix' => 'roles'], function ($api) {
                $api->get('/', 'RoleController@index');
                $api->get('/{name}/create', 'RoleController@create');
                $api->PATCH('/{id}', 'RoleController@update');
                $api->delete('/{id}', 'RoleController@destroy');
            });

            // users
            $api->group(['prefix' => 'users'], function ($api) {
                $api->get('/', 'UserController@index');
                $api->get('/{id}', 'UserController@show_by_uid');
                $api->get('/role/{id}', 'UserController@show_by_rid');
                $api->post('/', 'UserController@store');
                $api->patch('/{id}', 'UserController@update');
                $api->delete('/{id}', 'UserController@destroy');
            });

            // permissions
            $api->group(['prefix' => 'permissions'], function ($api){
                $api->get('/{id}', 'PermissionController@show');
                $api->put('/{id}', 'PermissionController@update');
            });

            // Management
            $api->group(['prefix' => 'management', 'namespace' => 'Management'], function ($api){

                // channels
                $api->group(['prefix' => 'channels'], function ($api){
                    $api->get('/', 'ChannelController@index');
                    $api->post('/create', 'ChannelController@store');
                    $api->patch('/{id}', 'ChannelController@update');
                    $api->delete('/{id}', 'ChannelController@destroy');
                });
            });
        });
    });
});
