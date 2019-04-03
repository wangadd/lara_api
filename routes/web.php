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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/user','User\UserController@test');
$router->post('/user/login','User\UserController@userLogin');
$router->get('/user/vip','User\UserController@vip');
$router->get('/user/order','User\UserController@order');


$router->get('/user/encryption','User\UserController@encryption');
$router->post('/user/sign','User\SignController@sign');
$router->post('/curl','User\Curl@curl');

//考试
$router->post('/kaoshi','User\UserController@userLogin');
