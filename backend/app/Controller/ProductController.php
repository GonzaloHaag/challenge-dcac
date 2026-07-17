<?php 
declare(strict_types=1);
namespace App\Controller;

use App\Core\Response;
use App\Interface\ProductServiceInterface;

class ProductController {
    public function __construct(private ProductServiceInterface $productService){}
    public function index() {
        $products = $this->productService->getAll();
        Response::json($products, 200);
    }
}