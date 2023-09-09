<?php

namespace App\Controller;

use Swoole\Http\Request;
use Swoole\Http\Response;

readonly class TopController implements ControllerInterface
{
    public function __invoke(Request $request, Response $response): Response
    {
        $response->write('Hi');
        return $response;
    }
}
