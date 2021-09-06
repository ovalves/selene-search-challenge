<?php
/**
 * @copyright   2019 - Selene
 * @author      Vinicius Oliveira <vinicius_o.a@live.com>
 * @category    Micro Framework
 * @since       2019-01-17
 */

declare(strict_types=1);

require '/var/www/web/app/vendor/autoload.php';
// require __DIR__.'/../app/vendor/autoload.php';

$app = Selene\App\Factory::create('/var/www/web/app/');

$app->route()->middleware([
    // new Selene\Middleware\Handler\Auth
])->group(function () use ($app) {
    $app->route()->get('/users/name', 'UsersController@getUserByName');
    $app->route()->get('/users/username', 'UsersController@getUserByUserName');
    $app->route()->get('/', 'HomeController@index');
});

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

$http = new Server("0.0.0.0", 9501);

$http->on(
    "start",
    function (Server $http) {
        echo "Swoole HTTP server is started.\n";
    }
);

$http->on(
    "request",
    function (Request $request, Response $response) use ($app) {
        $emitted = $app->emit($request);
        $response->end($emitted);
    }
);

$http->start();
