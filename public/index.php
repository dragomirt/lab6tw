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

$app->group('/api', function (\Slim\Routing\RouteCollectorProxy $group) use (&$entityManager) {

    $group->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write('CURRENCY API WORKS! :)');
        return $response;
    });

//Currency Manipulation
//------
// Get all currencies
    $group->get('/currency', function(Request $request, Response $response) use (&$entityManager) {
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
    $group->post('/currency/add', function(Request $request, Response $response) use (&$entityManager) {
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

//    Edit currency
    $group->post('/currency/edit', function(Request $request, Response $response) use (&$entityManager) {
        $data = $request->getParsedBody();
        try {
            $id = $data['id'];

            if ($id === null) {
                $response->getBody()->write(json_encode([]));
                return $response;
            }

            $currency = $entityManager->getRepository(Currency::class)->find($id);
            if ($currency === null) {
                $response->getBody()->write(json_encode([]));
                return $response;
            }

            $name = $data['name'];
            $fullName = $data['full_name'];
            $symbol = $data['symbol'];

            $currency->setName($name);
            $currency->setFullName($fullName);
            $currency->setSymbol($symbol);
            $entityManager->flush();

            $response->getBody()->write(json_encode($currency->getId()));
            return $response;

        } catch (Exception $e) {
            $response->getBody()->write(print_r($e, true));
            return $response;
        }
    });

// Get all values
    $group->get('/currency/value', function(Request $request, Response $response) use (&$entityManager) {
        $values = $entityManager->getRepository(CurrencyValue::class)->findBy([], ['created_at' => 'DESC']);
        if ($values === null) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $responseFormatted = array();
        foreach ($values as $value) {
            $responseFormatted[$value->getCurrency()->getId()][] = array(
                'value' => $value->getValue(),
                'date' => $value->getCreatedAt()
            );
        }

        $response->getBody()->write(json_encode($responseFormatted));
        return $response;
    });

// Get data about one currency field
    $group->get('/currency/{id}', function(Request $request, Response $response, array $args) use (&$entityManager) {
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

    $group->get('/currency/value/{id}', function(Request $request, Response $response, array $args) use (&$entityManager) {
        $id = $args['id'];

        if ($id === null) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $currencyValues = $entityManager->getRepository(CurrencyValue::class)->findBy(["currency" => $id], ['created_at' => "DESC"]);
        if ($currencyValues === null) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }
        $valuesData = array();

        foreach ($currencyValues as $value) {
            $valuesData[] = array(
                'value' => $value->getValue(),
                'date' => $value->getCreatedAt()
            );
        }

        $response->getBody()->write(json_encode($valuesData));
        return $response;
    });

    $group->delete('/currency/value/{id}', function(Request $request, Response $response, array $args) use (&$entityManager) {
        $id = $args['id'];

        if ($id === null) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $currencyValue = $entityManager->getRepository(CurrencyValue::class)->find($id);
        if ($currencyValue === null) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $currencyValueId = $currencyValue->getId();

        $entityManager->remove($currencyValue);
        $entityManager->flush();

        $response->getBody()->write(json_encode($currencyValueId));
        return $response;
    });

// Remove currency row
    $group->delete('/currency/{id}', function(Request $request, Response $response, array $args) use (&$entityManager) {
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

        $currencyValues = $currency->getValues();
        foreach ($currencyValues as $value) {
            $entityManager->remove($value);
        }

        $entityManager->flush();

        $currencyId = $currency->getId();

        $entityManager->remove($currency);
        $entityManager->flush();

        $response->getBody()->write(json_encode($currencyId));
        return $response;
    });

// Set currency value
    $group->post('/currency/value/add', function(Request $request, Response $response) use (&$entityManager) {
        $data = $request->getParsedBody();
        try {
            $currency_id = $data['currency_id'];
            $value = $data['value'];
            $created_at = isset($data['created_at']) ? new DateTime($data['created_at']) : new DateTime();

            $currency = $entityManager->getRepository(Currency::class)->find($currency_id);

            if ($currency === null) {
                $response->getBody()->write(json_encode([]));
                return $response;
            }

            $currencyValue = new CurrencyValue();
            $currencyValue->setCurrency($currency);
            $currencyValue->setValue((float) $value);
            $currencyValue->setCreatedAt($created_at);
            $currencyValue->setUpdatedAt(new DateTime());
            $entityManager->persist($currencyValue);
            $entityManager->flush();

            $response->getBody()->write(json_encode($currencyValue->getId()));
            return $response;

        } catch (Exception $e) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }
    });

    $group->get('/currency/value/{start_date}/{final_date}', function(Request $request, Response $response, array $args) use (&$entityManager) {
        $start_date_raw = $args['start_date'];
        $final_date_raw = $args['final_date'];

        if (!($start_date_raw && $final_date_raw)) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $start_date = new DateTime($start_date_raw);
        $final_date = new DateTime($final_date_raw);

        $values = $entityManager->getRepository(CurrencyValue::class)->getByDate($start_date, $final_date);
        if ($values === null) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $rowValues = array();
        foreach ($values as $value) {
            $currency = $value->getCurrency();
            array_push($rowValues, array(
                'id' => $value->getId(),
                'currency_id' => $currency->getId(),
                'name' => $currency->getName(),
                'full_name' => $currency->getFullName(),
                'symbol' => $currency->getSymbol(),
                'value' => $value->getValue(),
                'date' => $value->getCreatedAt()
            ));
        }

        $response->getBody()->write(json_encode($rowValues));
        return $response;
    });
});

$app->get('/', function (Request $request, Response $response, $args) {
    $file = '../views/index.html';
    if (file_exists($file)) {
        $response->getBody()->write(file_get_contents($file));
        return $response;
    }

    throw new \Slim\Exception\HttpNotFoundException($request, $response);
});

$app->get('/admin', function (Request $request, Response $response, $args) {
    $file = '../views/admin.html';
    if (file_exists($file)) {
        $response->getBody()->write(file_get_contents($file));
        return $response;
    }

    throw new \Slim\Exception\HttpNotFoundException($request, $response);
});

$app->run();