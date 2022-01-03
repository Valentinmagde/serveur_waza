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

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'courses'], function () use ($router) {
        $router->get('/', ['uses' => 'Course\CourseController@index']);
        $router->post('/', ['uses' => 'Course\CourseController@store']);
    });
    
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/{courseId}', ['uses' => 'Course\CourseController@show']);
        $router->put('/{courseId}', ['uses' => 'Course\CourseController@update']);
        $router->patch('/{courseId}', ['uses' => 'Course\CourseController@update']);
        $router->delete('/{courseId}', ['uses' => 'Course\CourseController@destroy']);
    });
});