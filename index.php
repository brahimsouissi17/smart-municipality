<?php

declare(strict_types=1);

require __DIR__ . '/config/config.php';
require __DIR__ . '/app/Core/Autoloader.php';

use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\MapController;
use App\Controllers\SignalementController;

$route = $_GET['route'] ?? 'home/index';

$routes = [
    'home/index' => [HomeController::class, 'index'],
    'signalements/create' => [SignalementController::class, 'create'],
    'signalements/store' => [SignalementController::class, 'store'],
    'signalements/list' => [SignalementController::class, 'list'],
    'signalements/detail' => [SignalementController::class, 'detail'],
    'admin/list' => [AdminController::class, 'index'],
    'admin/edit' => [AdminController::class, 'edit'],
    'admin/delete' => [AdminController::class, 'delete'],
    'map/data' => [MapController::class, 'data'],
];

if (!isset($routes[$route])) {
    http_response_code(404);
    echo 'Route introuvable.';
    exit;
}

[$class, $method] = $routes[$route];
$controller = new $class();
$controller->$method();
