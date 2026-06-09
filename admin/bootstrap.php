<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once dirname(__DIR__) . '/includes/doctors-store.php';

function sum_admin_config(): array
{
    $path = dirname(__DIR__) . '/data/admin-config.php';
    if (!is_file($path)) {
        return ['password' => 'sumum2026'];
    }
    $cfg = require $path;
    return is_array($cfg) ? $cfg : ['password' => 'sumum2026'];
}

function sum_admin_is_logged_in(): bool
{
    return !empty($_SESSION['sum_admin_logged_in']);
}

function sum_admin_require_login(): void
{
    if (!sum_admin_is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function sum_admin_flash_set(string $type, string $message): void
{
    $_SESSION['sum_admin_flash'] = ['type' => $type, 'message' => $message];
}

function sum_admin_flash_get(): ?array
{
    if (empty($_SESSION['sum_admin_flash'])) {
        return null;
    }
    $flash = $_SESSION['sum_admin_flash'];
    unset($_SESSION['sum_admin_flash']);
    return $flash;
}
