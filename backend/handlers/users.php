<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// Create a new user
$app->post('/users', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);

    try {
        $sql = "INSERT INTO users (email, name, surname, admin) VALUES (:email, :name, :surname, :admin)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $data['email'],
            ':name' => $data['name'],
            ':surname' => $data['surname'],
            ':admin' => $data['admin']
        ]);

        return getJsonMessageResponse($response, 200, 'User created.');
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());


// Get all users
$app->get('/users', function (Request $request, Response $response) use ($pdo) {
    try {
        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Return response as JSON
        $response->getBody()->write(json_encode($users));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());


// Get a single user by ID
$app->get('/users/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];

    try {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($user));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());


// Update a user
$app->put('/users/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);

    try {
        $sql = "UPDATE users SET email = :email, name = :name, surname = :surname, admin = :admin WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $data['email'],
            ':name' => $data['name'],
            ':surname' => $data['surname'],
            ':admin' => $data['admin'],
            ':id' => $id
        ]);

        return getJsonMessageResponse($response, 200, 'User updated.');
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());


// Delete a user
$app->delete('/users/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];

    try {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return getJsonMessageResponse($response, 200, 'User deleted.');
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
})->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());
