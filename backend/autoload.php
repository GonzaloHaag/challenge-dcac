<?php

declare(strict_types=1);

spl_autoload_register(function (string $className): void {

    $prefix = 'App\\';

    if (!str_starts_with($className, $prefix)) {
        return;
    }

    $className = substr($className, strlen($prefix));

    $file = __DIR__ . '/app/' 
        . str_replace('\\', DIRECTORY_SEPARATOR, $className)
        . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
