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

//Courses endpoints
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'courses'], function () use ($router) {
        $router->get('/', ['uses' => 'Course\CourseController@index']);
        $router->post('/', ['uses' => 'Course\CourseController@store']);
    });
    
    $router->group(['prefix' => 'course'], function () use ($router) {
        $router->get('/{courseId}', ['uses' => 'Course\CourseController@show']);
        $router->put('/{courseId}', ['uses' => 'Course\CourseController@update']);
        $router->patch('/{courseId}', ['uses' => 'Course\CourseController@update']);
        $router->delete('/{courseId}', ['uses' => 'Course\CourseController@destroy']);
    });
});

//Overviews endpoints
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'overviews'], function () use ($router) {
        $router->get('/', ['uses' => 'Overview\OverviewController@index']);
        $router->post('/', ['uses' => 'Overview\OverviewController@store']);
    });
    
    $router->group(['prefix' => 'overview'], function () use ($router) {
        $router->get('/{overviewId}', ['uses' => 'Overview\OverviewController@show']);
        $router->put('/{overviewId}', ['uses' => 'Overview\OverviewController@update']);
        $router->patch('/{overviewId}', ['uses' => 'Overview\OverviewController@update']);
        $router->delete('/{overviewId}', ['uses' => 'Overview\OverviewController@destroy']);
    });
});

//Sommaries endpoints
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'sommaries'], function () use ($router) {
        $router->get('/', ['uses' => 'Sommary\SommaryController@index']);
        $router->post('/', ['uses' => 'Sommary\SommaryController@store']);
    });
    
    $router->group(['prefix' => 'sommary'], function () use ($router) {
        $router->get('/{sommaryId}', ['uses' => 'Sommary\SommaryController@show']);
        $router->put('/{sommaryId}', ['uses' => 'Sommary\SommaryController@update']);
        $router->patch('/{sommaryId}', ['uses' => 'Sommary\SommaryController@update']);
        $router->delete('/{sommaryId}', ['uses' => 'Sommary\SommaryController@destroy']);
    });
});

/**
 * All overviews endpoint
 */
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'overviews'], function () use ($router) {
        $router->get('/', ['uses' => 'Overview\OverviewController@index']);
        $router->post('/', ['uses' => 'Overview\OverviewController@store']);
    });
    
    $router->group(['prefix' => 'overview'], function () use ($router) {
        $router->get('/{overviewId}', ['uses' => 'Overview\OverviewController@show']);
        $router->put('/{overviewId}', ['uses' => 'Overview\OverviewController@update']);
        $router->patch('/{overviewId}', ['uses' => 'Overview\OverviewController@update']);
        $router->delete('/{overviewId}', ['uses' => 'Overview\OverviewController@destroy']);
    });
});