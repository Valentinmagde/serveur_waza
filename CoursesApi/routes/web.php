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

$router->get('/courses', 'Course\CourseController@index');
$router->post('/courses', 'Course\CourseController@store');
$router->get('/course/{courseId}', 'Course\CourseController@show');
$router->put('/course/{courseId}', 'Course\CourseController@update');
$router->patch('/course/{courseId}', 'Course\CourseController@update');
$router->delete('/course/{courseId}', 'Course\CourseController@destroy');
