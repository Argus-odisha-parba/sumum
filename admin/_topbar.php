<?php
/** @var string $adminPageTitle */
/** @var string $adminActiveNav dashboard|doctors|departments|gallery|contact|appointments|database */
$adminPageTitle = $adminPageTitle ?? 'Dashboard';
$adminActiveNav = $adminActiveNav ?? '';
$adminNewAppointments = 0;
if (function_exists('sum_appointments_count_by_status')) {
    $adminNewAppointments = sum_appointments_count_by_status('new');
}
?>
<header class="sum-admin-topbar">
    <div class="sum-admin-topbar__brand">
        <a href="index.php" class="sum-admin-topbar__brand-link">
            <span class="sum-admin-topbar__logo">SUM</span>
            <div>
                <strong><?php echo htmlspecialchars($adminPageTitle, ENT_QUOTES, 'UTF-8'); ?></strong>
                <span>Admin dashboard</span>
            </div>
        </a>
    </div>
    <nav class="sum-admin-topbar__nav" aria-label="Admin navigation">
        <a href="index.php" class="<?php echo $adminActiveNav === 'dashboard' ? 'is-active' : ''; ?>">Dashboard</a>
        <a href="departments.php" class="<?php echo $adminActiveNav === 'departments' ? 'is-active' : ''; ?>">Departments</a>
        <a href="doctors.php" class="<?php echo $adminActiveNav === 'doctors' ? 'is-active' : ''; ?>">Doctors</a>
        <a href="gallery.php" class="<?php echo $adminActiveNav === 'gallery' ? 'is-active' : ''; ?>">Gallery</a>
        <a href="contact.php" class="<?php echo $adminActiveNav === 'contact' ? 'is-active' : ''; ?>">Contact</a>
        <a href="appointments.php" class="<?php echo $adminActiveNav === 'appointments' ? 'is-active' : ''; ?>">
            Appointments<?php if ($adminNewAppointments > 0): ?><span class="sum-admin-nav-badge"><?php echo (int) $adminNewAppointments; ?></span><?php endif; ?>
        </a>
        <a href="database.php" class="<?php echo $adminActiveNav === 'database' ? 'is-active' : ''; ?>">Database</a>
        <a href="../department.php" target="_blank" rel="noopener">View site</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
