<?php
/**
 * @copyright   2019 - Selene
 * @author      Vinicius Oliveira <vinicius_o.a@live.com>
 * @category    Micro Framework
 * @since       2019-01-17
 */
require __DIR__.'/../vendor/autoload.php';

$app = Selene\App\Factory::create();

$app->route()->middleware([
//    new Selene\Middleware\Handler\Auth
])->group(function () use ($app) {
    $app->route()->get('/users/name', 'UsersController@getUserByName');
    $app->route()->get('/users/username', 'UsersController@getUserByUserName');
    $app->route()->get('/', 'HomeController@index');
})->run();
