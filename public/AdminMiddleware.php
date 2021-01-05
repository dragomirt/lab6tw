<?php
namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AdminMiddleware implements \Psr\Http\Server\MiddlewareInterface
{

    public function process(Request $request, RequestHandler $handler): Response
    {
        $authorization = $request->getHeader("Authorization");
        $checkCredentials = "Basic " . base64_encode($_ENV['ADMIN_LOGIN'] . ":" . $_ENV['ADMIN_PASSWORD']);

        $nullResponse = new \Slim\Psr7\Response();
        $nullResponse->getBody()->write(json_encode([]));

        if (count($authorization) === 0) {
            return $nullResponse;
        }

        if ($authorization[0] === $checkCredentials) {
            return $handler->handle($request);
        }

        return $nullResponse;
    }
}