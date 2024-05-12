<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;


// Middleware for checking if request was made by admin
// can be added only after JWTAuthMiddleware
// if user is admin, passes the request to the handler method
// else returns 401 with error message to the client
// add this middleware to a route like this:
// $app->get('/', function () { ... })->add(new AdminAuthMiddleware())->add(new JWTAuthMiddleware());
class AdminAuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        global $pdo;
        $user_id = $request->getAttribute('user_id');

        try {
            $stmt = $pdo->prepare("SELECT admin FROM users WHERE id = :id");
            $stmt->bindParam(":id", $user_id, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $is_admin = $stmt->fetch(PDO::FETCH_ASSOC)['admin'] == 1;
                if ($is_admin) {
                    return $handler->handle($request);
                } else {
                    return JWTAuthMiddleware::getErrorResponse(401, "Admins only.");
                }
            } else {
                return JWTAuthMiddleware::getErrorResponse(500, "Databse error.");
            }
        } catch (PDOException $e) {
            return JWTAuthMiddleware::getErrorResponse(500, 'Database error.');
        }

    }
}