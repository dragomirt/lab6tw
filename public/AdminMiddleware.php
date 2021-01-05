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

        if ($authorization === $checkCredentials) {
            $response = $handler->handle($request);
            return $response;
        }
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([]));
        return $response;
    }
}