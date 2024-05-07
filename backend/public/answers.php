<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// GET route to retrieve all answers
$app->get('/answer', function (Request $request, Response $response) use ($pdo) {
    $sql = "SELECT * FROM answers";
    $stmt = $pdo->query($sql);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return response as JSON
    $response->getBody()->write(json_encode($answers));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// POST route to create a new answer
$app->post('/answer', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();
    // Decode the JSON data into an associative array
    $data = json_decode($body, true);

    // Automatically set the current date and time
    $data['date_created'] = date('Y-m-d H:i:s');

    $sql = "INSERT INTO answers (code, answer, date_created) VALUES (:code, :answer, :date_created)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':code' => $data['code'],
        ':answer' => $data['answer'],
        ':date_created' => $data['date_created']
    ]);

    // Encode the response data as JSON
    $response->getBody()->write(json_encode(['message' => 'Answer created']));

    // Set the response headers and status code
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// GET route to retrieve all answers with a specific code
$app->get('/answer/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];
    $sql = "SELECT * FROM answers WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':code' => $code]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return response as JSON
    $response->getBody()->write(json_encode($answers));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});