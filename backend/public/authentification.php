<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function getErrorResponse(Response $response, int $code, string $message) {
    $response->getBody()->write(json_encode(['message' => $message]));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($code);
}


// POST route to sing up (obtain a JWT token)
$app->post('/login', function (Request $request, Response $response) use ($pdo, $secretKey) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);

    if (!isset($array['email']) || !isset($array['password'])) {
        return getErrorResponse($response, 400, 'The format of the request body is invalid.');
    }

    try {
        $stmt = $pdo->prepare("SELECT name, surname, email, password FROM users WHERE email = :email");
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $hashed_password = $row['password'];

            if (password_verify($data['password'], $hashed_password)) {
                $jwt_payload = [
                    'user_id' => $row['id'], 
                    'expiration' => time() + 3600
                ];
                $jwt = JWT::encode($jwt_payload, $secretKey, 'HS256');
                $response->getBody()->write(json_encode(['jwt' => $jwt]));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
            } else {
                return getErrorResponse($response, 400, 'Invalid email or password.');
            }
        } else {
            return getErrorResponse($response, 400, 'Invalid email or password.');
        }
    } catch (PDOException $e) {
        return getErrorResponse($response, 500, 'Database error.');
    }
});