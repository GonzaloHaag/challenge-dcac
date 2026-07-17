<?php 
declare(strict_types=1);
namespace App\Service;

use App\Interface\CurrencyConverterInterface;
use App\Interface\ProductRepositoryInterface;
use App\Interface\ProductServiceInterface;


class ProductService implements ProductServiceInterface {
    public function __construct(private ProductRepositoryInterface $productRepository, private CurrencyConverterInterface $currencyConverter){}
    public function getAll(): array {
        $products = $this->productRepository->findAll();
        return array_map(function (array $product) {
            return $this->formatProduct($product);
        }, $products);
    }

    public function getById(int $id): ?array {
        // Aquí iría la lógica para obtener un producto por su ID desde la base de datos
       
    }

    public function create(array $data): array {
        // Aquí iría la lógica para crear un nuevo producto en la base de datos
        return ['id' => 4, 'name' => $data['name'], 'price' => $data['price']];
    }

    public function update(int $id, array $data): ?array {
        // Aquí iría la lógica para actualizar un producto existente en la base de datos
       
    }

    public function delete(int $id): bool {
        // Aquí iría la lógica para eliminar un producto de la base de datos
        return true;
    }

    /**
     * Generalmente esto lo mandaría a un transformer, pero para no agregar
     * complejidad, lo dejo aca
     */
    private function formatProduct(array $product): array {
        $product['precio'] = (float) $product['precio'];
        $product['precio_usd'] = round($this->currencyConverter->convert($product['precio']), 2);
        return $product;
    }
}