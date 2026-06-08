<?php

function sum_departments_data_path(): string
{
    return dirname(__DIR__) . '/data/departments.json';
}

function sum_department_generate_id(string $name): string
{
    return sum_dept_slug($name);
}

function sum_departments_default_seed(): array
{
    $names = [
        'Cardiology',
        'Neurology',
        'Nephrology',
        'Orthopedics',
        'Pulmonology',
        'Gastroenterology',
        'Oncology',
        'Urology',
        'General Medicine',
        'Critical Care',
        'Emergency Medicine',
    ];
    $priority = 100;
    $out = [];
    foreach ($names as $name) {
        $out[] = [
            'id' => sum_department_generate_id($name),
            'name' => $name,
            'overview' => '',
            'priority' => $priority,
            'active' => true,
        ];
        $priority -= 5;
    }
    return $out;
}

function sum_departments_normalize_record(array $row): array
{
    $name = trim($row['name'] ?? '');
    $id = trim($row['id'] ?? '');
    if ($id === '' && $name !== '') {
        $id = sum_department_generate_id($name);
    }
    return [
        'id' => $id,
        'name' => $name,
        'overview' => trim($row['overview'] ?? ''),
        'priority' => max(0, min(9999, (int) ($row['priority'] ?? 50))),
        'active' => !isset($row['active']) || (bool) $row['active'],
    ];
}

function sum_departments_load(): array
{
    $path = sum_departments_data_path();
    if (!is_file($path)) {
        $seed = sum_departments_default_seed();
        sum_departments_save($seed);
        return $seed;
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw ?: '[]', true);
    if (!is_array($data)) {
        return sum_departments_default_seed();
    }
    $departments = [];
    foreach ($data as $row) {
        if (!is_array($row)) {
            continue;
        }
        $departments[] = sum_departments_normalize_record($row);
    }
    return sum_departments_sort($departments);
}

function sum_departments_save(array $departments): bool
{
    $path = sum_departments_data_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $normalized = sum_departments_sort(array_map('sum_departments_normalize_record', $departments));
    $json = json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    return file_put_contents($path, $json . "\n", LOCK_EX) !== false;
}

function sum_departments_sort(array $departments): array
{
    usort($departments, static function ($a, $b) {
        $pa = (int) ($a['priority'] ?? 0);
        $pb = (int) ($b['priority'] ?? 0);
        if ($pa !== $pb) {
            return $pb <=> $pa;
        }
        return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
    });
    return $departments;
}

function sum_departments_find_by_id(string $id): ?array
{
    foreach (sum_departments_load() as $dept) {
        if ($dept['id'] === $id) {
            return $dept;
        }
    }
    return null;
}

function sum_departments_active_names(): array
{
    $names = [];
    foreach (sum_departments_load() as $dept) {
        if (!empty($dept['active']) && $dept['name'] !== '') {
            $names[] = $dept['name'];
        }
    }
    return $names;
}

function sum_departments_names_for_select(?string $includeName = null): array
{
    $names = sum_departments_active_names();
    if ($includeName !== null && $includeName !== '' && !in_array($includeName, $names, true)) {
        $names[] = $includeName;
        sort($names, SORT_NATURAL | SORT_FLAG_CASE);
    }
    return $names;
}

function sum_doctors_count_in_department(string $deptName): int
{
    $count = 0;
    foreach (sum_doctors_load() as $doc) {
        if (strcasecmp($doc['department'] ?? '', $deptName) === 0) {
            $count++;
        }
    }
    return $count;
}
