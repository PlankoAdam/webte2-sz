<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;

function getJsonMessageResponse(Response $response, int $code, string $message) {
    $response->getBody()->write(json_encode(['message' => $message]));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($code);
}


// PUT route for user to login
$app->post('/account/login', function (Request $request, Response $response) use ($pdo, $secretKey) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);

    if (!isset($data['email']) || !isset($data['password'])) {
        return getJsonMessageResponse($response, 400, 'The format of the request body is invalid.');
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];

            if (password_verify($data['password'], $hashed_password)) {
                $jwt_payload = [
                    'user_id' => $row['id'], 
                    'expiration' => time() + 3600
                ];
                $jwt = JWT::encode($jwt_payload, $secretKey, 'HS256');
                $response->getBody()->write(json_encode([
                    'jwt' => $jwt,
                    'user' => [
                        'name' => $row['name'],
                        'surname' => $row['surname'],
                        'email' => $row['email'],
                        'admin' => $row['admin']
                    ]

                ]));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
            } else {
                return getJsonMessageResponse($response, 400, 'Invalid email or password.');
            }
        } else {
            return getJsonMessageResponse($response, 400, 'Invalid email or password.');
        }
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
});


// PUT route for user to register
$app->post('/account/register', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);

    if (!isset($data['email']) || !isset($data['name']) || !isset($data['surname']) || !isset($data['password'])) {
        return getJsonMessageResponse($response, 400, 'The format of the request body is invalid.');
    }

    $hashed_password = password_hash($data['password'], PASSWORD_ARGON2ID);

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return getJsonMessageResponse($response, 400, 'Email already in use.');
        }

        $stmt = $pdo->prepare("INSERT INTO users (name, surname, email, password, admin) VALUES (:name, :surname, :email, :password, 0)");
        $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(":surname", $data['surname'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
        $stmt->execute();

        $response->getBody()->write(json_encode(['message' => "Registration was successful."]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
});

// GET route for user to retrieve their account details
$app->get('/account', function (Request $request, Response $response) use ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT email, name, surname, admin FROM users WHERE id = :id");
        $stmt->bindValue(":id", $request->getAttribute('user_id'), PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($user));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
})->add(new JWTAuthMiddleware());


// PUT route for user to change their account details
$app->put('/account', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    $user_id = $request->getAttribute('user_id');

    if (!isset($data['email']) && !isset($data['name']) && !isset($data['surname'])) {
        $response->getBody()->write(json_encode(['message' => 'Nothing to update.']));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    try {
        if (isset($data['email'])) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND id != :id");
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(":id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return getJsonMessageResponse($response, 400, 'Email already in use.');
            }
        }

        $query = "UPDATE users SET ";
        $params = [];

        addUpdateAttr($data, $query, $params, "email");
        addUpdateAttr($data, $query, $params, "name");
        addUpdateAttr($data, $query, $params, "surname");

        $query = rtrim($query, ", ");
        $query .= " WHERE id = :id";
        $stmt = $pdo->prepare($query);

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        $stmt->bindParam(':id', $user_id);

        $stmt->execute();
        
        return getJsonMessageResponse($response, 200, 'Account info updated.');
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.' . $e->getMessage());
    }
})->add(new JWTAuthMiddleware());


// PUT route for user to change their password
$app->put('/account/password', function (Request $request, Response $response) use ($pdo) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    $user_id = $request->getAttribute('user_id');

    if (!isset($data['old_password']) || !isset($data['new_password'])) {
        return getJsonMessageResponse($response, 400, 'The format of the request body is invalid.');
    }

    try {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->bindParam(":id", $user_id, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_old_password = $row['password'];

            if (password_verify($data['old_password'], $hashed_old_password)) {
                $hashed_new_password = password_hash($data['new_password'], PASSWORD_ARGON2ID);

                $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                $stmt->bindParam(":password", $hashed_new_password, PDO::PARAM_STR);
                $stmt->bindParam(":id", $user_id, PDO::PARAM_STR);
                $stmt->execute();

                return getJsonMessageResponse($response, 200, 'Password updated successfully.');
            } else {
                return getJsonMessageResponse($response, 400, 'Incorrect old password.');
            }
        } else {
            return getJsonMessageResponse($response, 500, 'Internal server error.');
        }
    } catch (PDOException $e) {
        return getJsonMessageResponse($response, 500, 'Database error.');
    }
})->add(new JWTAuthMiddleware());



function addUpdateAttr(&$request_body, &$query, &$params, $req_str) {
    if (isset($request_body[$req_str])) {
        $query .= "$req_str = :$req_str, ";
        $params[':' . $req_str] = $request_body[$req_str];
    }
}