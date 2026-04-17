<?php

use App\Middleware\AuthMiddleware;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Framework\Database\CategoryRepositoryInterface;
use Framework\Database\Database;
use Framework\Database\DatabaseInterface;
use Framework\Database\ProductRepositoryInterface;
use Framework\Database\UserRepositoryInterface;
use Framework\Template\PlatesRenderer;
use Framework\Template\RendererInterface;
use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

return [
    // HTTP: binds PSR-17 factory interfaces to Guzzle's HttpFactory implementation.
    // ResponseFactoryInterface::class => DI\create(Psr17Factory::class)
    ResponseFactoryInterface::class  => DI\create(HttpFactory::class),
    StreamFactoryInterface::class    => DI\create(HttpFactory::class),

    // Templating: PlatesRenderer wraps the League Plates engine.
    RendererInterface::class         => DI\create(PlatesRenderer::class),

    // Database: single shared PDO connection, lazy-initialized on first use.
    DatabaseInterface::class         => DI\create(Database::class),

    // Repositories: autowire resolves constructor parameters by type automatically.
    // DI\create() does not auto-wire — DI\autowire() is required for constructor injection.
    ProductRepositoryInterface::class  => DI\autowire(ProductRepository::class),
    CategoryRepositoryInterface::class => DI\autowire(CategoryRepository::class),

    // Repositories: User
    UserRepositoryInterface::class => DI\autowire(UserRepository::class),

    // Middleware: autowire injects ResponseFactoryInterface via the constructor.
    AuthMiddleware::class => DI\autowire(AuthMiddleware::class),
];