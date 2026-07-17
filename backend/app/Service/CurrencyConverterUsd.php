<?php 
declare(strict_types=1);
namespace App\Service;
use App\Interface\CurrencyConverterInterface;

class CurrencyConverterUsd implements CurrencyConverterInterface {
    public function __construct(private float $usdRate){
        if($usdRate <= 0) {
            throw new \InvalidArgumentException("La tasa de conversión a USD debe ser mayor que cero.");
        }
    }

    public function convert(float $amount): float {
        return $amount / $this->usdRate;
    }
}