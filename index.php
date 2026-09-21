<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-repair missing cache & storage directories on shared hosting
if (!is_dir(__DIR__ . '/bootstrap/cache')) {
    @mkdir(__DIR__ . '/bootstrap/cache', 0777, true);
}
if (!is_dir(__DIR__ . '/storage/framework/views')) {
    @mkdir(__DIR__ . '/storage/framework/views', 0777, true);
}
if (!is_dir(__DIR__ . '/storage/framework/sessions')) {
    @mkdir(__DIR__ . '/storage/framework/sessions', 0777, true);
}
if (!is_dir(__DIR__ . '/storage/framework/cache')) {
    @mkdir(__DIR__ . '/storage/framework/cache', 0777, true);
}
if (!is_dir(__DIR__ . '/storage/logs')) {
    @mkdir(__DIR__ . '/storage/logs', 0777, true);
}

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Guarantee core view provider is bound on shared hosting
if (!$app->bound('view')) {
    $app->register(\Illuminate\View\ViewServiceProvider::class);
}

$app->handleRequest(Request::capture());