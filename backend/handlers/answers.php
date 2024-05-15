<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// POST route to create a new answer
$app->post('/answer/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];
    $body = $request->getBody()->getContents();
    // Decode the JSON data into an associative array
    $data = json_decode($body, true);

    // Check if the question code exists in the database
    $existingQuestion = getQuestion($pdo, $code);

    // If a question exists, check if the answer already exists for that question
    if ($existingQuestion) {
        $existingAnswer = getAnswer($pdo, $code, $data['answer']);

        // Determine the value of is_correct based on is_open_ended
        $is_correct = $existingQuestion['is_open_ended'] == 1 ? null : (isset($data['is_correct']) ? $data['is_correct'] : 0);

        // If answer exists, update the count; otherwise, insert a new answer
        if ($existingAnswer) {
            incrementAnswerCount($pdo, $code, $data['answer']);
            $responseData = [
                'message' => 'Count incremented for existing answer',
                'question_code' => $code,
                'answer' => $data['answer'],
                'is_correct' => $existingAnswer['is_correct'],
                'count' => $existingAnswer['count'] + 1 // Increment the count in the response
            ];
        } else {
            $sql = "INSERT INTO answers (question_code, answer, is_correct, count) 
                    VALUES (:question_code, :answer, :is_correct, 1)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':question_code' => $code,
                ':answer' => $data['answer'],
                ':is_correct' => $is_correct
            ]);

            $responseData = [
                'message' => 'New answer created',
                'question_code' => $code,
                'answer' => $data['answer'],
                'is_correct' => $is_correct,
                'count' => 1
            ];
        }

        // Encode the response data as JSON
        $response->getBody()->write(json_encode($responseData));

        // Set the response headers and status code
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } else {
        // Return an error response if the question code doesn't exist
        $errorData = ['error' => 'Question code not found'];
        $response->getBody()->write(json_encode($errorData));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
    }
});

// Function to check if a question exists in the database
function getQuestion($pdo, $question_code)
{
    $sql = "SELECT * FROM questions WHERE code = :question_code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':question_code' => $question_code]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);
    return $question;
}

// Function to check if an answer exists for a question in the database
function getAnswer($pdo, $question_code, $answer)
{
    $sql = "SELECT * FROM answers WHERE question_code = :question_code AND answer = :answer";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':question_code' => $question_code, ':answer' => $answer]);
    $existingAnswer = $stmt->fetch(PDO::FETCH_ASSOC);
    return $existingAnswer;
}

// Function to increment the count of an existing answer
function incrementAnswerCount($pdo, $question_code, $answer)
{
    $sql = "UPDATE answers SET count = count + 1 WHERE question_code = :question_code AND answer = :answer";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':question_code' => $question_code, ':answer' => $answer]);
}

// GET route to retrieve all answers with a specific code
$app->get('/answer/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];
    $sql = "SELECT * FROM answers WHERE question_code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':code' => $code]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert the "question_code" field to string
    foreach ($answers as &$answer) {
        $answer['question_code'] = (string) $answer['question_code'];
    }

    // Return response as JSON
    $response->getBody()->write(json_encode($answers));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});
