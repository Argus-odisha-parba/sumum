<?php

require_once __DIR__ . '/bootstrap.php';
sum_admin_require_login();

require_once dirname(__DIR__) . '/includes/data.php';

$editId = isset($_GET['edit']) ? trim((string) $_GET['edit']) : '';
$editing = $editId !== '' ? sum_doctors_find_by_id($editId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $doctors = sum_doctors_load();

    if ($action === 'save') {
        $record = sum_doctors_normalize_record([
            'id' => $_POST['id'] ?? '',
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'image' => $_POST['current_image'] ?? '',
            'department' => $_POST['department'] ?? '',
            'qualification' => $_POST['qualification'] ?? '',
            'priority' => $_POST['priority'] ?? 50,
            'active' => !empty($_POST['active']),
        ]);

        if (!empty($_FILES['photo']['name'])) {
            $upload = sum_doctors_upload_image($_FILES['photo']);
            if (!$upload['ok']) {
                sum_admin_flash_set('error', $upload['message']);
                header('Location: doctors.php' . ($editId ? '?edit=' . urlencode($editId) : ''));
                exit;
            }
            $record['image'] = $upload['path'];
        }

        if ($record['name'] === '') {
            sum_admin_flash_set('error', 'Doctor name is required.');
            header('Location: doctors.php');
            exit;
        }

        $found = false;
        foreach ($doctors as $i => $doc) {
            if ($doc['id'] === $record['id']) {
                $doctors[$i] = $record;
                $found = true;
                break;
            }
        }
        if (!$found) {
            foreach ($doctors as $doc) {
                if ($doc['id'] === $record['id']) {
                    sum_admin_flash_set('error', 'A doctor with this name already exists.');
                    header('Location: doctors.php');
                    exit;
                }
            }
            $doctors[] = $record;
        }

        if (sum_doctors_save($doctors)) {
            sum_admin_flash_set('success', $found ? 'Doctor profile updated.' : 'Doctor profile added.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: doctors.php');
        exit;
    }

    if ($action === 'delete') {
        $deleteId = trim($_POST['delete_id'] ?? '');
        $doctors = array_values(array_filter($doctors, static fn($d) => $d['id'] !== $deleteId));
        if (sum_doctors_save($doctors)) {
            sum_admin_flash_set('success', 'Doctor removed.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: doctors.php');
        exit;
    }
}

$doctors = sum_doctors_load();
$departmentOptions = sum_departments_names_for_select($editing['department'] ?? null);
$flash = sum_admin_flash_get();
$adminPageTitle = $editing ? 'Edit doctor' : 'Doctors';
$adminActiveNav = 'doctors';
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
                <span class="sum-admin-stat__value"><?php echo count($doctors); ?></span>
                <span class="sum-admin-stat__label">Total doctors</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count(array_filter($doctors, static fn($d) => $d['active'])); ?></span>
                <span class="sum-admin-stat__label">Active on site</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count($departmentItems); ?></span>
                <span class="sum-admin-stat__label">Departments</span>
            </div>
        </div>

        <div class="sum-admin-grid">
            <section class="sum-admin-panel sum-admin-panel--form">
                <h2><?php echo $editing ? 'Edit doctor' : 'Add new doctor'; ?></h2>
                <p class="sum-admin-panel__hint">Higher <strong>priority</strong> appears first on the Doctors page.</p>

                <form method="post" enctype="multipart/form-data" class="sum-admin-form sum-admin-form--grid">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editing['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($editing['image'] ?? 'assets/img/team/team8-1.jpg', ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="name">Full name *</label>
                        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($editing['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Dr. Example Name">
                    </div>

                    <div class="sum-admin-field">
                        <label for="department">Department *</label>
                        <select id="department" name="department" required>
                            <?php if (empty($departmentOptions)): ?>
                                <option value="">No departments — add one first</option>
                            <?php else: ?>
                                <?php foreach ($departmentOptions as $dept): ?>
                                    <option value="<?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?>"<?php echo ($editing['department'] ?? '') === $dept ? ' selected' : ''; ?>><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small><a href="departments.php">Manage departments</a></small>
                    </div>

                    <div class="sum-admin-field">
                        <label for="priority">Priority (0–9999)</label>
                        <input type="number" id="priority" name="priority" min="0" max="9999" value="<?php echo (int) ($editing['priority'] ?? 50); ?>">
                    </div>

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="qualification">Qualification</label>
                        <input type="text" id="qualification" name="qualification" value="<?php echo htmlspecialchars($editing['qualification'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="MD, DM (Cardiology)">
                    </div>

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="description">Description / bio</label>
                        <textarea id="description" name="description" rows="4" placeholder="Short profile shown on the doctors listing…"><?php echo htmlspecialchars($editing['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="photo">Photo</label>
                        <?php if ($editing && !empty($editing['image'])): ?>
                            <div class="sum-admin-photo-preview">
                                <img src="../<?php echo htmlspecialchars($editing['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                <span>Current photo</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp">
                        <small>JPG, PNG or WebP — max 2 MB. Leave empty to keep current image.</small>
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
                            <?php echo $editing ? 'Update doctor' : 'Add doctor'; ?>
                        </button>
                        <?php if ($editing): ?>
                            <a href="doctors.php" class="sum-admin-btn sum-admin-btn--ghost">Cancel edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </section>

            <section class="sum-admin-panel sum-admin-panel--list">
                <h2>All profiles <span class="sum-admin-badge"><?php echo count($doctors); ?></span></h2>
                <p class="sum-admin-panel__hint">Sorted by priority (highest first).</p>

                <div class="sum-admin-table-wrap">
                    <table class="sum-admin-table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctors as $doc): ?>
                                <tr class="<?php echo empty($doc['active']) ? 'is-inactive' : ''; ?>">
                                    <td>
                                        <img class="sum-admin-table__thumb" src="../<?php echo htmlspecialchars($doc['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($doc['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                        <?php if (!empty($doc['description'])): ?>
                                            <span class="sum-admin-table__desc"><?php echo htmlspecialchars(sum_excerpt($doc['description'], 60), ENT_QUOTES, 'UTF-8'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($doc['department'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><span class="sum-admin-priority"><?php echo (int) $doc['priority']; ?></span></td>
                                    <td>
                                        <?php if (!empty($doc['active'])): ?>
                                            <span class="sum-admin-status sum-admin-status--on">Active</span>
                                        <?php else: ?>
                                            <span class="sum-admin-status sum-admin-status--off">Hidden</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="sum-admin-table__actions">
                                        <a href="doctors.php?edit=<?php echo urlencode($doc['id']); ?>" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--ghost" title="Edit"><i class="fas fa-pen" aria-hidden="true"></i></a>
                                        <form method="post" class="sum-admin-inline-form" onsubmit="return confirm('Delete this doctor profile?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($doc['id'], ENT_QUOTES, 'UTF-8'); ?>">
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
