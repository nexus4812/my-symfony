<?php

namespace App\Controller;

use MongoDB\Client;
use Swoole\Http\Request;
use Swoole\Http\Response;

readonly class TopController implements ControllerInterface
{
    public function __construct(private Client $client)
    {
    }


    public function __invoke(Request $request, Response $response): Response
    {
        $response->write('Hi');
        return $response;
    }
}
