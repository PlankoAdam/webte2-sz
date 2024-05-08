<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Bratislava');

$secretKey = $_ENV['SECRET_JWT_KEY'];

require __DIR__ . '/../db/connection.php';
require __DIR__ . '/../middleware/auth_middleware.php';

JWTAuthMiddleware::$secretKey = $secretKey;


$app = AppFactory::create();

require __DIR__ . '/../handlers/users.php';
require __DIR__ . '/../handlers/answers.php';
require __DIR__ . '/../handlers/questions.php';
require __DIR__ . '/../handlers/subjects.php';
require __DIR__ . '/../handlers/authentication.php';

$app->run();
