<?php

function sum_gallery_data_path(): string
{
    return dirname(__DIR__) . '/data/gallery.json';
}

function sum_gallery_category_options(): array
{
    return [
        'hospital' => 'Hospital & Infrastructure',
        'clinical' => 'Clinical Care',
        'events' => 'Events & Community',
        'technology' => 'Technology & Labs',
    ];
}

function sum_gallery_default_seed(): array
{
    $seed = [
        ['image' => 'assets/img/service/ser9-2.jpg', 'title' => 'Advanced diagnostics wing', 'category' => 'technology', 'featured' => true],
        ['image' => 'assets/img/blog/b-8-1.jpg', 'title' => 'Patient-centric care environment', 'category' => 'clinical', 'featured' => true],
        ['image' => 'assets/img/hero/h-bg-8-1.jpg', 'title' => 'SUM Ultimate Medicare campus', 'category' => 'hospital', 'featured' => true],
        ['image' => 'assets/img/service/ser9-3.jpg', 'title' => 'Modern operating theatres', 'category' => 'clinical'],
        ['image' => 'assets/img/service/ser9-4.jpg', 'title' => 'Critical care unit', 'category' => 'clinical'],
        ['image' => 'assets/img/service/ser8-1.jpg', 'title' => 'Outpatient consultation area', 'category' => 'hospital'],
        ['image' => 'assets/img/service/ser8-3.jpg', 'title' => 'Specialty clinic corridor', 'category' => 'hospital'],
        ['image' => 'assets/img/service/ser9-5.jpg', 'title' => 'Imaging & radiology suite', 'category' => 'technology'],
        ['image' => 'assets/img/service/ser9-6.jpg', 'title' => 'Laboratory services', 'category' => 'technology'],
        ['image' => 'assets/img/blog/b-8-2.jpg', 'title' => 'Rehabilitation & recovery', 'category' => 'clinical'],
        ['image' => 'assets/img/blog/b-8-3.jpg', 'title' => 'Community health outreach', 'category' => 'events'],
        ['image' => 'assets/img/widget/footer8-1.jpg', 'title' => 'Hospital reception & lobby', 'category' => 'hospital'],
        ['image' => 'assets/img/widget/footer8-2.jpg', 'title' => 'Patient waiting lounge', 'category' => 'hospital'],
        ['image' => 'assets/img/bg/why-choose1-1.jpg', 'title' => 'Clinical excellence in action', 'category' => 'clinical'],
        ['image' => 'assets/img/bg/specialist1-1.jpg', 'title' => 'Health awareness camp', 'category' => 'events'],
        ['image' => 'assets/img/service/ser8-5.jpg', 'title' => 'Nursing & patient support', 'category' => 'clinical'],
        ['image' => 'assets/img/service/ser8-6.jpg', 'title' => 'Emergency & trauma bay', 'category' => 'clinical'],
        ['image' => 'assets/img/bg/cta-bg-1-1.jpg', 'title' => 'Medical education & training', 'category' => 'events'],
    ];
    $priority = 100;
    $out = [];
    foreach ($seed as $row) {
        $out[] = sum_gallery_normalize_record([
            'id' => sum_gallery_generate_id($row['title']),
            'title' => $row['title'],
            'image' => $row['image'],
            'category' => $row['category'],
            'featured' => !empty($row['featured']),
            'priority' => $priority,
            'active' => true,
        ]);
        $priority -= 5;
    }
    return $out;
}

function sum_gallery_generate_id(string $title): string
{
    $slug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($title)), '-');
    if ($slug === '') {
        $slug = 'item';
    }
    return 'gallery-' . $slug;
}

function sum_gallery_normalize_record(array $row): array
{
    $title = trim($row['title'] ?? '');
    $id = trim($row['id'] ?? '');
    if ($id === '' && $title !== '') {
        $id = sum_gallery_generate_id($title);
    }
    $category = trim($row['category'] ?? 'hospital');
    $categories = sum_gallery_category_options();
    if (!isset($categories[$category])) {
        $category = 'hospital';
    }
    return [
        'id' => $id,
        'title' => $title,
        'image' => trim($row['image'] ?? 'assets/img/service/ser9-2.jpg'),
        'category' => $category,
        'featured' => !empty($row['featured']),
        'priority' => max(0, min(9999, (int) ($row['priority'] ?? 50))),
        'active' => !isset($row['active']) || (bool) $row['active'],
    ];
}

function sum_gallery_load(): array
{
    $path = sum_gallery_data_path();
    if (!is_file($path)) {
        $seed = sum_gallery_default_seed();
        sum_gallery_save($seed);
        return $seed;
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw ?: '[]', true);
    if (!is_array($data)) {
        return sum_gallery_default_seed();
    }
    $items = [];
    foreach ($data as $row) {
        if (!is_array($row)) {
            continue;
        }
        $items[] = sum_gallery_normalize_record($row);
    }
    return sum_gallery_sort($items);
}

function sum_gallery_save(array $items): bool
{
    $path = sum_gallery_data_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $normalized = sum_gallery_sort(array_map('sum_gallery_normalize_record', $items));
    $json = json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    return file_put_contents($path, $json . "\n", LOCK_EX) !== false;
}

function sum_gallery_sort(array $items): array
{
    usort($items, static function ($a, $b) {
        $pa = (int) ($a['priority'] ?? 0);
        $pb = (int) ($b['priority'] ?? 0);
        if ($pa !== $pb) {
            return $pb <=> $pa;
        }
        return strcasecmp($a['title'] ?? '', $b['title'] ?? '');
    });
    return $items;
}

function sum_gallery_find_by_id(string $id): ?array
{
    foreach (sum_gallery_load() as $item) {
        if ($item['id'] === $id) {
            return $item;
        }
    }
    return null;
}

function sum_gallery_public_items(): array
{
    return array_values(array_filter(sum_gallery_load(), static function ($item) {
        return !empty($item['active']);
    }));
}

function sum_gallery_upload_image(array $file): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'message' => 'No file uploaded.'];
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'message' => 'Upload failed.'];
    }
    if (($file['size'] ?? 0) > 3 * 1024 * 1024) {
        return ['ok' => false, 'message' => 'Image must be under 3 MB.'];
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
    $dir = dirname(__DIR__) . '/assets/img/gallery/';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $basename = 'gallery-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
    $dest = $dir . $basename;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'message' => 'Could not save image.'];
    }
    return ['ok' => true, 'path' => 'assets/img/gallery/' . $basename];
}
