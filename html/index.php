<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Siler\Route;

Route\get('/', function (array $routeParams) {
    echo 'Hello '.($routeParams['name'] ?? 'World');
});
