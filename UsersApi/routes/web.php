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

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', ['uses' => 'User\UserController@index']);
        $router->post('/', ['uses' => 'User\UserController@store']);
        $router->post('/login', ['uses' => 'User\UserController@login']);
        $router->post('/logout', ['uses' => 'User\UserController@logout']);
    });
    
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/{userId}', ['uses' => 'User\UserController@show']);
        $router->put('/{userId}', ['uses' => 'User\UserController@update']);
        $router->patch('/{userId}', ['uses' => 'User\UserController@update']);
        $router->delete('/{userId}', ['uses' => 'User\UserController@destroy']);
    });
});
