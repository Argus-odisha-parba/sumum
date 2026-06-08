<?php

require_once __DIR__ . '/bootstrap.php';
sum_admin_require_login();

require_once dirname(__DIR__) . '/includes/data.php';

$categoryOptions = sum_gallery_category_options();
$editId = isset($_GET['edit']) ? trim((string) $_GET['edit']) : '';
$editing = $editId !== '' ? sum_gallery_find_by_id($editId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $items = sum_gallery_load();

    if ($action === 'save') {
        $title = trim($_POST['title'] ?? '');
        $record = sum_gallery_normalize_record([
            'id' => $_POST['id'] ?? '',
            'title' => $title,
            'image' => $_POST['current_image'] ?? '',
            'category' => $_POST['category'] ?? 'hospital',
            'featured' => !empty($_POST['featured']),
            'priority' => $_POST['priority'] ?? 50,
            'active' => !empty($_POST['active']),
        ]);

        if (!empty($_FILES['photo']['name'])) {
            $upload = sum_gallery_upload_image($_FILES['photo']);
            if (!$upload['ok']) {
                sum_admin_flash_set('error', $upload['message']);
                header('Location: gallery.php' . ($editId ? '?edit=' . urlencode($editId) : ''));
                exit;
            }
            $record['image'] = $upload['path'];
        }

        if ($title === '') {
            sum_admin_flash_set('error', 'Photo title is required.');
            header('Location: gallery.php');
            exit;
        }

        if ($record['image'] === '') {
            sum_admin_flash_set('error', 'Please upload a photo or keep the current image.');
            header('Location: gallery.php' . ($editId ? '?edit=' . urlencode($editId) : ''));
            exit;
        }

        $found = false;
        foreach ($items as $i => $item) {
            if ($item['id'] === $record['id']) {
                $items[$i] = $record;
                $found = true;
                break;
            }
        }

        if (!$found) {
            foreach ($items as $item) {
                if ($item['id'] === $record['id']) {
                    sum_admin_flash_set('error', 'A gallery item with this title already exists.');
                    header('Location: gallery.php');
                    exit;
                }
            }
            $items[] = $record;
        }

        if (sum_gallery_save($items)) {
            sum_admin_flash_set('success', $found ? 'Gallery photo updated.' : 'Gallery photo added.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: gallery.php');
        exit;
    }

    if ($action === 'delete') {
        $deleteId = trim($_POST['delete_id'] ?? '');
        $items = array_values(array_filter($items, static fn($item) => $item['id'] !== $deleteId));
        if (sum_gallery_save($items)) {
            sum_admin_flash_set('success', 'Gallery photo removed.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: gallery.php');
        exit;
    }
}

$items = sum_gallery_load();
$flash = sum_admin_flash_get();
$adminPageTitle = $editing ? 'Edit gallery photo' : 'Gallery';
$adminActiveNav = 'gallery';
$pageTitle = $adminPageTitle;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> | SUM Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="sum-admin-body">
    <?php include __DIR__ . '/_topbar.php'; ?>

    <main class="sum-admin-main">
        <?php if ($flash): ?>
            <div class="sum-admin-alert sum-admin-alert--<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div class="sum-admin-stats">
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count($items); ?></span>
                <span class="sum-admin-stat__label">Total photos</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count(array_filter($items, static fn($i) => !empty($i['active']))); ?></span>
                <span class="sum-admin-stat__label">Live on gallery page</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count($categoryOptions); ?></span>
                <span class="sum-admin-stat__label">Categories</span>
            </div>
        </div>

        <div class="sum-admin-grid">
            <section class="sum-admin-panel sum-admin-panel--form">
                <h2><?php echo $editing ? 'Edit photo' : 'Add gallery photo'; ?></h2>
                <p class="sum-admin-panel__hint">Photos appear on the public <strong>Gallery</strong> page. Higher priority shows first. Featured photos use a wider layout.</p>

                <form method="post" enctype="multipart/form-data" class="sum-admin-form sum-admin-form--grid">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editing['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($editing['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="title">Photo title *</label>
                        <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($editing['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Modern ICU facility">
                    </div>

                    <div class="sum-admin-field">
                        <label for="category">Category *</label>
                        <select id="category" name="category" required>
                            <?php foreach ($categoryOptions as $slug => $label): ?>
                                <option value="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>"<?php echo ($editing['category'] ?? 'hospital') === $slug ? ' selected' : ''; ?>><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="sum-admin-field">
                        <label for="priority">Priority (0–9999)</label>
                        <input type="number" id="priority" name="priority" min="0" max="9999" value="<?php echo (int) ($editing['priority'] ?? 50); ?>">
                    </div>

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="photo">Photo <?php echo $editing ? '' : '*'; ?></label>
                        <?php if ($editing && !empty($editing['image'])): ?>
                            <div class="sum-admin-photo-preview sum-admin-photo-preview--gallery">
                                <img src="../<?php echo htmlspecialchars($editing['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                <span>Current photo</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"<?php echo $editing ? '' : ' required'; ?>>
                        <small>JPG, PNG or WebP — max 3 MB.<?php echo $editing ? ' Leave empty to keep current image.' : ''; ?></small>
                    </div>

                    <div class="sum-admin-field sum-admin-field--check">
                        <label class="sum-admin-check">
                            <input type="checkbox" name="featured" value="1"<?php echo !empty($editing['featured']) ? ' checked' : ''; ?>>
                            Featured (wide card on gallery page)
                        </label>
                    </div>

                    <div class="sum-admin-field sum-admin-field--check">
                        <label class="sum-admin-check">
                            <input type="checkbox" name="active" value="1"<?php echo ($editing === null || !empty($editing['active'])) ? ' checked' : ''; ?>>
                            Show on website (active)
                        </label>
                    </div>

                    <div class="sum-admin-form__actions sum-admin-field--full">
                        <button type="submit" class="sum-admin-btn sum-admin-btn--primary">
                            <i class="fas fa-save" aria-hidden="true"></i>
                            <?php echo $editing ? 'Update photo' : 'Add photo'; ?>
                        </button>
                        <?php if ($editing): ?>
                            <a href="gallery.php" class="sum-admin-btn sum-admin-btn--ghost">Cancel edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </section>

            <section class="sum-admin-panel sum-admin-panel--list">
                <h2>All photos <span class="sum-admin-badge"><?php echo count($items); ?></span></h2>
                <p class="sum-admin-panel__hint">
                    Sorted by priority (highest first).
                    <a href="../gallery.php" target="_blank" rel="noopener">Preview gallery page</a>
                </p>

                <div class="sum-admin-table-wrap">
                    <table class="sum-admin-table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item):
                                $catLabel = $categoryOptions[$item['category']] ?? $item['category'];
                            ?>
                                <tr class="<?php echo empty($item['active']) ? 'is-inactive' : ''; ?>">
                                    <td>
                                        <img class="sum-admin-table__thumb sum-admin-table__thumb--gallery" src="../<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                        <?php if (!empty($item['featured'])): ?>
                                            <span class="sum-admin-table__desc">Featured layout</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($catLabel, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><span class="sum-admin-priority"><?php echo (int) $item['priority']; ?></span></td>
                                    <td>
                                        <?php if (!empty($item['active'])): ?>
                                            <span class="sum-admin-status sum-admin-status--on">Active</span>
                                        <?php else: ?>
                                            <span class="sum-admin-status sum-admin-status--off">Hidden</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="sum-admin-table__actions">
                                        <a href="gallery.php?edit=<?php echo urlencode($item['id']); ?>" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--ghost" title="Edit"><i class="fas fa-pen" aria-hidden="true"></i></a>
                                        <form method="post" class="sum-admin-inline-form" onsubmit="return confirm('Delete this gallery photo?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--danger" title="Delete"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
