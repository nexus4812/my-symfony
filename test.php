<?php

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\ServerApi;

$uri = 'mongodb://root:example@mongo:27017/';
// Specify Stable API version 1
$apiVersion = new ServerApi(ServerApi::V1);

// Create a new client and connect to the server
$client = new Client($uri, [], ['serverApi' => $apiVersion]);

try {
    // Send a ping to confirm a successful connection
    $client->selectDatabase('admin')->command(['ping' => 1]);
    var_dump("Pinged your deployment. You successfully connected to MongoDB!");
} catch (Exception $e) {
    var_dump($e->getMessage());
}
