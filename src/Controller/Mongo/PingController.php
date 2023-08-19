<?php

namespace App\Controller\Mongo;

use App\Controller\ControllerInterface;
use Exception;
use MongoDB\Client;
use Swoole\Http\Request;
use Swoole\Http\Response;

readonly class PingController implements ControllerInterface
{
    public function __construct(private Client $client)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            // Send a ping to confirm a successful connection
            $this->client->selectDatabase('local')->command(['ping' => 1]);
            $response->write("Pinged your deployment. You successfully connected to MongoDB!");
        } catch (Exception $e) {
            $response->write($e->getMessage());
        }

        return $response;
    }
}
