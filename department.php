<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'Departments | SUM Ultimate Medicare';
$currentPage = 'departments';
include __DIR__ . '/includes/header.php';
?>
<main>
    <section class="sum-page-hero">
        <div class="container-style8">
            <p class="sum-department-eyebrow">DEPARTMENTS</p>
            <h1>Our Clinical Specialties</h1>
            <p class="sum-department-intro">Explore our departments — each with dedicated consultants, modern facilities, and coordinated care pathways.</p>
        </div>
    </section>
    <section class="sum-department-listing pb-5">
        <div class="container-style8">
            <div class="row g-3">
                <?php foreach ($departments as $dept): ?>
                    <div class="col-md-4 col-sm-6">
                        <a class="sum-dept-list-card d-block h-100" href="department-detail.php?dept=<?php echo urlencode($dept['slug']); ?>">
                            <h6 class="mb-2"><?php echo htmlspecialchars($dept['name'], ENT_QUOTES, 'UTF-8'); ?></h6>
                            <p class="mb-2 small"><?php echo htmlspecialchars(strlen($dept['overview']) > 120 ? substr($dept['overview'], 0, 120) . '…' : $dept['overview'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <span class="sum-dept-list-card__link">View department <i class="fas fa-arrow-right ms-1"></i></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
