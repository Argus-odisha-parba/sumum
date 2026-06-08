<?php

require_once __DIR__ . '/bootstrap.php';
sum_admin_require_login();

require_once dirname(__DIR__) . '/includes/data.php';

$editId = isset($_GET['edit']) ? trim((string) $_GET['edit']) : '';
$editing = $editId !== '' ? sum_departments_find_by_id($editId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $departments = sum_departments_load();

    if ($action === 'save') {
        $name = trim($_POST['name'] ?? '');
        $record = sum_departments_normalize_record([
            'id' => $_POST['id'] ?? '',
            'name' => $name,
            'overview' => $_POST['overview'] ?? '',
            'priority' => $_POST['priority'] ?? 50,
            'active' => !empty($_POST['active']),
        ]);

        if ($name === '') {
            sum_admin_flash_set('error', 'Department name is required.');
            header('Location: departments.php' . ($editId ? '?edit=' . urlencode($editId) : ''));
            exit;
        }

        $found = false;
        $previousName = null;
        foreach ($departments as $i => $dept) {
            if ($dept['id'] === $record['id']) {
                $previousName = $dept['name'];
                $departments[$i] = $record;
                $found = true;
                break;
            }
        }

        if ($found && $previousName !== null && strcasecmp($previousName, $record['name']) !== 0) {
            $doctors = sum_doctors_load();
            $renamed = false;
            foreach ($doctors as $i => $doc) {
                if (strcasecmp($doc['department'] ?? '', $previousName) === 0) {
                    $doctors[$i]['department'] = $record['name'];
                    $renamed = true;
                }
            }
            if ($renamed) {
                sum_doctors_save($doctors);
            }
        }

        if (!$found) {
            foreach ($departments as $dept) {
                if (strcasecmp($dept['name'], $record['name']) === 0) {
                    sum_admin_flash_set('error', 'A department with this name already exists.');
                    header('Location: departments.php');
                    exit;
                }
            }
            $departments[] = $record;
        }

        if (sum_departments_save($departments)) {
            sum_admin_flash_set('success', $found ? 'Department updated.' : 'Department added.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: departments.php');
        exit;
    }

    if ($action === 'delete') {
        $deleteId = trim($_POST['delete_id'] ?? '');
        $target = sum_departments_find_by_id($deleteId);
        if ($target) {
            $doctorCount = sum_doctors_count_in_department($target['name']);
            if ($doctorCount > 0) {
                sum_admin_flash_set('error', 'Cannot delete — ' . $doctorCount . ' doctor(s) are assigned to this department.');
                header('Location: departments.php');
                exit;
            }
        }
        $departments = array_values(array_filter($departments, static fn($d) => $d['id'] !== $deleteId));
        if (sum_departments_save($departments)) {
            sum_admin_flash_set('success', 'Department removed.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: departments.php');
        exit;
    }
}

$departments = sum_departments_load();
$doctors = sum_doctors_load();
$flash = sum_admin_flash_get();
$adminPageTitle = $editing ? 'Edit department' : 'Departments';
$adminActiveNav = 'departments';
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
                <span class="sum-admin-stat__value"><?php echo count($departments); ?></span>
                <span class="sum-admin-stat__label">Total departments</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count(array_filter($departments, static fn($d) => !empty($d['active']))); ?></span>
                <span class="sum-admin-stat__label">Active on site</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count($doctors); ?></span>
                <span class="sum-admin-stat__label">Doctor profiles</span>
            </div>
        </div>

        <div class="sum-admin-grid">
            <section class="sum-admin-panel sum-admin-panel--form">
                <h2><?php echo $editing ? 'Edit department' : 'Add department'; ?></h2>
                <p class="sum-admin-panel__hint">Departments appear on the website and in the <strong>doctor</strong> form dropdown. Higher priority lists first.</p>

                <form method="post" class="sum-admin-form sum-admin-form--grid">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editing['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="name">Department name *</label>
                        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($editing['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Cardiology">
                    </div>

                    <div class="sum-admin-field">
                        <label for="priority">Priority (0–9999)</label>
                        <input type="number" id="priority" name="priority" min="0" max="9999" value="<?php echo (int) ($editing['priority'] ?? 50); ?>">
                    </div>

                    <div class="sum-admin-field sum-admin-field--check">
                        <label class="sum-admin-check">
                            <input type="checkbox" name="active" value="1"<?php echo ($editing === null || !empty($editing['active'])) ? ' checked' : ''; ?>>
                            Show on website (active)
                        </label>
                    </div>

                    <div class="sum-admin-field sum-admin-field--full">
                        <label for="overview">Overview (optional)</label>
                        <textarea id="overview" name="overview" rows="4" placeholder="Short description for the department page…"><?php echo htmlspecialchars($editing['overview'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="sum-admin-form__actions sum-admin-field--full">
                        <button type="submit" class="sum-admin-btn sum-admin-btn--primary">
                            <i class="fas fa-save" aria-hidden="true"></i>
                            <?php echo $editing ? 'Update department' : 'Add department'; ?>
                        </button>
                        <?php if ($editing): ?>
                            <a href="departments.php" class="sum-admin-btn sum-admin-btn--ghost">Cancel edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </section>

            <section class="sum-admin-panel sum-admin-panel--list">
                <h2>All departments <span class="sum-admin-badge"><?php echo count($departments); ?></span></h2>
                <p class="sum-admin-panel__hint">Sorted by priority (highest first).</p>

                <div class="sum-admin-table-wrap">
                    <table class="sum-admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Doctors</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($departments as $dept):
                                $docCount = sum_doctors_count_in_department($dept['name']);
                            ?>
                                <tr class="<?php echo empty($dept['active']) ? 'is-inactive' : ''; ?>">
                                    <td>
                                        <strong><?php echo htmlspecialchars($dept['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                        <?php if (!empty($dept['overview'])): ?>
                                            <span class="sum-admin-table__desc"><?php echo htmlspecialchars(sum_excerpt($dept['overview'], 70), ENT_QUOTES, 'UTF-8'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo (int) $docCount; ?></td>
                                    <td><span class="sum-admin-priority"><?php echo (int) $dept['priority']; ?></span></td>
                                    <td>
                                        <?php if (!empty($dept['active'])): ?>
                                            <span class="sum-admin-status sum-admin-status--on">Active</span>
                                        <?php else: ?>
                                            <span class="sum-admin-status sum-admin-status--off">Hidden</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="sum-admin-table__actions">
                                        <a href="departments.php?edit=<?php echo urlencode($dept['id']); ?>" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--ghost" title="Edit"><i class="fas fa-pen" aria-hidden="true"></i></a>
                                        <form method="post" class="sum-admin-inline-form" onsubmit="return confirm('Delete this department?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($dept['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--danger" title="Delete"<?php echo $docCount > 0 ? ' disabled' : ''; ?>><i class="fas fa-trash" aria-hidden="true"></i></button>
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
