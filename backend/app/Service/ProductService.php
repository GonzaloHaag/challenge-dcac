<?php

declare(strict_types=1);

namespace App\Service;

use App\Interface\CurrencyConverterInterface;
use App\Interface\ProductRepositoryInterface;
use App\Interface\ProductServiceInterface;
use App\Model\Product;

class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $productRepository, private CurrencyConverterInterface $currencyConverter) {}
    public function getAll(): array
    {
        $products = $this->productRepository->findAll();
        return array_map(function (array $product) {
            return $this->formatProduct($product);
        }, $products);
    }

    public function getById(int $id): ?array
    {
        $product = $this->productRepository->findById($id);
        if (!$product) return null;
        return $this->formatProduct($product);
    }

    public function create(array $data): array
    {
        if (!isset($data['nombre'], $data['precio'])) {
            throw new \InvalidArgumentException('Faltan datos requeridos para crear el producto.');
        }
        $product = new Product(null, $data['nombre'], $data['descripcion'] ?? null, (float)$data['precio']);
        $productCreated = $this->productRepository->create([
            'nombre' => $product->getNombre(),
            'descripcion' => $product->getDescripcion(),
            'precio' => $product->getPrecio(),
        ]);
        return $this->formatProduct($productCreated);
    }

    public function update(int $id, array $data): ?array
    {
        $findProduct = $this->productRepository->findById($id);
        if (!$findProduct) return null;
        if(!isset($data['nombre'], $data['precio'])) {
            throw new \InvalidArgumentException('Faltan datos requeridos para actualizar el producto.');
        }
        $productUpdated = $this->productRepository->update($id, [
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'precio' => (float)$data['precio'],
        ]);
        if (!$productUpdated) return null;
        return $this->formatProduct($productUpdated);
    }

    public function delete(int $id): bool
    {
        return $this->productRepository->delete($id);
    }

    /**
     * Generalmente esto lo mandaría a un transformer, pero para no agregar
     * complejidad, lo dejo aca
     */
    private function formatProduct(array $product): array
    {
        $product['precio'] = (float) $product['precio'];
        $product['precio_usd'] = round($this->currencyConverter->convert($product['precio']), 2);
        return $product;
    }
}
