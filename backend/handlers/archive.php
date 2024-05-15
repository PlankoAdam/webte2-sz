<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// POST route to archive a question by code
$app->post('/archive/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);

    // Check if the question exists
    $existingQuestion = getQuestionn($pdo, $code);

    if (!$existingQuestion) {
        // If no question with the given code is found, return 404 Not Found
        $response->getBody()->write(json_encode(["error" => "No question found with the given code"]));
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }

    // Get the note from the request body
    $note = isset($data['note']) ? $data['note'] : "No note provided";

    // Archive all answers for the given question code
    $archive_time = date('Y-m-d H:i:s');

    // Insert into archive table
    $sqlInsertArchive = "INSERT INTO archive (question_code, notes, archive_time) VALUES (:question_code, :notes, :archive_time)";
    $stmtInsertArchive = $pdo->prepare($sqlInsertArchive);
    $stmtInsertArchive->execute([
        ':question_code' => $code,
        ':notes' => $note,
        ':archive_time' => $archive_time
    ]);

    // Get the last inserted ID from the archive table
    $archive_id = $pdo->lastInsertId();

    // Copy answers from answers table to archived_answers table
    $sqlCopyAnswers = "INSERT INTO archived_answers (archive_id, answer, count, is_correct)
                       SELECT :archive_id, answer, count, is_correct
                       FROM answers
                       WHERE question_code = :question_code";
    $stmtCopyAnswers = $pdo->prepare($sqlCopyAnswers);
    $stmtCopyAnswers->execute([
        ':archive_id' => $archive_id,
        ':question_code' => $code
    ]);

    // Update the count to 0 in the answers table
    $sqlUpdateCount = "UPDATE answers SET count = 0 WHERE question_code = :question_code";
    $stmtUpdateCount = $pdo->prepare($sqlUpdateCount);
    $stmtUpdateCount->execute([':question_code' => $code]);

    // If the question is open-ended, delete the rows from the answers table
    if ($existingQuestion['is_open_ended'] == 1) {
        $sqlDeleteAnswers = "DELETE FROM answers WHERE question_code = :question_code";
        $stmtDeleteAnswers = $pdo->prepare($sqlDeleteAnswers);
        $stmtDeleteAnswers->execute([':question_code' => $code]);
    }

    // Retrieve the newly inserted data from archived_answers table
    $sqlNewData = "SELECT aa.*, a.notes, a.archive_time
                   FROM archived_answers aa
                   INNER JOIN archive a ON aa.archive_id = a.id
                   WHERE aa.archive_id = :archive_id";
    $stmtNewData = $pdo->prepare($sqlNewData);
    $stmtNewData->execute([':archive_id' => $archive_id]);
    $newData = $stmtNewData->fetchAll(PDO::FETCH_ASSOC);

    // Return response with the new data
    $response->getBody()->write(json_encode(["updated_data" => $newData]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
})->add(new JWTAuthMiddleware());

// Function to check if a question exists in the database
function getQuestionn($pdo, $question_code)
{
    $sql = "SELECT * FROM questions WHERE code = :question_code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':question_code' => $question_code]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);
    return $question;
}

// GET route to retrieve all archived answers by code
$app->get('/archive/{code}', function (Request $request, Response $response, $args) use ($pdo) {
    $code = $args['code'];

    // Query the database to get archived answers from archived_answers table
    $sqlArchivedAnswers = "SELECT aa.answer, aa.count, aa.is_correct, a.archive_time, a.notes
                           FROM archived_answers aa
                           INNER JOIN archive a ON aa.archive_id = a.id
                           INNER JOIN questions q ON a.question_code = q.code
                           WHERE q.code = ?";
    $stmtArchivedAnswers = $pdo->prepare($sqlArchivedAnswers);
    $stmtArchivedAnswers->execute([$code]);
    $archivedAnswers = $stmtArchivedAnswers->fetchAll(PDO::FETCH_ASSOC);

    // Group archived answers by archive time and notes
    $groupedArchivedAnswers = [];
    foreach ($archivedAnswers as $answer) {
        $archive_key = $answer['archive_time'] . '-' . $answer['notes'];
        if (!isset($groupedArchivedAnswers[$archive_key])) {
            $groupedArchivedAnswers[$archive_key] = [
                "archive_time" => $answer["archive_time"],
                "notes" => $answer["notes"],
                "answers" => []
            ];
        }
        // Add only the relevant fields to the answers array
        $groupedArchivedAnswers[$archive_key]["answers"][] = [
            "answer" => $answer["answer"],
            "count" => $answer["count"],
            "is_correct" => $answer["is_correct"]
        ];
    }

    // Convert the associative array to indexed array
    $formattedResponse = array_values($groupedArchivedAnswers);

    // Return response with the formatted archived answers
    $response->getBody()->write(json_encode($formattedResponse, JSON_PRETTY_PRINT));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
})->add(new JWTAuthMiddleware());
