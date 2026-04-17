<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controller\AbstractController;
use DI\Attribute\Inject;
use Framework\Database\CategoryRepositoryInterface;
use Framework\Database\ProductRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Handles all HTTP requests related to products.
class ProductsController extends AbstractController
{
    #[Inject]
    private ProductRepositoryInterface $productRepository;

    // Injected to populate the category dropdown on create/edit forms.
    #[Inject]
    private CategoryRepositoryInterface $categoryRepository;

    // GET /products — list all products.
    public function index(): ResponseInterface
    {
        return $this->render('products/index', [
            'products' => $this->productRepository->findAll(),
        ]);
    }

    // GET /product/{id} — show a single product.
    public function show(ServerRequestInterface $request, array $args): ResponseInterface
    {
        return $this->render('product/index', [
            'product' => $this->productRepository->findById((int) $args['id']),
        ]);
    }

    // GET /products/create — show the create form with a category dropdown.
    public function create(): ResponseInterface
    {
        return $this->render('products/create', [
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    // POST /products — store a new product then redirect to list.
    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $body       = $request->getParsedBody();
        $categoryId = !empty($body['category_id']) ? (int) $body['category_id'] : null;

        $this->productRepository->create(
            trim((string) ($body['name'] ?? '')),
            trim((string) ($body['description'] ?? '')),
            (int) ($body['size'] ?? 0),
            $categoryId,
        );

        return $this->redirect('/products');
    }

    // GET /product/{id}/edit — show the edit form pre-filled with existing data.
    public function edit(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $product = $this->productRepository->findById((int) $args['id']);

        if ($product === null) {
            return $this->redirect('/products');
        }

        return $this->render('products/edit', [
            'product'    => $product,
            // Pass all categories so the dropdown can mark the current one as selected.
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    // POST /product/{id}/update — save changes then redirect to list.
    public function update(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $body       = $request->getParsedBody();
        $categoryId = !empty($body['category_id']) ? (int) $body['category_id'] : null;

        $this->productRepository->update(
            (int) $args['id'],
            trim((string) ($body['name'] ?? '')),
            trim((string) ($body['description'] ?? '')),
            (int) ($body['size'] ?? 0),
            $categoryId,
        );

        return $this->redirect('/products');
    }

    // POST /product/{id}/delete — delete the product then redirect to list.
    public function destroy(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $this->productRepository->delete((int) $args['id']);

        return $this->redirect('/products');
    }
}
