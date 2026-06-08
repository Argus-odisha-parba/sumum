<?php

require_once __DIR__ . '/bootstrap.php';
sum_admin_require_login();

require_once dirname(__DIR__) . '/includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $saved = sum_contact_save([
        'email' => $_POST['email'] ?? '',
        'epabx_display' => $_POST['epabx_display'] ?? '',
        'epabx_tel' => $_POST['epabx_tel'] ?? '',
        'ambulance_display' => $_POST['ambulance_display'] ?? '',
        'ambulance_tel' => $_POST['ambulance_tel'] ?? '',
        'address' => $_POST['address'] ?? '',
        'address_short' => $_POST['address_short'] ?? '',
        'map_url' => $_POST['map_url'] ?? '',
        'hours_weekdays' => $_POST['hours_weekdays'] ?? '',
        'hours_saturday' => $_POST['hours_saturday'] ?? '',
        'hours_sunday' => $_POST['hours_sunday'] ?? '',
        'hours_summary' => $_POST['hours_summary'] ?? '',
        'hours_compact' => $_POST['hours_compact'] ?? '',
        'contact_intro' => $_POST['contact_intro'] ?? '',
        'appointment_url' => $_POST['appointment_url'] ?? '',
    ]);

    if ($saved) {
        sum_admin_flash_set('success', 'Contact details saved successfully.');
    } else {
        sum_admin_flash_set('error', 'Could not save contact details.');
    }
    header('Location: contact.php');
    exit;
}

$contact = sum_contact_load();
$flash = sum_admin_flash_get();
$adminPageTitle = 'Contact details';
$adminActiveNav = 'contact';
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
            <h2>Hospital contact details</h2>
            <p class="sum-admin-panel__hint">These details appear on the <strong>Contact</strong> page, header, footer, and About page across the website.</p>

            <form method="post" class="sum-admin-form sum-admin-form--grid">
                <div class="sum-admin-field sum-admin-field--full">
                    <label for="contact_intro">Contact page intro</label>
                    <input type="text" id="contact_intro" name="contact_intro" value="<?php echo htmlspecialchars($contact['contact_intro'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($contact['email'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="appointment_url">Appointment URL</label>
                    <input type="url" id="appointment_url" name="appointment_url" value="<?php echo htmlspecialchars($contact['appointment_url'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="epabx_display">EPABX (display) *</label>
                    <input type="text" id="epabx_display" name="epabx_display" required value="<?php echo htmlspecialchars($contact['epabx_display'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="+91 0674 3 500 500">
                </div>

                <div class="sum-admin-field">
                    <label for="epabx_tel">EPABX (tel link) *</label>
                    <input type="text" id="epabx_tel" name="epabx_tel" required value="<?php echo htmlspecialchars($contact['epabx_tel'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="+916743500500">
                    <small>Used in click-to-call links (digits and + only).</small>
                </div>

                <div class="sum-admin-field">
                    <label for="ambulance_display">Ambulance (display)</label>
                    <input type="text" id="ambulance_display" name="ambulance_display" value="<?php echo htmlspecialchars($contact['ambulance_display'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="ambulance_tel">Ambulance (tel link)</label>
                    <input type="text" id="ambulance_tel" name="ambulance_tel" value="<?php echo htmlspecialchars($contact['ambulance_tel'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field sum-admin-field--full">
                    <label for="address">Full address *</label>
                    <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($contact['address'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="sum-admin-field">
                    <label for="address_short">Short address (header)</label>
                    <input type="text" id="address_short" name="address_short" value="<?php echo htmlspecialchars($contact['address_short'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="map_url">Google Maps URL</label>
                    <input type="url" id="map_url" name="map_url" value="<?php echo htmlspecialchars($contact['map_url'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="hours_weekdays">Mon – Fri hours</label>
                    <input type="text" id="hours_weekdays" name="hours_weekdays" value="<?php echo htmlspecialchars($contact['hours_weekdays'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="hours_saturday">Saturday hours</label>
                    <input type="text" id="hours_saturday" name="hours_saturday" value="<?php echo htmlspecialchars($contact['hours_saturday'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="hours_sunday">Sunday hours</label>
                    <input type="text" id="hours_sunday" name="hours_sunday" value="<?php echo htmlspecialchars($contact['hours_sunday'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="hours_summary">Hours summary (top bar)</label>
                    <input type="text" id="hours_summary" name="hours_summary" value="<?php echo htmlspecialchars($contact['hours_summary'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-field">
                    <label for="hours_compact">Hours compact (tablet)</label>
                    <input type="text" id="hours_compact" name="hours_compact" value="<?php echo htmlspecialchars($contact['hours_compact'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="sum-admin-form__actions sum-admin-field--full">
                    <button type="submit" class="sum-admin-btn sum-admin-btn--primary">
                        <i class="fas fa-save" aria-hidden="true"></i> Save contact details
                    </button>
                    <a href="../contact.php" class="sum-admin-btn sum-admin-btn--ghost" target="_blank" rel="noopener">Preview contact page</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
