<?php 
declare(strict_types=1);
namespace App\Core;

use PDO;

/**
 * PATRON SIGLETON: Garantiza que una clase tenga una única instancia y proporciona un punto de acceso global a ella.
 * El constructor es privado para evitar la creación de instancias desde fuera de la clase. 
 * La instancia se crea solo cuando se llama al método getInstance().
 */
class Database {
    private static ?Database $instance = null;
    private PDO $connection;
    private function __construct(DatabaseConfiguration $databaseConfiguration) {
        $this->connection = new PDO(
            $databaseConfiguration->getDsn(),
            $databaseConfiguration->getUsername(),
            $databaseConfiguration->getPassword(),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public static function getInstance(DatabaseConfiguration $databaseConfiguration): Database {
        if (!isset(self::$instance)) {
            self::$instance = new Database($databaseConfiguration);
        }
        return self::$instance;
    }

    /** Retornar conexion activa PDO */
    public function getConnection(): PDO {
        return $this->connection;
    }

    private function __clone() {
        // Evitar la clonación de la instancia
    }

    public function __wakeup() {
        // Evitar la deserialización de la instancia
        throw new \Exception("Cannot unserialize a singleton.");
    }
}