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
    $router->post('/refresh_token', ['uses' => 'AuthController@refreshToken']);

    $router->group(['middleware' => 'tvdb'], function() use($router) {
        $router->get('/shows', ['uses' => 'ShowController@index']);
        $router->get('/shows/{id}', ['uses' => 'ShowController@show']);
        $router->get('/shows/{id}/episodes', ['uses' => 'ShowController@showEpisodes']);

        $router->get('/me/shows', ['uses' => 'UserController@showShows']);
        $router->post('/me/shows', ['uses' => 'UserController@addShow']);
    });
});
