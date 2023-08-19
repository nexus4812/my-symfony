<?php

namespace App\Controller\Mongo;

use App\Controller\ControllerInterface;
use Exception;
use MongoDB\Client;
use Swoole\Http\Request;
use Swoole\Http\Response;

readonly class ShowController implements ControllerInterface
{
    public function __construct(private Client $client)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            // Send a ping to confirm a successful connection
            $collection = $this->client->selectDatabase('local')->selectCollection('pool');
            $collection->aggregate([]);
        } catch (Exception $e) {
            $response->write($e->getMessage());
        }

        $response->write('write your request');
        return $response;
    }
}
