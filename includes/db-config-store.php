<?php

function sum_db_config_path(): string
{
    return dirname(__DIR__) . '/data/db-config.php';
}

function sum_db_config_defaults(): array
{
    return [
        'DB_HOST' => 'localhost',
        'DB_NAME' => '',
        'DB_USERNAME' => 'root',
        'DB_PORT' => '3306',
        'DB_PASSWORD' => '',
    ];
}

function sum_db_config_normalize(array $row): array
{
    $defaults = sum_db_config_defaults();
    $out = [];
    foreach ($defaults as $key => $default) {
        $out[$key] = trim((string) ($row[$key] ?? $default));
    }
    $out['DB_PORT'] = (string) max(1, min(65535, (int) ($out['DB_PORT'] ?: 3306)));
    return $out;
}

function sum_db_config_load(): array
{
    $path = sum_db_config_path();
    if (!is_file($path)) {
        return sum_db_config_defaults();
    }
    $cfg = require $path;
    return sum_db_config_normalize(is_array($cfg) ? $cfg : []);
}

function sum_db_config_save(array $data): bool
{
    $normalized = sum_db_config_normalize($data);
    $path = sum_db_config_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $lines = ["<?php", "", "return ["];
    foreach ($normalized as $key => $value) {
        $lines[] = "    '" . $key . "' => " . var_export($value, true) . ',';
    }
    $lines[] = '];';
    $lines[] = '';

    return file_put_contents($path, implode("\n", $lines), LOCK_EX) !== false;
}

function sum_db_config_test(?array $config = null): array
{
    $cfg = sum_db_config_normalize($config ?? sum_db_config_load());

    if ($cfg['DB_HOST'] === '' || $cfg['DB_NAME'] === '' || $cfg['DB_USERNAME'] === '') {
        return ['ok' => false, 'message' => 'DB_HOST, DB_NAME, and DB_USERNAME are required.'];
    }

    if (!extension_loaded('mysqli')) {
        return ['ok' => false, 'message' => 'MySQLi extension is not enabled in PHP.'];
    }

    mysqli_report(MYSQLI_REPORT_OFF);
    $mysqli = @new mysqli(
        $cfg['DB_HOST'],
        $cfg['DB_USERNAME'],
        $cfg['DB_PASSWORD'],
        $cfg['DB_NAME'],
        (int) $cfg['DB_PORT']
    );

    if ($mysqli->connect_errno) {
        return ['ok' => false, 'message' => 'Connection failed: ' . $mysqli->connect_error];
    }

    $mysqli->close();
    return ['ok' => true, 'message' => 'Database connection successful.'];
}

function sum_db_get_connection(): ?mysqli
{
    static $conn = null;
    static $loaded = false;

    if ($loaded) {
        return $conn;
    }
    $loaded = true;

    $cfg = sum_db_config_load();
    if ($cfg['DB_HOST'] === '' || $cfg['DB_NAME'] === '' || $cfg['DB_USERNAME'] === '') {
        return null;
    }
    if (!extension_loaded('mysqli')) {
        return null;
    }

    mysqli_report(MYSQLI_REPORT_OFF);
    $mysqli = @new mysqli(
        $cfg['DB_HOST'],
        $cfg['DB_USERNAME'],
        $cfg['DB_PASSWORD'],
        $cfg['DB_NAME'],
        (int) $cfg['DB_PORT']
    );

    if ($mysqli->connect_errno) {
        return null;
    }

    $conn = $mysqli;
    return $conn;
}
