<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Bratislava');


$app = AppFactory::create();

// Database connection parameters
$host = 'mysql'; // Docker service name
$username = 'root';
$password = 'root';
$database = 'webte2_sz';
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

// Create a new user
$app->post('/users', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();

    // Decode the JSON data into an associative array
    $data = json_decode($body, true);


    $sql = "INSERT INTO users (email, name, surname, admin) VALUES (:email, :name, :surname, :admin)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $data['email'],
        ':name' => $data['name'],
        ':surname' => $data['surname'],
        ':admin' => $data['admin']
    ]);
    // Encode the response data as JSON
    $response->getBody()->write(json_encode(['message' => 'User created']));

    // Set the response headers and status code
    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(200);
});

// Get all users
$app->get('/users', function (Request $request, Response $response) use ($pdo) {
    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Return response as JSON
    $response->getBody()->write(json_encode($users));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);

});

// Get a single user by ID
$app->get('/users/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $response->getBody()->write(json_encode($user));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// Update a user
$app->put('/users/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $body = $request->getBody()->getContents();
    // Decode the JSON data into an associative array
    $data = json_decode($body, true);
    $sql = "UPDATE users SET email = :email, name = :name, surname = :surname, admin = :admin WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $data['email'],
        ':name' => $data['name'],
        ':surname' => $data['surname'],
        ':admin' => $data['admin'],
        ':id' => $id
    ]);
    // Encode the response data as JSON
    $response->getBody()->write(json_encode(['message' => 'User updated!']));

    // Set the response headers and status code
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// Delete a user
$app->delete('/users/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    // Encode the response data as JSON
    $response->getBody()->write(json_encode(['message' => 'User deleted']));

    // Set the response headers and status code
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

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








$app->run();
