<?php

require_once __DIR__ . '/bootstrap.php';
sum_admin_require_login();

require_once dirname(__DIR__) . '/includes/data.php';

$appointments = sum_appointments_load();
$recentAppointments = array_slice($appointments, 0, 5);
$newAppointments = sum_appointments_count_by_status('new');

$adminPageTitle = 'Dashboard';
$adminActiveNav = 'dashboard';
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
        <div class="sum-admin-dashboard-intro">
            <h2>Welcome back</h2>
            <p>Manage hospital content, gallery, contact details, and appointment requests from one place.</p>
        </div>

        <div class="sum-admin-dash-grid">
            <a href="appointments.php" class="sum-admin-dash-card sum-admin-dash-card--accent">
                <span class="sum-admin-dash-card__icon"><i class="fas fa-calendar-check" aria-hidden="true"></i></span>
                <strong><?php echo (int) $newAppointments; ?></strong>
                <span>New appointments</span>
            </a>
            <a href="doctors.php" class="sum-admin-dash-card">
                <span class="sum-admin-dash-card__icon"><i class="fas fa-user-md" aria-hidden="true"></i></span>
                <strong><?php echo count(sum_doctors_load()); ?></strong>
                <span>Doctors</span>
            </a>
            <a href="departments.php" class="sum-admin-dash-card">
                <span class="sum-admin-dash-card__icon"><i class="fas fa-hospital" aria-hidden="true"></i></span>
                <strong><?php echo count(sum_departments_load()); ?></strong>
                <span>Departments</span>
            </a>
            <a href="gallery.php" class="sum-admin-dash-card">
                <span class="sum-admin-dash-card__icon"><i class="fas fa-images" aria-hidden="true"></i></span>
                <strong><?php echo count(sum_gallery_load()); ?></strong>
                <span>Gallery photos</span>
            </a>
        </div>

        <section class="sum-admin-panel sum-admin-panel--list">
            <div class="sum-admin-panel__headrow">
                <div>
                    <h2>Recent appointment requests</h2>
                    <p class="sum-admin-panel__hint mb-0">From the homepage <strong>Book An Appointment</strong> form — service, date, time, name, email, and phone.</p>
                </div>
                <a href="appointments.php" class="sum-admin-btn sum-admin-btn--ghost">View all</a>
            </div>

            <?php if (empty($recentAppointments)): ?>
                <p class="sum-admin-empty">No appointment requests yet. Submissions from the homepage form will appear here.</p>
            <?php else: ?>
                <div class="sum-admin-appt-cards">
                    <?php foreach ($recentAppointments as $item):
                        $submitted = $item['created_at'] ?? '';
                        $submittedDisplay = $submitted !== '' ? date('d M Y, h:i A', strtotime($submitted)) : '—';
                    ?>
                        <article class="sum-admin-appt-card<?php echo ($item['status'] ?? '') === 'new' ? ' sum-admin-appt-card--new' : ''; ?>">
                            <div class="sum-admin-appt-card__head">
                                <div>
                                    <h3><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <span class="sum-admin-appt-card__meta"><?php echo htmlspecialchars($submittedDisplay, ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <span class="sum-admin-appt-status sum-admin-appt-status--<?php echo htmlspecialchars($item['status'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars(sum_appointment_status_label($item['status']), ENT_QUOTES, 'UTF-8'); ?>
                                </span>
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
                                    <dt>Email</dt>
                                    <dd><a href="mailto:<?php echo htmlspecialchars($item['email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($item['email'], ENT_QUOTES, 'UTF-8'); ?></a></dd>
                                </div>
                                <div>
                                    <dt>Phone</dt>
                                    <dd><a href="tel:<?php echo htmlspecialchars(preg_replace('/\s+/', '', $item['phone']), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($item['phone'], ENT_QUOTES, 'UTF-8'); ?></a></dd>
                                </div>
                            </dl>
                            <a href="appointments.php#appt-<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?>" class="sum-admin-appt-card__link">Manage request <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
