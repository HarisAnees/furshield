<?php

// Show full errors if anything fails
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require __DIR__.'/vendor/autoload.php';
}

if (file_exists(__DIR__.'/bootstrap/app.php')) {
    (require_once __DIR__.'/bootstrap/app.php')
        ->handleRequest(Request::capture());
} else {
    require_once __DIR__.'/public/index.php';
}