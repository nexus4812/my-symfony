<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Container\Container;
use App\Controller\ControllerInterface;
use App\Controller\Mongo\PingController;
use App\Controller\Mongo\RequestCaptureController;
use App\Controller\TopController;
use Siler\Swoole;
use Swoole\Http\Request;
use Swoole\Http\Response;

error_reporting(1); // for testing

$container = Container::getContainer();

$handler = function (Request $request, Response $response) use ($container): void {
    // create http handler
    $res = function (string $controllerName) use ($container, $request, $response): callable {
        /** @var ControllerInterface $controller */
        $controller = $container->get($controllerName);

        return function () use ($request, $response, $controller): void {
            $controller->__invoke($request, $response);
            $response->end();
        };
    };

    // set routing
    Siler\Route\get('/foo', $res(TopController::class));
    Siler\Route\get('/mongo/ping', $res(PingController::class));
    Siler\Route\get('/mongo/sandbox', $res(RequestCaptureController::class));
    Swoole\emit('Not found', 404);
};

Swoole\http($handler, 9502)->start();
