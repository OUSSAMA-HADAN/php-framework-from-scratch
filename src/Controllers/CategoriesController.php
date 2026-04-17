<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controller\AbstractController;
use DI\Attribute\Inject;
use Framework\Database\CategoryRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Handles all HTTP requests related to categories.
class CategoriesController extends AbstractController
{
    #[Inject]
    private CategoryRepositoryInterface $categoryRepository;

    // GET /categories — list all categories.
    public function index(): ResponseInterface
    {
        return $this->render('categories/index', [
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    // GET /category/{id} — show a single category.
    public function show(ServerRequestInterface $request, array $args): ResponseInterface
    {
        return $this->render('category/index', [
            'category' => $this->categoryRepository->findById((int) $args['id']),
        ]);
    }

    // GET /categories/create — show the create form.
    public function create(): ResponseInterface
    {
        return $this->render('categories/create', []);
    }

    // POST /categories — store a new category then redirect to list.
    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->categoryRepository->create(
            trim((string) ($body['name'] ?? '')),
            trim((string) ($body['description'] ?? '')),
        );

        return $this->redirect('/categories');
    }

    // GET /category/{id}/edit — show the edit form pre-filled with existing data.
    public function edit(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $category = $this->categoryRepository->findById((int) $args['id']);

        if ($category === null) {
            return $this->redirect('/categories');
        }

        return $this->render('categories/edit', ['category' => $category]);
    }

    // POST /category/{id}/update — save changes then redirect to list.
    public function update(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->categoryRepository->update(
            (int) $args['id'],
            trim((string) ($body['name'] ?? '')),
            trim((string) ($body['description'] ?? '')),
        );

        return $this->redirect('/categories');
    }

    // POST /category/{id}/delete — delete the category then redirect to list.
    public function destroy(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $this->categoryRepository->delete((int) $args['id']);

        return $this->redirect('/categories');
    }
}
