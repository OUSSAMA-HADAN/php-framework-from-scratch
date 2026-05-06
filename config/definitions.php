<?php

use App\Middleware\AuthMiddleware;

use App\Repositories\CupRepository;
use App\Repositories\GroupRepository;
use App\Repositories\MatcheRepository;
use App\Repositories\UserRepository;

use Framework\Database\Database;
use Framework\Database\DatabaseInterface;

use Framework\Database\CupRepositoryInterface;
use Framework\Database\GroupRepositoryInterface;
use Framework\Database\MatcheRepositoryInterface;
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


    // Repositories: User
    UserRepositoryInterface::class   => DI\autowire(UserRepository::class),

    // Repositories: VFoot domain
    CupRepositoryInterface::class    => DI\autowire(CupRepository::class),
    GroupRepositoryInterface::class  => DI\autowire(GroupRepository::class),
    MatcheRepositoryInterface::class => DI\autowire(MatcheRepository::class),

    // Middleware: autowire injects ResponseFactoryInterface via the constructor.
    AuthMiddleware::class => DI\autowire(AuthMiddleware::class),
];