<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/doctor-profile-partial.php';

$slug = isset($_GET['dept']) ? trim($_GET['dept']) : '';
$department = sum_get_department($slug);

if ($department === null) {
    header('Location: department.php');
    exit;
}

$pageTitle = $department['name'] . ' | Departments | SUM Ultimate Medicare';
$currentPage = 'departments';
$deptDoctors = sum_get_doctors($department['name']);

include __DIR__ . '/includes/header.php';
?>

<section class="sum-page-hero sum-page-hero--dept">
    <div class="container-style8">
        <p class="sum-department-eyebrow">DEPARTMENT</p>
        <h1><?php echo htmlspecialchars($department['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="sum-department-intro"><?php echo htmlspecialchars($department['overview'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</section>

<section class="space pt-0">
    <div class="container-style8">
        <div class="row g-4 align-items-start">
            <div class="col-lg-7">
                <div class="sum-content-card">
                    <h2 class="h4 mb-3">Department Overview</h2>
                    <p class="mb-4"><?php echo htmlspecialchars($department['overview'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <h3 class="h5 mb-3">Services &amp; Facilities</h3>
                    <ul class="sum-check-list mb-0">
                        <?php foreach ($department['services'] as $service): ?>
                            <li><?php echo htmlspecialchars($service, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="sum-dept-gallery">
                    <?php foreach ($department['photos'] as $index => $photo): ?>
                        <figure class="sum-dept-gallery__item<?php echo $index === 0 ? ' sum-dept-gallery__item--main' : ''; ?>">
                            <img src="<?php echo htmlspecialchars($photo, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($department['name'] . ' facility', ENT_QUOTES, 'UTF-8'); ?>">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="space pt-0 pb-5" id="doctors">
    <div class="container-style8">
        <div class="title-area-four mb-4">
            <span class="sub-title8">Consultants</span>
            <h2>Doctors in <?php echo htmlspecialchars($department['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
        </div>
        <?php if (count($deptDoctors) > 0): ?>
            <div class="row g-4">
                <?php foreach ($deptDoctors as $doc): ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo htmlspecialchars(sum_doctor_profile_url($doc['id']), ENT_QUOTES, 'UTF-8'); ?>" class="sum-doctor-card sum-doctor-card--link">
                            <span class="sum-doctor-card__view">View profile <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            <div class="sum-doctor-card__img">
                                <img src="<?php echo htmlspecialchars($doc['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($doc['name'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="sum-doctor-card__body">
                                <h3 class="h5 mb-1"><?php echo htmlspecialchars($doc['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="sum-doctor-card__dept mb-1"><?php echo htmlspecialchars($doc['department'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php if (!empty($doc['qualification'])): ?>
                                    <p class="sum-doctor-card__qual mb-2"><?php echo htmlspecialchars($doc['qualification'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($doc['description'])): ?>
                                    <p class="sum-doctor-card__bio mb-0"><?php echo htmlspecialchars(sum_excerpt($doc['description'], 100), ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="sum-content-card">
                <p class="mb-0">Consultant profiles for this department will be updated shortly. Please call <a href="tel:+916743500500">+91 0674 3 500 500</a> for appointments.</p>
            </div>
        <?php endif; ?>
        <div class="mt-4">
            <a href="<?php echo htmlspecialchars(sum_appointment_url(['service' => $department['name']]), ENT_QUOTES, 'UTF-8'); ?>" class="btn-style8 v8"<?php echo sum_appointment_link_attrs(); ?>>Book Appointment</a>
            <a href="department.php" class="btn-style8 v9 ms-2">All Departments</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
