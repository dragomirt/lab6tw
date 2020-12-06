<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use src\Currency;
use src\CurrencyValue;

// Creeaza instanta aplicatiei
$app = AppFactory::create();

// Rutele
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write($_ENV['DB_LOGIN']);
    return $response;
});

$app->get('/testwrite', function (Request $request, Response $response, $args) use (&$entityManager){

    $currencyValue = new CurrencyValue();
    $currencyValue->setValue(1);
    $currencyValue->setCurrencyId(3);
    $currencyValue->setCreatedAt(new DateTime());
    $currencyValue->setUpdatedAt(new DateTime());
    $entityManager->persist($currencyValue);

    $entityManager->flush();

    $response->getBody()->write('wrote!');
   return $response;
});

$app->get('/testread', function(Request $request, Response $response) use (&$entityManager) {
    $currencyValue = $entityManager->find(CurrencyValue::class, 1);
    $body = $response->getBody();

    if (!$currencyValue) {
        $body->write('No currencyValue found :(');
        return $response;
    }

   $body->write(print_r($currencyValue->getCurrency()->getName(), true));
   return $response;
});

$app->run();