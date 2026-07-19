<?php

declare(strict_types=1);
require_once __DIR__ . '/../autoload.php';

use App\Controller\ProductController;
use App\Core\Config;
use App\Core\Cors;
use App\Core\Database;
use App\Core\DatabaseConfiguration;
use App\Core\Response;
use App\Core\Router;
use App\Repository\MYSQLProductRepository;
use App\Service\CurrencyConverterUsd;
use App\Service\ProductService;

try {
    Cors::handle();

    $router = new Router();
    
    $databaseConfig = new DatabaseConfiguration();
    $pdo = Database::getInstance($databaseConfig)->getConnection();
    $productRepository = new MYSQLProductRepository($pdo);
    $usdRate = (float) Config::get('PRECIO_USD', 1500);
    $currencyConverter = new CurrencyConverterUsd($usdRate);
    $productService = new ProductService($productRepository, $currencyConverter);
    $productController = new ProductController($productService);

    $router->get('/productos', [$productController, 'index']);
    $router->get('/productos/{id}', [$productController, 'show']);
    $router->post('/productos', [$productController, 'store']);
    $router->put('/productos/{id}', [$productController, 'update']);
    $router->delete('/productos/{id}', [$productController, 'destroy']);


    $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
}
catch (\InvalidArgumentException $e) {
    Response::json(['error' => $e->getMessage()], 400);
}
catch (\Throwable $e) {
    Response::json(['error' => $e->getMessage()], 500);
}
