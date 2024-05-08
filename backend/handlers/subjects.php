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

// GET route to retrieve a subject by ID
$app->get('/subject/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];

    $sql = "SELECT * FROM subjects WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $subject = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$subject) {
        // If subject with given ID is not found, return 404 Not Found
        $response->getBody()->write(json_encode(["error" => "Subject not found"]));
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }

    // Return response as JSON
    $response->getBody()->write(json_encode($subject));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});