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
//用户登陆
$router->get('/u','User\indexController@login');

$router->post('/uc','User\indexController@uCenter');
//防刷
$router->get('/fangshua','User\indexController@fangshua');
//curl测试
$router->get('/curl1','User\indexController@curl1');
$router->post('/curl1','User\indexController@curl1');

$router->get('/sign2','User\indexController@sign2');
$router->post('/sign2','User\indexController@sign2');

$router->get('/digui/{num}','User\indexController@fbnq');


$router->post('/hb_2','User\indexController@hb_2');
//denglu
$router->post('/reg','User\indexController@reg');