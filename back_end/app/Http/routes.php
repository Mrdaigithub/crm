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

        // login
        $api->group(['middleware' => ['log']], function ($api) {
            $api->post('/login', 'TokenController@login');
        });

        $api->group(['middleware' => ['jwt.auth']], function ($api) {

            // logout
            $api->group(['middleware' => ['log']], function ($api) {
                $api->get('/logout', 'TokenController@logout');
            });

            // menus
            $api->group(['prefix' => 'menus'], function ($api) {
                $api->get('/', 'MenuController@index');
                $api->post('/', 'MenuController@store');
            });

            // ranks
            $api->group(['prefix' => 'ranks'], function ($api) {
                $api->get('/{type}', 'RankController@show');
            });

            // patients
            $api->group(['prefix' => 'patients'], function ($api) {
                $api->get('/', 'PatientController@index');
                $api->get('/{name}', 'PatientController@show');
                $api->post('/', 'PatientController@store');
                $api->patch('/{id}', 'PatientController@update');
                $api->delete('/{id}', 'PatientController@destroy');
            });

            // roles
            $api->group(['prefix' => 'roles'], function ($api) {
                $api->get('/', 'RoleController@index');
                $api->get('/{name}/create', 'RoleController@create');
                $api->patch('/{id}', 'RoleController@update');
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

            // permissions (待重构)
            $api->group(['prefix' => 'permissions'], function ($api) {
                $api->get('/{id}', 'PermissionController@show');
                $api->put('/{id}', 'PermissionController@update');
            });

            // Management
            $api->group(['prefix' => 'management', 'namespace' => 'Management'], function ($api) {

                // diseases
                $api->group(['prefix' => 'diseases'], function ($api) {
                    $api->get('/', 'DiseaseController@index');
                    $api->get('/create', 'DiseaseController@create'); // (test)
                    $api->get('/{pid}/{name}', 'DiseaseController@store');
                    $api->patch('/{id}', 'DiseaseController@update');
                    $api->delete('/{id}', 'DiseaseController@destroy');
                });

                // doctors
                $api->group(['prefix' => 'doctors'], function ($api) {
                    $api->get('/', 'DoctorsController@index');
                    $api->get('/create/{name}', 'DoctorsController@create');
                    $api->patch('/{id}', 'DoctorsController@update');
                    $api->delete('/{id}', 'DoctorsController@destroy');
                });

                // channels
                $api->group(['prefix' => 'channels'], function ($api) {
                    $api->get('/', 'ChannelController@index');
                    $api->post('/', 'ChannelController@store');
                    $api->patch('/{id}', 'ChannelController@update');
                    $api->delete('/{id}', 'ChannelController@destroy');
                });

                // advisories
                $api->group(['prefix' => 'advisories'], function ($api) {
                    $api->get('/', 'AdvisoryController@index');
                    $api->get('/create/{name}', 'AdvisoryController@create');
                    $api->patch('/{id}', 'AdvisoryController@update');
                    $api->delete('/{id}', 'AdvisoryController@destroy');
                });
            });

            // Data
            $api->group(['prefix' => 'data', 'namespace' => 'Data'], function ($api) {

                $api->get('/total/year', 'TotalController@show_by_year');
                $api->get('/total/month', 'TotalController@show_by_month');
                $api->get('/users', 'UsersController@index');
                $api->get('/channels', 'ChannelsController@index');
                $api->get('/doctors', 'DoctorsController@index');
                $api->get('/patients', 'PatientsController@index');
                $api->get('/diseases', 'DiseasesController@index');
            });

            // logs
            $api->group(['prefix' => 'log'], function ($api) {
                $api->get('/', 'LogsController@index');
            });
        });

        // export
        $api->group(['prefix' => 'export'], function ($api) {
            $api->get('/', 'ExportController@index');
        });
    });
});
