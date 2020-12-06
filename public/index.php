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
    $response->getBody()->write('CURRENCY API WORKS! :)');
    return $response;
});

//Currency Manipulation
//------
// Get all currencies
$app->get('/currency', function(Request $request, Response $response) use (&$entityManager) {
    $allCurrencies = $entityManager->getRepository(Currency::class)->findAll();
    if ($allCurrencies === null) {
        $response->getBody()->write(json_encode([]));
        return $response;
    }

    $currenciesData = array();

    foreach($allCurrencies as $currency) {
        array_push($currenciesData, array(
           'id' => $currency->getId(),
            'name' => $currency->getName(),
            'full_name' => $currency->getFullName(),
            'symbol' => $currency->getSymbol()
        ));
    }

    $response->getBody()->write(json_encode($currenciesData));
    return $response;
});

// Add new currency
$app->post('/currency/add', function(Request $request, Response $response) use (&$entityManager) {
    $data = $request->getParsedBody();
    try {
        $name = $data['name'];
        $fullName = $data['full_name'];
        $symbol = $data['symbol'];

        $newCurrency = new Currency();
        $newCurrency->setName($name);
        $newCurrency->setFullName($fullName);
        $newCurrency->setSymbol($symbol);
        $entityManager->persist($newCurrency);
        $entityManager->flush();

        $response->getBody()->write(json_encode($newCurrency->getId()));
        return $response;

    } catch (Exception $e) {
        $response->getBody()->write(print_r($e, true));
        return $response;
    }
});

$app->get('/currency/{id}', function(Request $request, Response $response, array $args) use (&$entityManager) {
    $id = $args['id'];

    if ($id === null) {
        $response->getBody()->write(json_encode([]));
        return $response;
    }

    $currency = $entityManager->getRepository(Currency::class)->find($id);
    if ($currency === null) {
        $response->getBody()->write(json_encode([]));
        return $response;
    }

    $currencyData = array(
      'name' => $currency->getName(),
        'full_name' => $currency->getFullName(),
        'symbol' => $currency->getSymbol()
    );

    $response->getBody()->write(json_encode($currencyData));
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