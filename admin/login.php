<?php

require_once __DIR__ . '/bootstrap.php';

if (sum_admin_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $cfg = sum_admin_config();
    if (hash_equals((string) ($cfg['password'] ?? ''), $password)) {
        $_SESSION['sum_admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | SUM Ultimate Medicare</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="sum-admin-login-page">
    <div class="sum-admin-login-card">
        <h1>Doctor Dashboard</h1>
        <p class="sum-admin-login-card__sub">SUM Ultimate Medicare — manage doctor profiles</p>
        <?php if ($error): ?>
            <div class="sum-admin-alert sum-admin-alert--error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if (!is_file(dirname(__DIR__) . '/data/admin-config.php')): ?>
            <div class="sum-admin-alert sum-admin-alert--warn">Using default password <strong>sumum2026</strong>. Copy <code>data/admin-config.sample.php</code> to <code>data/admin-config.php</code> and change it.</div>
        <?php endif; ?>
        <form method="post" class="sum-admin-form">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autofocus>
            <button type="submit" class="sum-admin-btn sum-admin-btn--primary">Sign in</button>
        </form>
        <p class="sum-admin-login-card__foot"><a href="../index.php">← Back to website</a></p>
    </div>
</body>
</html>
