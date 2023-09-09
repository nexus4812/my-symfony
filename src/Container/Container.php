<?php

namespace App\Container;

use App\Controller\Mongo\PingController;
use App\Controller\Mongo\RequestCaptureController;
use App\Controller\TopController;
use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use Psr\Container\ContainerInterface;

/**
 * @template T of object
 */
class Container implements ContainerInterface
{
    /**
     * @var array<class-string, object>
     */
    private array $dependencies = [];

    /**
     * @deprecated use createContainer method
     */
    private function __construct()
    {
    }

    /**
     * @param class-string<T> $id
     * @param T $object
     * @return void
     */
    private function set(string $id, object $object)
    {
        $this->dependencies[$id] = $object;
    }

    /**
     * @param class-string<T> $id
     * @return T
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->dependencies[$id];
        }

        // TODO use NotFoundExceptionInterface
        throw new \LogicException();
    }

    /**
     * @param class-string<T> $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->dependencies);
    }

    public static function getContainer(): self
    {
        $container = new self();
        $client = self::createMongoClient();
        $container->set(Client::class, $client);
        $container->set(TopController::class, new TopController());
        $container->set(PingController::class, new PingController($client));
        $container->set(RequestCaptureController::class, new RequestCaptureController($client));

        return $container;
    }

    private static function createMongoClient(): Client
    {
        // Replace the placeholder with your Atlas connection string
        $uri = 'mongodb://root:example@mongo:27017';
        // Specify Stable API version 1
        $apiVersion = new ServerApi(ServerApi::V1);

        // Create a new client and connect to the server
        return new Client($uri, [], ['serverApi' => $apiVersion]);
    }
}
