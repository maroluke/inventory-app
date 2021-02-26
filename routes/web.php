<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api'
], function () use ($router) {

    $router->group([
        'prefix' => 'auth'
    ], function () use ($router) {
    
        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('me', 'AuthController@me');
        
    });

    $router->get('/tag', 'TagController@index');
    $router->get('/tag/{id}', 'TagController@show');

    $router->get('/inventoryitem', 'InventoryItemController@index');
    $router->get('/inventoryitem/{id}', 'InventoryItemController@show');

    $router->get('/book', 'BookController@index');
    $router->get('/book/{id}', 'BookController@show');

    $router->get('/location', 'LocationController@index');
    $router->get('/location/{id}', 'LocationController@show');

});


$router->group([
    'middleware' => 'auth',
    'prefix' => 'api'
], function () use ($router) {
    $router->post('/tag', 'TagController@store');
    $router->patch('/tag/{id}', 'TagController@update');
    $router->delete('/tag/{id}', 'TagController@destroy');

    $router->post('/inventoryitem', 'InventoryItemController@store');
    $router->patch('/inventoryitem/{id}', 'InventoryItemController@update');
    $router->delete('/inventoryitem/{id}', 'InventoryItemController@destroy');
    
    $router->post('/book', 'BookController@store');
    $router->patch('/book/{id}', 'BookController@update');
    $router->delete('/book/{id}', 'BookController@destroy');

    $router->post('/location', 'LocationController@store');
    $router->patch('/location/{id}', 'LocationController@update');
    $router->delete('/location/{id}', 'LocationController@destroy');
});