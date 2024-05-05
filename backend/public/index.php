<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Bratislava');


$app = AppFactory::create();

require __DIR__ . '/connection.php';

require __DIR__ . '/users.php';

require __DIR__ . '/answers.php';

require __DIR__ . '/questions.php';

require __DIR__ . '/subjects.php';

$app->run();
