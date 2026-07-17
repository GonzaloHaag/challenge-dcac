<?php 
declare(strict_types=1);
namespace App\Repository;

use App\Interface\ProductRepositoryInterface;
use PDO;

class MYSQLProductRepository implements ProductRepositoryInterface {
    private const TABLE = 'productos';
    public function __construct(private PDO $connection){}
    public function findAll(): array {
        $sql = "SELECT id, nombre, descripcion, precio, created_at, updated_at FROM " . self::TABLE;
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function findById(int $id): ?array {
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
}

