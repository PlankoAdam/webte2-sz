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

    // Check if the code already exists in the database
    $existingDate = getCodeDate($pdo, $data['code']);

    // If a date exists for the code, use it; otherwise, generate a new date
    $data['date_created'] = $existingDate ? $existingDate : date('Y-m-d H:i:s');

    $sql = "INSERT INTO answers (question_code, answer, date_created) VALUES (:code, :answer, :date_created)";
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

// Function to get the date associated with a code from the database
function getCodeDate($pdo, $code) {
    $sql = "SELECT date_created FROM answers WHERE question_code = :code LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':code' => $code]);
    $result = $stmt->fetchColumn();
    return $result ? $result : null;
}

// GET route to retrieve all answers with a specific code
$app->get('/answer/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];
    $sql = "SELECT * FROM answers WHERE question_code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':code' => $code]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return response as JSON
    $response->getBody()->write(json_encode($answers));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});
