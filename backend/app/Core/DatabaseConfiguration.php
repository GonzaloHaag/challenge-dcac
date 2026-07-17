<?php 
declare(strict_types=1);
namespace App\Core;

class DatabaseConfiguration {
    private readonly string $host;
    private readonly string $database;
    private readonly string $username;
    private readonly string $password;
    private readonly int $port;
    public function __construct()
    {
        $this->host = Config::get('DB_HOST', 'localhost');
        $this->port = (int)Config::get('DB_PORT', 3306);   
        $this->database = Config::get('MYSQL_DATABASE', 'my_database');
        $this->username = Config::get('MYSQL_USER', 'root');
        $this->password = Config::get('MYSQL_PASSWORD', '');
    }

    public function getDsn():string {
        return sprintf(
            'mysql:host=%s;dbname=%s;port=%d;charset=utf8mb4',
            $this->host,
            $this->database,
            $this->port
        );
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }
}