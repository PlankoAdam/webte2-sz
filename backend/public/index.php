<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Database connection parameters
$host = 'mysql'; // Docker service name
$username = 'root';
$password = 'root';
$database = 'test';
$port = '3306';

// Create PDO connection
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create Slim app instance
$app = AppFactory::create();

// Define route to fetch all persons
$app->get('/persons', function (Request $request, Response $response, $args) use ($pdo) {
    $sql = "SELECT * FROM person";
    $stmt = $pdo->query($sql);
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return response as JSON
    $response->getBody()->write(json_encode($persons));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// Run Slim app
$app->run();
