<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

// Protects routes that require an authenticated user.
// If no valid session exists, the request is redirected to /login.
// If authenticated, the request passes through to the next handler (controller).
class AuthMiddleware extends AbstractMiddleware
{
    public function process(
        ServerRequestInterface  $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Start the session if one is not already active.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check for an authenticated user in the session.
        // $_SESSION['user_id'] is set by LoginController on successful login.
        if (empty($_SESSION['user_id'])) {
            // No active session — redirect to login and stop the chain.
            return $this->redirect('/login');
        }

        // User is authenticated — pass the request to the next middleware or controller.
        return $handler->handle($request);
    }
}
