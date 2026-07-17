<?php 
declare(strict_types=1);
namespace App\Model;

class Product {
    private ?int $id;
    private string $nombre;
    private ?string $descripcion;
    private float $precio;

    public function __construct(?int $id, string $nombre, ?string $descripcion, float $precio) {
        $this->id = $id;
        $this->setNombre($nombre);
        $this->setDescripcion($descripcion);
        $this->setPrecio($precio);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDescripcion(): ?string {
        return $this->descripcion;
    }

    public function getPrecio(): float {
        return $this->precio;
    }

    public function setNombre(string $nombre): void {
        if(trim($nombre) === '') {
            throw new \InvalidArgumentException("El nombre no puede estar vacío.");
        }
        $this->nombre = $nombre;
    }

    public function setDescripcion(?string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setPrecio(float $precio): void {
        if($precio < 0) {
            throw new \InvalidArgumentException("El precio no puede ser negativo.");
        }
        $this->precio = $precio;
    }

}