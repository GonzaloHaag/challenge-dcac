<?php 
declare(strict_types=1);
namespace App\Core;

class Response {
    public static function json(array $data, int $statusCode):void {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}