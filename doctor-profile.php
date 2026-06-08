<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/doctor-profile-partial.php';

if (isset($_GET['id']) && trim((string) $_GET['id']) !== '') {
    $legacyId = sum_doctor_profile_slug(trim((string) $_GET['id']));
    if ($legacyId !== '') {
        header('Location: ' . sum_doctor_profile_url($legacyId), true, 301);
        exit;
    }
}

$slug = isset($_GET['slug']) ? sum_doctor_profile_slug(trim((string) $_GET['slug'])) : '';
$doctor = $slug !== '' ? sum_doctors_find_by_id($slug) : null;

if ($doctor === null || empty($doctor['active'])) {
    header('Location: doctor.php');
    exit;
}

$deptSlug = sum_dept_slug($doctor['department'] ?? '');
$deptUrl = 'department-detail.php?dept=' . urlencode($deptSlug);

$relatedDoctors = [];
foreach (sum_get_doctors($doctor['department'] ?? null) as $doc) {
    if (($doc['id'] ?? '') !== ($doctor['id'] ?? '')) {
        $relatedDoctors[] = $doc;
    }
    if (count($relatedDoctors) >= 3) {
        break;
    }
}

$pageTitle = $doctor['name'] . ' | ' . ($doctor['department'] ?? 'Doctor') . ' | SUM Ultimate Medicare';
$currentPage = 'doctors';
$bodyClass = 'sum-doctor-profile-page';
$metaDescription = sum_excerpt(sum_doctor_profile_description($doctor), 155);
$canonicalUrl = sum_doctor_profile_canonical_url($doctor['id']);

include __DIR__ . '/includes/header.php';
?>

<section class="sum-dprofile-banner">
    <div class="sum-dprofile-banner__pattern" aria-hidden="true"></div>
    <div class="container-style8 sum-dprofile-banner__inner">
        <nav class="sum-dprofile-breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <span aria-hidden="true">/</span>
            <a href="doctor.php">Doctors</a>
            <span aria-hidden="true">/</span>
            <span><?php echo htmlspecialchars($doctor['name'], ENT_QUOTES, 'UTF-8'); ?></span>
        </nav>
        <a href="doctor.php" class="sum-dprofile-back"><i class="fas fa-arrow-left" aria-hidden="true"></i> All doctors</a>
    </div>
</section>

<section class="sum-dprofile-main pb-5">
    <div class="container-style8">
        <?php sum_render_doctor_profile($doctor, 'page'); ?>

        <?php if (!empty($relatedDoctors)): ?>
        <div class="sum-dprofile-related">
            <div class="sum-dprofile-related__head">
                <h2>More <?php echo htmlspecialchars($doctor['department'], ENT_QUOTES, 'UTF-8'); ?> specialists</h2>
                <a href="<?php echo htmlspecialchars($deptUrl, ENT_QUOTES, 'UTF-8'); ?>">View department <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="row g-4">
                <?php foreach ($relatedDoctors as $rel): ?>
                <div class="col-md-4">
                    <a href="<?php echo htmlspecialchars(sum_doctor_profile_url($rel['id']), ENT_QUOTES, 'UTF-8'); ?>" class="sum-dprofile-related-card">
                        <div class="sum-dprofile-related-card__img">
                            <img src="<?php echo htmlspecialchars($rel['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                        </div>
                        <div class="sum-dprofile-related-card__body">
                            <h3><?php echo htmlspecialchars($rel['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <?php if (!empty($rel['qualification'])): ?>
                                <p><?php echo htmlspecialchars($rel['qualification'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                            <span class="sum-dprofile-related-card__link">View profile <i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
