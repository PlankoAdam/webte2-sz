<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as ResponseObj;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


// Middleware for checking JWT in the request header
// if JWT is valid, adds attribute "user_id" to the request and passes it to the handler method (retrieve like this: $user_id = $request->getAttribute('user_id');)
// else returns 401 with error message to the client
// add this middleware to a route like this:
// $app->get('/', function () { ... })->add(new JWTAuthMiddleware());
class JWTAuthMiddleware
{

    public static $secretKey;

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $authorizationHeader = $request->getHeaderLine('Authorization');
        $jwt = str_replace('Bearer ', '', $authorizationHeader);

        if ($jwt) {
            try {
                $decoded_jwt = JWT::decode($jwt, new Key(self::$secretKey, 'HS256'));
                $decoded_jwt = (array) $decoded_jwt;
                if ($decoded_jwt['expiration'] < time()) {
                    return self::getErrorResponse(401, 'Authentication token is expired');
                }
                $request = $request->withAttribute('user_id', $decoded_jwt['user_id']);
                return $handler->handle($request);
            } catch (UnexpectedValueException $e) {
                return self::getErrorResponse(401, 'Authentication token is invalid');
            }
        } else {
            return self::getErrorResponse(401, 'Authentication token missing');
        }
    }

    public static function getErrorResponse(int $code, string $message): Response
    {
        $response = new ResponseObj();
        $response->getBody()->write(json_encode(['message' => $message]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}