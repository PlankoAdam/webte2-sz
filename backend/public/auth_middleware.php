<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


// Middleware for checking JWT in the request header
// if JWT is valid, adds attribute "user_id" to the request and passes it to the handler method
// else returns 401 with error message to the client
class JWTAuthMiddleware
{

    public static $secretKey;

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $authorizationHeader = $request->getHeaderLine('Authorization');
        $jwt = str_replace('Bearer ', '', $authorizationHeader);

        if ($jwt) {
            try {
                $decoded_jwt = JWT::decode($jwt, new Key($this->secretKey, 'HS256'));
                if ($decoded_jwt['expiration'] < time()) {
                    return $this->getErrorResponse(401, 'Authentication token is expired');
                }
                $request = $request->withAttribute('user_id', $decoded_jwt['user_id']);
                return $handler->handle($request);
            } catch (\Exception $e) {
                return $this->getErrorResponse(401, 'Authentication token is invalid');
            }
        } else {
            return $this->getErrorResponse(401, 'Authentication token missing');
        }
    }

    function getErrorResponse(int $code, string $message) {
        $response = new Response();
        $response->getBody()->write(json_encode(['message' => $message]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}