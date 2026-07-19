<?php

declare(strict_types=1);

namespace App\Core;


class Cors
{
    private const ALLOWED_ORIGINS = [
        'http://localhost:3000',
        'http://localhost:8081'
    ];
    
    public static function handle(): void
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? null;

        if ($origin && in_array($origin, self::ALLOWED_ORIGINS, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
        }
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}
