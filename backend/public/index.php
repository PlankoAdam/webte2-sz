<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

function getJsonMessageResponse(Response $response, int $code, string $message) {
    $response->getBody()->write(json_encode(['message' => $message]));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($code);
}

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Bratislava');

$secretKey = $_ENV['SECRET_JWT_KEY'];

require __DIR__ . '/../db/connection.php';
require __DIR__ . '/../middleware/auth_middleware.php';
require __DIR__ . '/../middleware/admin_auth_middleware.php';

JWTAuthMiddleware::$secretKey = $secretKey;


$app = AppFactory::create();

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

require __DIR__ . '/../handlers/users.php';
require __DIR__ . '/../handlers/answers.php';
require __DIR__ . '/../handlers/questions.php';
require __DIR__ . '/../handlers/subjects.php';
require __DIR__ . '/../handlers/account.php';
require __DIR__ . '/../handlers/archive.php';

$app->run();
