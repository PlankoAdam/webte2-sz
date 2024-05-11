<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

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

    // Get the ID of the newly inserted user
    $newUserId = $pdo->lastInsertId();

    // Encode the response data as JSON including the ID of the newly inserted user
    $responseData = [
        'id' => $newUserId
    ];
    $response->getBody()->write(json_encode($responseData));

    // Set the response headers and status code
    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(200);
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());

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

})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());

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
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());

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
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());

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
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());
