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

$router->get('/users', 'User\UserController@index');
$router->post('/users', 'User\UserController@store');
$router->get('/user/{userId}', 'User\UserController@show');
$router->put('/user/{userId}', 'User\UserController@update');
$router->patch('/user/{userId}', 'User\UserController@update');
$router->delete('/user/{userId}', 'User\UserController@destroy');
