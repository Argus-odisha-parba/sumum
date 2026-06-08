<?php

require_once __DIR__ . '/bootstrap.php';
sum_admin_require_login();

require_once dirname(__DIR__) . '/includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $items = sum_appointments_load();

    if ($action === 'status') {
        $id = trim($_POST['id'] ?? '');
        $status = trim($_POST['status'] ?? 'new');
        foreach ($items as $i => $item) {
            if ($item['id'] === $id) {
                $items[$i] = sum_appointments_normalize_record(array_merge($item, ['status' => $status]));
                break;
            }
        }
        if (sum_appointments_save($items)) {
            sum_admin_flash_set('success', 'Appointment status updated.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: appointments.php' . (isset($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
        exit;
    }

    if ($action === 'delete') {
        $deleteId = trim($_POST['delete_id'] ?? '');
        $items = array_values(array_filter($items, static fn($item) => $item['id'] !== $deleteId));
        if (sum_appointments_save($items)) {
            sum_admin_flash_set('success', 'Appointment removed.');
        } else {
            sum_admin_flash_set('error', 'Could not save data.');
        }
        header('Location: appointments.php');
        exit;
    }
}

$filter = isset($_GET['status']) ? trim((string) $_GET['status']) : 'all';
$allowedFilters = ['all', 'new', 'contacted', 'completed', 'cancelled'];
if (!in_array($filter, $allowedFilters, true)) {
    $filter = 'all';
}

$items = sum_appointments_load();
if ($filter !== 'all') {
    $items = array_values(array_filter($items, static fn($item) => ($item['status'] ?? '') === $filter));
}

$flash = sum_admin_flash_get();
$adminPageTitle = 'Appointments';
$adminActiveNav = 'appointments';
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

        <div class="sum-admin-stats sum-admin-stats--4">
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo count(sum_appointments_load()); ?></span>
                <span class="sum-admin-stat__label">Total requests</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo sum_appointments_count_by_status('new'); ?></span>
                <span class="sum-admin-stat__label">New</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo sum_appointments_count_by_status('contacted'); ?></span>
                <span class="sum-admin-stat__label">Contacted</span>
            </div>
            <div class="sum-admin-stat">
                <span class="sum-admin-stat__value"><?php echo sum_appointments_count_by_status('completed'); ?></span>
                <span class="sum-admin-stat__label">Completed</span>
            </div>
        </div>

        <section class="sum-admin-panel sum-admin-panel--list">
            <div class="sum-admin-panel__headrow">
                <div>
                    <h2>Book An Appointment — form submissions</h2>
                    <p class="sum-admin-panel__hint mb-0">All fields from the homepage form: type of service, date, time, name, email, and phone number.</p>
                </div>
                <a href="../index.php#book-appointment" class="sum-admin-btn sum-admin-btn--ghost" target="_blank" rel="noopener">View form</a>
            </div>

            <div class="sum-admin-filter-tabs">
                <?php
                $tabs = [
                    'all' => 'All',
                    'new' => 'New',
                    'contacted' => 'Contacted',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ];
                foreach ($tabs as $key => $label):
                ?>
                    <a href="appointments.php?status=<?php echo urlencode($key); ?>" class="sum-admin-filter-tab<?php echo $filter === $key ? ' is-active' : ''; ?>"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></a>
                <?php endforeach; ?>
            </div>

            <?php if (empty($items)): ?>
                <p class="sum-admin-empty">No appointment requests<?php echo $filter !== 'all' ? ' with this status' : ''; ?> yet.</p>
            <?php else: ?>
                <div class="sum-admin-appt-cards sum-admin-appt-cards--full">
                    <?php foreach ($items as $item):
                        $submitted = $item['created_at'] ?? '';
                        $submittedDisplay = $submitted !== '' ? date('d M Y, h:i A', strtotime($submitted)) : '—';
                    ?>
                        <article class="sum-admin-appt-card<?php echo ($item['status'] ?? '') === 'new' ? ' sum-admin-appt-card--new' : ''; ?>" id="appt-<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="sum-admin-appt-card__head">
                                <div>
                                    <h3><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <span class="sum-admin-appt-card__meta">Submitted <?php echo htmlspecialchars($submittedDisplay, ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <form method="post" class="sum-admin-status-form">
                                    <input type="hidden" name="action" value="status">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <select name="status" class="sum-admin-status-select sum-admin-status-select--<?php echo htmlspecialchars($item['status'], ENT_QUOTES, 'UTF-8'); ?>" onchange="this.form.submit()" aria-label="Update status">
                                        <option value="new"<?php echo $item['status'] === 'new' ? ' selected' : ''; ?>>New</option>
                                        <option value="contacted"<?php echo $item['status'] === 'contacted' ? ' selected' : ''; ?>>Contacted</option>
                                        <option value="completed"<?php echo $item['status'] === 'completed' ? ' selected' : ''; ?>>Completed</option>
                                        <option value="cancelled"<?php echo $item['status'] === 'cancelled' ? ' selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </form>
                            </div>
                            <dl class="sum-admin-appt-card__fields">
                                <div>
                                    <dt>Type of service</dt>
                                    <dd><?php echo htmlspecialchars($item['service'], ENT_QUOTES, 'UTF-8'); ?></dd>
                                </div>
                                <div>
                                    <dt>Date</dt>
                                    <dd><?php echo htmlspecialchars($item['appointment_date'], ENT_QUOTES, 'UTF-8'); ?></dd>
                                </div>
                                <div>
                                    <dt>Time</dt>
                                    <dd><?php echo htmlspecialchars($item['appointment_time'], ENT_QUOTES, 'UTF-8'); ?></dd>
                                </div>
                                <div>
                                    <dt>Name</dt>
                                    <dd><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                                </div>
                                <div>
                                    <dt>Email</dt>
                                    <dd><a href="mailto:<?php echo htmlspecialchars($item['email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($item['email'], ENT_QUOTES, 'UTF-8'); ?></a></dd>
                                </div>
                                <div>
                                    <dt>Phone no</dt>
                                    <dd><a href="tel:<?php echo htmlspecialchars(preg_replace('/\s+/', '', $item['phone']), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($item['phone'], ENT_QUOTES, 'UTF-8'); ?></a></dd>
                                </div>
                            </dl>
                            <div class="sum-admin-appt-card__actions">
                                <a href="mailto:<?php echo htmlspecialchars($item['email'], ENT_QUOTES, 'UTF-8'); ?>?subject=Appointment%20Request" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--ghost"><i class="fas fa-envelope" aria-hidden="true"></i> Email patient</a>
                                <a href="tel:<?php echo htmlspecialchars(preg_replace('/\s+/', '', $item['phone']), ENT_QUOTES, 'UTF-8'); ?>" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--ghost"><i class="fas fa-phone" aria-hidden="true"></i> Call</a>
                                <form method="post" class="sum-admin-inline-form" onsubmit="return confirm('Delete this appointment request?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="sum-admin-btn sum-admin-btn--sm sum-admin-btn--danger"><i class="fas fa-trash" aria-hidden="true"></i> Delete</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
