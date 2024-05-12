<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// POST route to retrieve question status by code
$app->post('/archive/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];

    // Query the database to get the is_open_ended value for the given code
    $sql = "SELECT is_open_ended FROM questions WHERE code = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$code]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        // If no question with the given code is found, return 404 Not Found
        $response->getBody()->write(json_encode(["error" => "No question found with the given code"]));
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }

    $is_open_ended = $result['is_open_ended'];

    if ($is_open_ended == 0) {
        // If the question is not open-ended, copy answers to multi_choice_answer_archives table
        $date_archived = date('Y-m-d H:i:s');

        // Insert into multi_choice_answer_archives from answers
        $sqlInsert = "INSERT INTO multi_choice_answer_archives (answer_id, count, date_archived)
                      SELECT id, count, :date_archived FROM answers WHERE question_code = :question_code";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            ':date_archived' => $date_archived,
            ':question_code' => $code
        ]);

        // Retrieve the newly inserted data from multi_choice_answer_archives table
        $sqlNewData = "SELECT mcaa.*, a.answer
                       FROM multi_choice_answer_archives mcaa
                       INNER JOIN answers a ON mcaa.answer_id = a.id
                       WHERE mcaa.date_archived = :date_archived";
        $stmtNewData = $pdo->prepare($sqlNewData);
        $stmtNewData->execute([':date_archived' => $date_archived]);
        $newData = $stmtNewData->fetchAll(PDO::FETCH_ASSOC);

        // Return response with the new data
        $response->getBody()->write(json_encode(["updated_data" => $newData]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // If the question is open-ended, just update the date_archived column in the answers table
        $date_archived = date('Y-m-d H:i:s');

        $sqlUpdate = "UPDATE answers SET date_archived = :date_archived WHERE question_code = :question_code";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':date_archived' => $date_archived,
            ':question_code' => $code
        ]);

        // Retrieve the updated data from the answers table
        $sqlUpdatedData = "SELECT * FROM answers WHERE question_code = :question_code";
        $stmtUpdatedData = $pdo->prepare($sqlUpdatedData);
        $stmtUpdatedData->execute([':question_code' => $code]);
        $updatedData = $stmtUpdatedData->fetchAll(PDO::FETCH_ASSOC);

        // Return response with the updated data
        $response->getBody()->write(json_encode(["updated_data" => $updatedData]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
})->add(new JWTAuthMiddleware());