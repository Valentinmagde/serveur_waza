<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
/**
 * Get the lumen version
 */
$router->get('/', function() use ($router) {
    return $router->app->version();
});

/**
 * All passport auth endpoint
 */
$router->group(['middleware' => 'cors'], function () use ($router) {
    //All the routes you want to allow CORS for
    $router->group(['prefix' => 'api'], function () use ($router) {
        $router->group(['prefix' => 'auth'], function () use ($router) {
            $router->post('/login', ['uses' => 'Auth\AuthController@login']);
            $router->group(['middleware' => ['client.credentials']], function () use ($router) {
                $router->post('/refresh', ['uses' => 'Auth\AuthController@refreshToken']);
                $router->post('/logout', ['uses' => 'Auth\AuthController@logout']);
            });
        });
    });
  
    /**
     * All users endpoint
     */
    $router->group(['prefix' => 'api'], function () use ($router) {

        $router->group(['prefix' => 'users'], function () use ($router) {
            $router->post('/', ['uses' => 'Users\UsersController@store']);
        });

        $router->group(['middleware' => ['client.credentials']], function () use ($router) {

            $router->group(['prefix' => 'users'], function () use ($router) {
                $router->get('/', ['uses' => 'Users\UsersController@index']);
            });
            
            $router->group(['prefix' => 'user'], function () use ($router) {
                $router->get('/{userId}', ['uses' => 'Users\UsersController@show']);
                $router->put('/{userId}', ['uses' => 'Users\UsersController@update']);
                $router->patch('/{userId}', ['uses' => 'Users\UsersController@update']);
                $router->delete('/{userId}', ['uses' => 'Users\UsersController@destroy']);
            });
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

    /**
     * All courses endpoint
     */
    $router->group(['prefix' => 'api'], function () use ($router) {
        $router->group(['middleware' => ['client.credentials']], function () use ($router) {

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
    });

    $router->options('/{any:.*}', function (Request $req) {
      return;
    });
});


