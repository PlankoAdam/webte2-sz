<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// GET route to retrieve all subjects
$app->get('/subject', function (Request $request, Response $response) use ($pdo) {
    $sql = "SELECT * FROM subjects";
    $stmt = $pdo->query($sql);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return response as JSON
    $response->getBody()->write(json_encode($subjects));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});