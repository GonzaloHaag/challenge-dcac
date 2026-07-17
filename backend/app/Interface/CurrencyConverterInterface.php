<?php 
declare(strict_types=1);
namespace App\Interface;


interface CurrencyConverterInterface {
    public function convert(float $amount):float;
}