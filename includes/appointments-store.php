<?php

function sum_appointments_data_path(): string
{
    return dirname(__DIR__) . '/data/appointments.json';
}

function sum_appointment_generate_id(): string
{
    return 'appt-' . date('Ymd-His') . '-' . bin2hex(random_bytes(3));
}

function sum_appointments_normalize_record(array $row): array
{
    $status = trim($row['status'] ?? 'new');
    $allowed = ['new', 'contacted', 'completed', 'cancelled'];
    if (!in_array($status, $allowed, true)) {
        $status = 'new';
    }

    return [
        'id' => trim($row['id'] ?? '') ?: sum_appointment_generate_id(),
        'service' => trim($row['service'] ?? ''),
        'appointment_date' => trim($row['appointment_date'] ?? ''),
        'appointment_time' => trim($row['appointment_time'] ?? ''),
        'name' => trim($row['name'] ?? ''),
        'email' => trim($row['email'] ?? ''),
        'phone' => trim($row['phone'] ?? ''),
        'status' => $status,
        'created_at' => trim($row['created_at'] ?? '') ?: date('c'),
    ];
}

function sum_appointments_load(): array
{
    $path = sum_appointments_data_path();
    if (!is_file($path)) {
        return [];
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw ?: '[]', true);
    if (!is_array($data)) {
        return [];
    }
    $items = [];
    foreach ($data as $row) {
        if (!is_array($row)) {
            continue;
        }
        $items[] = sum_appointments_normalize_record($row);
    }
    return sum_appointments_sort($items);
}

function sum_appointments_save(array $items): bool
{
    $path = sum_appointments_data_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $normalized = sum_appointments_sort(array_map('sum_appointments_normalize_record', $items));
    $json = json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    return file_put_contents($path, $json . "\n", LOCK_EX) !== false;
}

function sum_appointments_sort(array $items): array
{
    usort($items, static function ($a, $b) {
        return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
    });
    return $items;
}

function sum_appointments_find_by_id(string $id): ?array
{
    foreach (sum_appointments_load() as $item) {
        if ($item['id'] === $id) {
            return $item;
        }
    }
    return null;
}

function sum_appointments_add(array $row): bool
{
    $items = sum_appointments_load();
    $items[] = sum_appointments_normalize_record($row);
    return sum_appointments_save($items);
}

function sum_appointments_count_by_status(string $status): int
{
    $count = 0;
    foreach (sum_appointments_load() as $item) {
        if (($item['status'] ?? '') === $status) {
            $count++;
        }
    }
    return $count;
}

function sum_appointment_status_label(string $status): string
{
    $labels = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
    return $labels[$status] ?? ucfirst($status);
}
