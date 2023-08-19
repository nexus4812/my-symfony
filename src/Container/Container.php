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
    private static array $container = [];

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
    private static function set(string $id, object $object)
    {
        self::$container[$id] = $object;
    }

    /**
     * @param class-string<T> $id
     * @return T
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            return self::$container[$id];
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
        return array_key_exists($id, self::$container);
    }

    public static function createContainer(): self
    {
        $client = self::createMongoClient();
        self::set(Client::class, $client);
        self::set(TopController::class, new TopController($client));
        self::set(PingController::class, new PingController($client));
        self::set(RequestCaptureController::class, new RequestCaptureController($client));
        return new self();
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
