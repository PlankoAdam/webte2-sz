<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// GET route to retrieve all questions
$app->get('/question', function (Request $request, Response $response) use ($pdo) {
    $sql = "SELECT * FROM questions";
    $stmt = $pdo->query($sql);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return response as JSON
    $response->getBody()->write(json_encode($questions));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// DELETE route to delete a question by ID
$app->delete('/question/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $sql = "DELETE FROM questions WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    $response->getBody()->write(json_encode(['message' => 'question deleted']));

    // Set the response headers and status code
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// POST route to create a new question
$app->post('/question', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();

    // Decode the JSON data into an associative array
    $data = json_decode($body, true);


    // Set current time as date_start
    $date_start = date('Y-m-d H:i:s');

    // Set dummy value for date_end
    $date_end = '9999-12-31 23:59:59';

    // Insert new question into the database
    $sql = "INSERT INTO questions (code, subject_id, user_id, question, date_start, date_end) 
            VALUES (:code, :subject_id, :user_id, :question, :date_start, :date_end)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':code' => $data['code'],
        ':subject_id' => $data['subject_id'],
        ':user_id' => $data['user_id'],
        ':question' => $data['question'],
        ':date_start' => $date_start,
        ':date_end' => $date_end
    ]);

    // Return success message
    $response->getBody()->write(json_encode(['message' => 'Question created']));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


// PUT route to update the date_end of a question by ID
$app->put('/question/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];

    // Set current time as date_end
    $date_end = date('Y-m-d H:i:s');

    // Update the date_end of the question in the database
    $sql = "UPDATE questions SET date_end = :date_end WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':date_end' => $date_end,
        ':id' => $id
    ]);


    // Return success message
    $response->getBody()->write(json_encode(['message' => 'date_end updated!']));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});