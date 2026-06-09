<?php

function sum_contact_data_path(): string
{
    return dirname(__DIR__) . '/data/contact.json';
}

function sum_contact_defaults(): array
{
    return [
        'email' => 'sumum_bbsr@soahospitals.com',
        'epabx_display' => '+91 0674 3 500 500',
        'epabx_tel' => '+916743500500',
        'ambulance_display' => '+91 0674 266 1111',
        'ambulance_tel' => '+916742661111',
        'address' => "K-8, Kalinga Nagar, Ghatikia,\nBhubaneswar, 751003, Odisha",
        'address_short' => 'K-8, Kalinga Nagar, Bhubaneswar 751003',
        'map_url' => 'https://goo.gl/maps/Eub6yxPCTxFu5UZx7',
        'hours_weekdays' => '8:00 am - 8:00 pm',
        'hours_saturday' => '9:00 am - 6:00 pm',
        'hours_sunday' => '9:00 am - 6:00 pm',
        'hours_summary' => 'Mon – Sun 08:00 – 18:00',
        'hours_compact' => '08:00 – 18:00',
        'contact_intro' => 'Reach us for appointments, support, and emergency assistance.',
        'appointment_url' => 'appointment.php',
    ];
}

function sum_appointment_url(array $query = []): string
{
    $url = sum_contact_val('appointment_url');
    if ($url === '') {
        $url = 'appointment.php';
    }
    if (!empty($query)) {
        $url .= (strpos($url, '?') !== false ? '&' : '?') . http_build_query($query);
    }
    return $url;
}

function sum_appointment_is_external(): bool
{
    $url = sum_contact_val('appointment_url');
    return (bool) preg_match('#^https?://#i', $url);
}

function sum_appointment_link_attrs(): string
{
    return sum_appointment_is_external() ? ' target="_blank" rel="noopener"' : '';
}

function sum_contact_normalize(array $row): array
{
    $defaults = sum_contact_defaults();
    $out = [];
    foreach ($defaults as $key => $default) {
        $value = isset($row[$key]) ? trim((string) $row[$key]) : $default;
        $out[$key] = $value !== '' ? $value : $default;
    }
    return $out;
}

function sum_contact_load(): array
{
    $path = sum_contact_data_path();
    if (!is_file($path)) {
        $defaults = sum_contact_defaults();
        sum_contact_save($defaults);
        return $defaults;
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw ?: '{}', true);
    if (!is_array($data)) {
        return sum_contact_defaults();
    }
    return sum_contact_normalize($data);
}

function sum_contact_save(array $data): bool
{
    $path = sum_contact_data_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $normalized = sum_contact_normalize($data);
    $json = json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    return file_put_contents($path, $json . "\n", LOCK_EX) !== false;
}

function sum_contact_val(string $key): string
{
    global $contactDetails;
    return (string) ($contactDetails[$key] ?? sum_contact_defaults()[$key] ?? '');
}

function sum_contact_e(string $key): string
{
    return htmlspecialchars(sum_contact_val($key), ENT_QUOTES, 'UTF-8');
}
