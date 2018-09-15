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

$router->post('/signup', ['uses' => 'UserController@create']);
$router->post('/login', ['uses' => 'AuthController@authenticate']);

$router->group(['middleware' => 'jwt.auth'], function() use($router) {
    $router->get('/me', ['uses' => 'UserController@me']);

    $router->group(['middleware' => 'tvdb'], function() use($router) {
        $router->get('/shows', ['uses' => 'ShowController@index']);
    });
});
