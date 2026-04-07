<?php

declare(strict_types=1);

session_start();

define('APP_NAME', 'Smart Municipality');
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/smart-municipality');
define('UPLOAD_PATH', BASE_PATH . '/public/uploads/');
define('UPLOAD_URL', BASE_URL . '/public/uploads/');

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'smart_municipality');
define('DB_USER', 'root');
define('DB_PASS', '');

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'id' => 1,
        'nom' => 'Citoyen Demo',
        'email' => 'citoyen@demo.tn',
        'role' => 'citoyen',
    ];
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $route): void
{
    header('Location: ' . BASE_URL . '/index.php?route=' . $route);
    exit;
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}
