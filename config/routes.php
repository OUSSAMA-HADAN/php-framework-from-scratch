<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CupController;
use App\Controllers\HomeController;
use App\Controllers\MatcheController;
use App\Controllers\ProfileController;

use App\Middleware\AuthMiddleware;
use League\Route\RouteGroup;
use League\Route\Router;
use Psr\Container\ContainerInterface;

// All application routes are registered here.
// The $container is passed in so middleware can be resolved with dependencies injected by PHP-DI.
return function (Router $router, ContainerInterface $container) {

    $authMiddleware = $container->get(AuthMiddleware::class);

    // -------------------------------------------------------
    // Public routes — no authentication required
    // -------------------------------------------------------
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/login',    [AuthController::class, 'showLogin']);
    $router->post('/login',   [AuthController::class, 'login']);
    $router->get('/register', [AuthController::class, 'showRegister']);
    $router->post('/register',[AuthController::class, 'register']);
    $router->get('/logout',   [AuthController::class, 'logout']);

    // -------------------------------------------------------
    // Protected routes — AuthMiddleware checks session first
    // -------------------------------------------------------
    $router->group('', function (RouteGroup $router) {

        // Cups
        $router->get('/cups',                      [CupController::class, 'index']);
        $router->get('/cups/{id:number}',          [CupController::class, 'show']);
        $router->post('/cups/{id:number}/join',    [CupController::class, 'join']);

        // Matches
        $router->get('/matches',                       [MatcheController::class, 'index']);
        $router->get('/matches/{id:number}',           [MatcheController::class, 'show']);
        $router->post('/matches/{id:number}/score',    [MatcheController::class, 'submitScore']);

        // Profile
        $router->get('/profile', [ProfileController::class, 'show']);

    })->middleware($authMiddleware);
};
