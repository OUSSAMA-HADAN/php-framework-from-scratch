<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CategoriesController;
use App\Controllers\HomeController;
use App\Controllers\ProductsController;
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

        // Products
        $router->get('/products',                   [ProductsController::class, 'index']);
        $router->get('/products/create',            [ProductsController::class, 'create']);
        $router->post('/products',                  [ProductsController::class, 'store']);
        $router->get('/product/{id:number}',        [ProductsController::class, 'show']);
        $router->get('/product/{id:number}/edit',   [ProductsController::class, 'edit']);
        $router->post('/product/{id:number}/update',[ProductsController::class, 'update']);
        $router->post('/product/{id:number}/delete',[ProductsController::class, 'destroy']);

        // Categories
        $router->get('/categories',                   [CategoriesController::class, 'index']);
        $router->get('/categories/create',            [CategoriesController::class, 'create']);
        $router->post('/categories',                  [CategoriesController::class, 'store']);
        $router->get('/category/{id:number}',         [CategoriesController::class, 'show']);
        $router->get('/category/{id:number}/edit',    [CategoriesController::class, 'edit']);
        $router->post('/category/{id:number}/update', [CategoriesController::class, 'update']);
        $router->post('/category/{id:number}/delete', [CategoriesController::class, 'destroy']);

    })->middleware($authMiddleware);
};
