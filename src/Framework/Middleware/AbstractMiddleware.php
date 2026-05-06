<?php

declare(strict_types=1);

namespace Framework\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

// Base class for all middleware in the framework.
// Provides a ResponseFactory for building redirect or error responses,
// and enforces the PSR-15 MiddlewareInterface contract on all children.
abstract class AbstractMiddleware implements MiddlewareInterface
{
    // Used by child middleware to create redirect or custom responses.
    public function __construct(protected ResponseFactoryInterface $responseFactory){}

    // Must be implemented by each concrete middleware.
    // Call $handler->handle($request) to pass the request down the chain,
    // or return a response directly to short-circuit (e.g. redirect to /login).
    abstract public function process(
        ServerRequestInterface  $request,
        RequestHandlerInterface $handler
    ): ResponseInterface;

    // Helper: creates a redirect response to the given URL.
    // Used by child middleware to redirect without boilerplate.
    protected function redirect(string $url): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse(302)
            ->withHeader('Location', $url);
    }
}
