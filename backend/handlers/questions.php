<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// GET route to retrieve all questions
$app->get('/question', function (Request $request, Response $response) use ($pdo) {
    // Retrieve user ID from the JWT token
    $userId = $request->getAttribute('user_id');;
    
    // Retrieve user's admin status from the database
    $stmt = $pdo->prepare("SELECT admin FROM users WHERE id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $adminStatus = $stmt->fetchColumn();

    // If the user is not an admin, retrieve questions filtered by user_id
    if ($adminStatus == 0) {
        $sql = "SELECT * FROM questions WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
    } else {
        // If the user is an admin, retrieve all questions
        $sql = "SELECT * FROM questions";
        $stmt = $pdo->query($sql);
    }

    // Fetch the questions
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

       // Convert the "code" field to string
       foreach ($questions as &$question) {
        $question['code'] = (string)$question['code'];
    }

    // Return response as JSON
    $response->getBody()->write(json_encode($questions));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
})->add(new JWTAuthMiddleware());

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
})->add(new JWTAuthMiddleware()); 


// POST route to create a new question
$app->post('/question', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();

    // Decode the JSON data into an associative array
    $data = json_decode($body, true);

    // Set current time as date_created
    $date_created = date('Y-m-d H:i:s');

    // Generate a unique 5-character code
    $code = generateUniqueCode($pdo);

    // Determine the value of is_open_ended based on the presence of answers
    $is_open_ended = empty($data['answers']) ? 1 : 0;

    // Insert new question into the database
    $sqlQuestion = "INSERT INTO questions (code, subject_id, user_id, question, date_created, is_open_ended) 
                    VALUES (:code, :subject_id, :user_id, :question, :date_created, :is_open_ended)";
    $stmtQuestion = $pdo->prepare($sqlQuestion);
    $stmtQuestion->execute([
        ':code' => $code,
        ':subject_id' => $data['subject_id'],
        ':user_id' => $data['user_id'],
        ':question' => $data['question'],
        ':date_created' => $date_created,
        ':is_open_ended' => $is_open_ended
    ]);

    // Get the ID of the newly inserted question
    $newQuestionId = $pdo->lastInsertId();

    // Insert answers into the answers table if available
    $insertedAnswers = [];
    if (!empty($data['answers'])) {
        foreach ($data['answers'] as $answer) {
            $sqlAnswer = "INSERT INTO answers (question_code, answer, is_correct, count, date_created, date_archived) 
                          VALUES (:question_code, :answer, :is_correct, :count, :date_created, NULL)";
            $stmtAnswer = $pdo->prepare($sqlAnswer);
            $stmtAnswer->execute([
                ':question_code' => $code,
                ':answer' => $answer['answer'],
                ':is_correct' => 0, // Assuming is_correct is always 0 for now
                ':count' => 0,
                ':date_created' => $date_created
            ]);

            // Retrieve the ID of the newly inserted answer
            $newAnswerId = $pdo->lastInsertId();

            // Add the inserted answer to the list
            $insertedAnswers[] = [
                'id' => $newAnswerId,
                'question_code' => $code,
                'answer' => $answer['answer'],
                'is_correct' => 0, // Assuming is_correct is always 0 for now
                'count' => 0,
                'date_created' => $date_created,
                'date_archived' => null
            ];
        }
    }

    // Return a message with the ID of the newly inserted question and the inserted answers
    $responseData = [
        'id' => $newQuestionId,
        'code' => $code,
        'answers' => $insertedAnswers
    ];
    $response->getBody()->write(json_encode($responseData));
    
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
})->add(new JWTAuthMiddleware()); 

// Function to generate a unique 5-character code consisting of letters and numbers
function generateUniqueCode($pdo) {
    $code = null;
    do {
        // Generate a random 5-character code consisting of letters and numbers
        $code = generateRandomString(5);
        // Check if the code already exists in the database
        $sql = "SELECT COUNT(*) FROM questions WHERE code = :code";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':code' => $code]);
        $count = $stmt->fetchColumn();
    } while ($count > 0); // If code already exists, generate another one
    return $code;
}

// Function to generate a random string of specified length consisting of numbers, with the first character not being '0'
function generateRandomString($length) {
    // The characters to use for generating the random string (excluding '0' for the first character)
    $characters = '123456789';

    // Generate the first character randomly from the characters 1-9
    $randomString = $characters[mt_rand(0, strlen($characters) - 1)];

    // Generate the rest of the characters randomly from the characters 0-9
    $characters .= '0123456789';
    for ($i = 1; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}



// PUT route to update the date_end and question of a question by ID
$app->put('/question/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];

    // Get the request body contents
    $body = $request->getBody()->getContents();

    // Decode the JSON data into an associative array
    $data = json_decode($body, true);

    // Set current time as date_end
    $date_end = date('Y-m-d H:i:s');

    // Update the question and date_end in the database
    $sql = "UPDATE questions SET question = :question, date_end = :date_end WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':question' => $data['question'], // Updated question
        ':date_end' => $date_end, // Updated date_end
        ':id' => $id
    ]);

    // Return success message
    $response->getBody()->write(json_encode(['message' => 'Question and date_end updated!']));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
})->add(new JWTAuthMiddleware());


// GET route to retrieve a question by code
$app->get('/question/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];

    $sql = "SELECT * FROM questions WHERE code = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$code]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$questions) {
        // If no questions with the given code are found, return 404 Not Found
        $response->getBody()->write(json_encode(["error" => "No questions found with the given code"]));
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }

    // Return response as JSON
    $response->getBody()->write(json_encode($questions));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});