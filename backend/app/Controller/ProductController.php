<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Response;
use App\Interface\ProductServiceInterface;

class ProductController
{
    public function __construct(private ProductServiceInterface $productService) {}
    public function index(): void
    {
        $products = $this->productService->getAll();
        Response::json($products, 200);
    }

    public function show(int $id): void
    {
        $product = $this->productService->getById($id);
        if (!$product) {
            Response::json(['error' => 'Producto no encontrado'], 404);
            return;
        }
        Response::json($product, 200);
    }

    public function store(): void
    {
        $body = $this->decodeBody();
        $product = $this->productService->create($body);
        Response::json($product, 201);
    }

    public function update(int $id): void
    {
        $body = $this->decodeBody();
        $product = $this->productService->update($id, $body);
        if (!$product) {
            Response::json(['error' => 'Producto no encontrado'], 404);
            return;
        }
        Response::json($product, 200);
    }

    public function destroy(int $id): void
    {
        $productDeleted = $this->productService->delete($id);
        if (!$productDeleted) {
            Response::json(['error' => 'Producto no encontrado'], 404);
            return;
        }
        Response::json(['message' => 'Producto eliminado'], 200);
    }

    private function decodeBody(): array
    {
        $body = json_decode(file_get_contents("php://input"), true);
        if (!is_array($body)) {
            throw new \InvalidArgumentException('El cuerpo de la petición debe ser un JSON válido.');
        }
        return $body;
    }
}
