<?php

function sum_doctors_data_path(): string
{
    return dirname(__DIR__) . '/data/doctors.json';
}

function sum_doctors_default_seed(): array
{
    $seed = [
        ['name' => 'Dr. Sarat Sahoo', 'department' => 'Cardiology', 'qualification' => 'DM (Cardiology)', 'image' => 'assets/img/team/team8-1.jpg'],
        ['name' => 'Dr. Jayant Kumar Dash', 'department' => 'General Medicine', 'qualification' => 'MD (Medicine)', 'image' => 'assets/img/team/team8-2.jpg'],
        ['name' => 'Dr. Manoj Patnaik', 'department' => 'Orthopedics', 'qualification' => 'MS (Ortho)', 'image' => 'assets/img/team/drmanojchairman-1.jpeg'],
        ['name' => 'Dr. Swetha Padma', 'department' => 'Neurology', 'qualification' => 'DM (Neurology)', 'image' => 'assets/img/team/Swethapadma-1.jpg'],
        ['name' => 'Dr. Biraj Mohanty', 'department' => 'Gastroenterology', 'qualification' => 'DM (Gastro)', 'image' => 'assets/img/team/biraj-1.jpg'],
        ['name' => 'Dr. Priya Mohanty', 'department' => 'Oncology', 'qualification' => 'MD (Oncology)', 'image' => 'assets/img/team/team8-3.jpg'],
        ['name' => 'Dr. Rakesh Das', 'department' => 'Nephrology', 'qualification' => 'DM (Nephrology)', 'image' => 'assets/img/team/team8-4.jpg'],
        ['name' => 'Dr. Anil Behera', 'department' => 'Pulmonology', 'qualification' => 'MD (Pulmonary)', 'image' => 'assets/img/team/team2-1.jpg'],
        ['name' => 'Dr. Smita Patra', 'department' => 'Urology', 'qualification' => 'MCh (Urology)', 'image' => 'assets/img/team/t-1-1.png'],
        ['name' => 'Dr. Rohit Nayak', 'department' => 'Emergency Medicine', 'qualification' => 'MD (Emergency)', 'image' => 'assets/img/team/t-1-2.png'],
        ['name' => 'Dr. Kiran Sahu', 'department' => 'Critical Care', 'qualification' => 'DM (Critical Care)', 'image' => 'assets/img/team/t-1-3.png'],
        ['name' => 'Dr. Meera Tripathy', 'department' => 'Cardiology', 'qualification' => 'MD, DM (Cardiology)', 'image' => 'assets/img/team/team2-2.jpg'],
    ];
    $priority = 100;
    $out = [];
    foreach ($seed as $row) {
        $out[] = [
            'id' => sum_doctor_generate_id($row['name']),
            'name' => $row['name'],
            'description' => '',
            'image' => $row['image'],
            'department' => $row['department'],
            'qualification' => $row['qualification'],
            'priority' => $priority,
            'active' => true,
        ];
        $priority -= 5;
    }
    return $out;
}

function sum_doctor_generate_id(string $name): string
{
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $name), '-'));
    return 'dr-' . $slug;
}

function sum_doctors_normalize_record(array $row): array
{
    $name = trim($row['name'] ?? '');
    $id = trim($row['id'] ?? '');
    if ($id === '') {
        $id = sum_doctor_generate_id($name);
    }
    return [
        'id' => $id,
        'name' => $name,
        'description' => trim($row['description'] ?? ''),
        'image' => trim($row['image'] ?? 'assets/img/team/team8-1.jpg'),
        'department' => trim($row['department'] ?? 'General Medicine'),
        'qualification' => trim($row['qualification'] ?? ''),
        'priority' => max(0, min(9999, (int) ($row['priority'] ?? 50))),
        'active' => !isset($row['active']) || (bool) $row['active'],
    ];
}

function sum_doctors_load(): array
{
    $path = sum_doctors_data_path();
    if (!is_file($path)) {
        $seed = sum_doctors_default_seed();
        sum_doctors_save($seed);
        return $seed;
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw ?: '[]', true);
    if (!is_array($data)) {
        return sum_doctors_default_seed();
    }
    $doctors = [];
    foreach ($data as $row) {
        if (!is_array($row)) {
            continue;
        }
        $doctors[] = sum_doctors_normalize_record($row);
    }
    return sum_doctors_sort($doctors);
}

function sum_doctors_save(array $doctors): bool
{
    $path = sum_doctors_data_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $normalized = sum_doctors_sort(array_map('sum_doctors_normalize_record', $doctors));
    $json = json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    return file_put_contents($path, $json . "\n", LOCK_EX) !== false;
}

function sum_doctors_sort(array $doctors): array
{
    usort($doctors, static function ($a, $b) {
        $pa = (int) ($a['priority'] ?? 0);
        $pb = (int) ($b['priority'] ?? 0);
        if ($pa !== $pb) {
            return $pb <=> $pa;
        }
        return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
    });
    return $doctors;
}

function sum_doctors_find_by_id(string $id): ?array
{
    foreach (sum_doctors_load() as $doc) {
        if ($doc['id'] === $id) {
            return $doc;
        }
    }
    return null;
}

function sum_doctors_upload_image(array $file): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'message' => 'No file uploaded.'];
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'message' => 'Upload failed.'];
    }
    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        return ['ok' => false, 'message' => 'Image must be under 2 MB.'];
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    if (!isset($allowed[$mime])) {
        return ['ok' => false, 'message' => 'Use JPG, PNG, or WebP only.'];
    }
    $dir = dirname(__DIR__) . '/assets/img/team/';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $basename = 'doctor-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
    $dest = $dir . $basename;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'message' => 'Could not save image.'];
    }
    return ['ok' => true, 'path' => 'assets/img/team/' . $basename];
}
