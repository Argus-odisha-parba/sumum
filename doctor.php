<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/doctor-profile-partial.php';

$pageTitle = 'Doctors | SUM Ultimate Medicare';
$currentPage = 'doctors';

$selectedDepartment = isset($_GET['department']) ? trim($_GET['department']) : '';
if ($selectedDepartment === '') {
    $selectedDepartment = 'All Departments';
}

$departmentsToShow = [];
if ($selectedDepartment === 'All Departments') {
    $departmentsToShow = $departmentItems;
} else {
    $departmentsToShow = [$selectedDepartment];
}

$sumDoctorsById = [];
foreach (sum_get_doctors(null, true) as $doc) {
    $sumDoctorsById[$doc['id']] = [
        'id' => $doc['id'],
        'name' => $doc['name'],
        'department' => $doc['department'],
        'departmentSlug' => sum_dept_slug($doc['department']),
        'qualification' => $doc['qualification'],
        'image' => $doc['image'],
        'bio' => sum_doctor_profile_description($doc),
        'profileUrl' => sum_doctor_profile_url($doc['id']),
    ];
}

include __DIR__ . '/includes/header.php';
?>

<section class="sum-doctors-banner">
    <div class="container-style8">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="sum-department-eyebrow mb-2">ULTIMATE DOCTORS</p>
                <h1 class="mb-3">Meet Our Specialists</h1>
                <p class="sum-doctors-banner__intro mb-0">Consultants and specialists across departments at SUM Ultimate Medicare — experienced clinicians dedicated to compassionate, evidence-based care for you and your family.</p>
            </div>
            <div class="col-lg-4">
                <form class="sum-doctor-search" id="sumDoctorSearchForm" role="search">
                    <label class="visually-hidden" for="sumDoctorSearch">Search by doctor name</label>
                    <div class="sum-doctor-search__wrap">
                        <input type="search" id="sumDoctorSearch" class="form-control" placeholder="Search by doctor name..." autocomplete="off">
                        <button type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="sum-department-listing pb-5">
    <div class="container-style8">
        <?php if ($selectedDepartment === 'All Departments'): ?>
            <div class="doctor-tabs" aria-label="Department navigation">
                <?php foreach ($departmentItems as $dept): ?>
                    <a class="doc-tab" href="#sum-doctor-dept-<?php echo htmlspecialchars(sum_dept_slug($dept), ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div id="sumDoctorGrid">
            <?php
                $hasAnyDoctors = false;
                foreach ($departmentsToShow as $deptName):
                    $deptDoctors = sum_get_doctors($deptName);
                    if (empty($deptDoctors)) continue;
                    $hasAnyDoctors = true;
            ?>
                <div class="sum-doctor-dept-section" id="sum-doctor-dept-<?php echo htmlspecialchars(sum_dept_slug($deptName), ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="sum-doctor-dept-section__header">
                        <h2 class="sum-doctor-dept-section__title"><?php echo htmlspecialchars($deptName, ENT_QUOTES, 'UTF-8'); ?></h2>
                        <span class="sum-doctor-dept-section__count"><?php echo count($deptDoctors); ?> Doctors</span>
                    </div>
                    <div class="row g-4">
                        <?php foreach ($deptDoctors as $doc): ?>
                            <div class="col-lg-4 col-md-6 sum-doctor-item" data-name="<?php echo htmlspecialchars(strtolower($doc['name']), ENT_QUOTES, 'UTF-8'); ?>">
                                <a href="<?php echo htmlspecialchars(sum_doctor_profile_url($doc['id']), ENT_QUOTES, 'UTF-8'); ?>" class="sum-doctor-card sum-doctor-card--link" data-doctor-id="<?php echo htmlspecialchars($doc['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <span class="sum-doctor-card__view">View profile <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                                    <div class="sum-doctor-card__img">
                                        <img src="<?php echo htmlspecialchars($doc['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($doc['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                    <div class="sum-doctor-card__body">
                                        <h2 class="h5 mb-1"><?php echo htmlspecialchars($doc['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
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
                </div>
            <?php endforeach; ?>
            <?php if (!$hasAnyDoctors): ?>
                <div class="text-center py-5">
                    <p class="mb-0 fw-bold">No doctors available for this department.</p>
                </div>
            <?php endif; ?>
        </div>

        <p class="sum-doctor-empty text-center py-5 d-none" id="sumDoctorEmpty">No doctors found matching your search.</p>
    </div>
</section>

<div id="sumDoctorModal" class="sum-doctor-modal" aria-hidden="true" role="dialog" aria-labelledby="sumDoctorModalTitle" aria-modal="true">
    <div id="sumDoctorModalBackdrop" class="sum-doctor-modal__backdrop" tabindex="-1"></div>
    <div class="sum-doctor-modal__dialog">
        <button type="button" id="sumDoctorModalClose" class="sum-doctor-modal__close" aria-label="Close profile"><i class="fal fa-times" aria-hidden="true"></i></button>
        <div id="sumDoctorModalPanel" class="sum-doctor-modal__panel"></div>
    </div>
</div>

<script>
window.sumDoctorsById = <?php echo json_encode($sumDoctorsById, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
window.sumAppointmentUrl = <?php echo json_encode(sum_contact_val('appointment_url'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
</script>
<script src="assets/js/doctor-profile-modal.js"></script>
<script>
(function () {
    var searchInput = document.getElementById('sumDoctorSearch');
    var items = Array.prototype.slice.call(document.querySelectorAll('.sum-doctor-item'));
    var emptyMsg = document.getElementById('sumDoctorEmpty');

    function applyFilters() {
        var query = (searchInput && searchInput.value || '').trim().toLowerCase();
        var visible = 0;

        items.forEach(function (item) {
            var name = item.getAttribute('data-name') || '';
            var matchName = !query || name.indexOf(query) !== -1;
            var show = matchName;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        if (emptyMsg) {
            var showEmpty = query.length > 0 && visible === 0;
            emptyMsg.classList.toggle('d-none', !showEmpty);
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
        var form = document.getElementById('sumDoctorSearchForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                applyFilters();
            });
        }
    }

    applyFilters();
})();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
