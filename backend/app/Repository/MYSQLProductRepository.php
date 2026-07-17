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
        $sql = "SELECT id, nombre, descripcion, precio, created_at, updated_at FROM " . self::TABLE . " WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'id' => $id
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): array {
        $sql = "INSERT INTO " . self::TABLE . " (nombre, descripcion, precio) VALUES (:nombre, :descripcion, :precio)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
        ]);
        return [
            'id' => (int)$this->connection->lastInsertId(),
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => (float)$data['precio'],
        ];
    }

    public function update(int $id, array $data): ?array {
        $sql = "UPDATE " . self::TABLE . " SET nombre = :nombre, descripcion = :descripcion, precio = :precio WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'id' => $id,
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
        ]);
        return [
            'id' => $id,
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => (float)$data['precio'],
        ];  
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'id' => $id
        ]);
        return $statement->rowCount() > 0;
    }
}

