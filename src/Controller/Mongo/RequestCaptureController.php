<?php

namespace App\Controller\Mongo;

use App\Controller\ControllerInterface;
use Exception;
use MongoDB\Client;
use Swoole\Http\Request;
use Swoole\Http\Response;

readonly class RequestCaptureController implements ControllerInterface
{
    public function __construct(private Client $client)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $db = $this->client->selectDatabase('local');
            $collection = $db->selectCollection('pool');

            $collection->insertOne([
                'post' => $request->post,
                'get' => $request->get,
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            $response->write($e->getMessage());
        }

        $response->write('Wrote your requests');
        return $response;
    }
}
