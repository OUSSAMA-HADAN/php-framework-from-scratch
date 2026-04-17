<?php

declare(strict_types=1);

namespace App\Controller;

use DI\Attribute\Inject;
use Framework\Template\RendererInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class AbstractController
{
    #[Inject]
    private ResponseFactoryInterface $responseFactory;

    #[Inject]
    private StreamFactoryInterface $streamFactory;

    #[Inject]
    private RendererInterface $renderer;

    // Renders a template and returns a 200 PSR-7 response.
    public function render(string $template, array $data = []): ResponseInterface
    {
        $contents = $this->renderer->render($template, $data);
        $stream   = $this->streamFactory->createStream($contents);
        $response = $this->responseFactory->createResponse();

        return $response->withBody($stream);
    }

    // Returns a 302 redirect response to the given URL.
    // Available to all controllers that extend this class.
    protected function redirect(string $url): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse(302)
            ->withHeader('Location', $url);
    }
}
