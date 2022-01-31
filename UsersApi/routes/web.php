<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function() use ($router) {
    return $router->app->version();
});

// Users endpoint
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', ['uses' => 'Users\UsersController@index']);
        $router->post('/', ['uses' => 'Users\UsersController@store']);
        $router->post('/login', ['uses' => 'Users\UsersController@login']);
        $router->post('/logout', ['uses' => 'Users\UsersController@logout']);
    });
    
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/{userId}', ['uses' => 'Users\UsersController@show']);
        $router->put('/{userId}', ['uses' => 'Users\UsersController@update']);
        $router->patch('/{userId}', ['uses' => 'Users\UsersController@update']);
        $router->delete('/{userId}', ['uses' => 'Users\UsersController@destroy']);
    });
});

//Classes endpoints
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'classes'], function () use ($router) {
        $router->get('/', ['uses' => 'Classes\ClassesController@index']);
    });
});

//Schools endpoints
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'schools'], function () use ($router) {
        $router->get('/', ['uses' => 'Schools\SchoolsController@index']);
    });
});