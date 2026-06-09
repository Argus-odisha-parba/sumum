<?php

require_once __DIR__ . '/bootstrap.php';
sum_admin_require_login();

require_once dirname(__DIR__) . '/includes/db-config-store.php';

$dbFields = [
    'DB_HOST' => 'Database host',
    'DB_NAME' => 'Database name',
    'DB_USERNAME' => 'Database username',
    'DB_PORT' => 'Database port',
    'DB_PASSWORD' => 'Database password',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    $config = [
        'DB_HOST' => $_POST['DB_HOST'] ?? '',
        'DB_NAME' => $_POST['DB_NAME'] ?? '',
        'DB_USERNAME' => $_POST['DB_USERNAME'] ?? '',
        'DB_PORT' => $_POST['DB_PORT'] ?? '3306',
        'DB_PASSWORD' => $_POST['DB_PASSWORD'] ?? '',
    ];

    if ($config['DB_PASSWORD'] === '' && is_file(sum_db_config_path())) {
        $existing = sum_db_config_load();
        $config['DB_PASSWORD'] = $existing['DB_PASSWORD'] ?? '';
    }

    if ($action === 'test') {
        $result = sum_db_config_test($config);
        sum_admin_flash_set($result['ok'] ? 'success' : 'error', $result['message']);
        $_SESSION['sum_admin_db_draft'] = $config;
        header('Location: database.php');
        exit;
    }

    if (sum_db_config_save($config)) {
        unset($_SESSION['sum_admin_db_draft']);
        $test = sum_db_config_test($config);
        if ($test['ok']) {
            sum_admin_flash_set('success', 'Database settings saved and connection verified.');
        } else {
            sum_admin_flash_set('warn', 'Settings saved, but connection test failed: ' . $test['message']);
        }
    } else {
        sum_admin_flash_set('error', 'Could not save database settings.');
    }
    header('Location: database.php');
    exit;
}

$config = $_SESSION['sum_admin_db_draft'] ?? sum_db_config_load();
$flash = sum_admin_flash_get();
$hasConfigFile = is_file(sum_db_config_path());
$adminPageTitle = 'Database';
$adminActiveNav = 'database';
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

        <div class="sum-admin-panel sum-admin-panel--contact">
            <h2>Database configuration</h2>
            <p class="sum-admin-panel__hint">Set MySQL connection details for the application. Credentials are stored in <code>data/db-config.php</code> (not publicly accessible).</p>

            <?php if (!$hasConfigFile): ?>
                <div class="sum-admin-alert sum-admin-alert--warn">No saved config yet. Using defaults below — click <strong>Save settings</strong> to create <code>data/db-config.php</code>.</div>
            <?php endif; ?>

            <form method="post" class="sum-admin-db-form">
                <div class="sum-admin-kv-table">
                    <div class="sum-admin-kv-table__head">
                        <span>Key</span>
                        <span>Value</span>
                    </div>
                    <?php foreach ($dbFields as $key => $label):
                        $isPassword = $key === 'DB_PASSWORD';
                        $inputType = $isPassword ? 'password' : ($key === 'DB_PORT' ? 'number' : 'text');
                    ?>
                        <div class="sum-admin-kv-row">
                            <label class="sum-admin-kv-key" for="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?></label>
                            <div class="sum-admin-kv-value">
                                <input
                                    type="<?php echo $inputType; ?>"
                                    id="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>"
                                    name="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>"
                                    value="<?php echo $isPassword ? '' : htmlspecialchars($config[$key] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    placeholder="<?php echo $isPassword && !empty($config['DB_PASSWORD']) ? '•••••••• (saved — leave blank to keep)' : htmlspecialchars(sum_db_config_defaults()[$key] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    <?php echo $key === 'DB_PORT' ? 'min="1" max="65535"' : ''; ?>
                                    <?php echo in_array($key, ['DB_HOST', 'DB_NAME', 'DB_USERNAME'], true) ? 'required' : ''; ?>
                                    autocomplete="off"
                                >
                                <span class="sum-admin-kv-hint"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="sum-admin-form__actions">
                    <button type="submit" name="action" value="save" class="sum-admin-btn sum-admin-btn--primary">
                        <i class="fas fa-save" aria-hidden="true"></i> Save settings
                    </button>
                    <button type="submit" name="action" value="test" class="sum-admin-btn sum-admin-btn--ghost">
                        <i class="fas fa-plug" aria-hidden="true"></i> Test connection
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
