<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

// Creeaza instanta aplicatiei
$app = AppFactory::create();

// Rutele
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write($_ENV['DB_LOGIN']);
    return $response;
});

$app->run();