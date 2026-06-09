<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'Sum Ultimate | Best Hospitals in Bhubaneswar | Multi Speciality Hospital in Odisha';
$currentPage = 'home';
$bodyClass = 'sum-home-mobile-match';
include __DIR__ . '/includes/header.php';
?>

<!--==============================
  Hero Area
==============================-->
<section class="vs-hero-wrapper-eight position-relative sum-hero-v8 sum-hero-clean" aria-label="Featured highlights">
    <div class="banner-slide-eight sum-hero-slick">
        <div class="banner-slide">
            <div class="banner-content">
                <img src="assets/img/hero/h-bg-8-1.jpg" alt="SUM Ultimate Medicare">
                <div class="sum-hero-overlay" aria-hidden="true"></div>
                <div class="banner-text">
                    <div class="container-style8">
                        <div class="banner-sec-info one-time sum-hero-copy">
                            <h1 class="animated" data-animation-in="fadeInUp" data-delay-in="0.1">SUM Ultimate Medicare</h1>
                            <p class="animated" data-animation-in="fadeInUp" data-delay-in="0.3">“SUM Ultimate Medicare offers its patients best in class healthcare facilities addressing the capacity, safety, quality and wait-time issues becoming the first of its kind in the state.”</p>
                            <a href="<?php echo htmlspecialchars(sum_appointment_url(), ENT_QUOTES, 'UTF-8'); ?>" class="btn-style8 v8"<?php echo sum_appointment_link_attrs(); ?> data-animation-in="fadeInUp" data-delay-in="0.5">GET AN APPOINTMENT!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-slide">
            <div class="banner-content">
                <img src="assets/img/hero/h-bg-8-1.jpg" alt="SUM Ultimate Medicare">
                <div class="sum-hero-overlay" aria-hidden="true"></div>
                <div class="banner-text">
                    <div class="container-style8">
                        <div class="banner-sec-info one-time sum-hero-copy">
                            <h1 class="animated" data-animation-in="fadeInUp" data-delay-in="0.1">The Ultimate Healthcare Destination</h1>
                            <p class="animated" data-animation-in="fadeInUp" data-delay-in="0.3">Multi-super specialty quaternary care with state-of-the-art facilities for your family in Bhubaneswar, Odisha.</p>
                            <a href="https://sumum.soahospitals.com/ultimate-departments/" class="btn-style8 v8" target="_blank" rel="noopener" data-animation-in="fadeInUp" data-delay-in="0.5">Our Departments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-slide">
            <div class="banner-content">
                <img src="assets/img/hero/h-bg-8-1.jpg" alt="SUM Ultimate Medicare">
                <div class="sum-hero-overlay" aria-hidden="true"></div>
                <div class="banner-text">
                    <div class="container-style8">
                        <div class="banner-sec-info one-time sum-hero-copy">
                            <h1 class="animated" data-animation-in="fadeInUp" data-delay-in="0.1">Best Hospitals in Bhubaneswar</h1>
                            <p class="animated" data-animation-in="fadeInUp" data-delay-in="0.3">NABH accredited care, advanced technology, and a patient-centric approach across the full spectrum of specialties.</p>
                            <a href="https://sumum.soahospitals.com/contact-us/" class="btn-style8 v8" target="_blank" rel="noopener" data-animation-in="fadeInUp" data-delay-in="0.5">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sum-hero-side-arrows" id="sumHeroSideArrows" aria-label="Previous and next slides"></div>
    <div class="banner-arrows sum-hero-controls">
        <div class="container-style8 sum-hero-controls-inner">
            <div id="slidenav3" class="custom-arrows-eight sum-hero-dots-wrap"></div>
        </div>
    </div>
</section>

<!-- OUR COMMITMENTS -->
<section class="service-section-eight space">
    <div class="container-style8">
        <div class="title-area-four text-center wow fadeInUp mb-5" data-wow-delay="200ms">
            <span class="sub-title8">SUM Ultimate Medicare</span>
            <h2>OUR COMMITMENTS</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="sum-commitment-card p-4 h-100 text-center border rounded-3">
                    <img src="https://sumum.soahospitals.com/wp-content/uploads/2022/01/HealthcareTechnology.png" alt="" class="mb-3" style="max-height:72px;width:auto;">
                    <h4 class="sum-commitment-card__title h5">Most Advanced Healthcare Technology</h4>
                    <p class="sum-commitment-card__text mb-0 small">A first of its kind in Odisha, SUM Ultimate Hospital has been a pioneer in ground-breaking healthcare industry technology in the state.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="sum-commitment-card p-4 h-100 text-center border rounded-3">
                    <img src="https://sumum.soahospitals.com/wp-content/uploads/2022/01/Commitmenttoserve.png" alt="" class="mb-3" style="max-height:72px;width:auto;">
                    <h4 class="sum-commitment-card__title h5">Commitment to serve</h4>
                    <p class="sum-commitment-card__text mb-0 small">We deliver on the commitment to serve beyond business imperatives fostering patient healing</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="sum-commitment-card p-4 h-100 text-center border rounded-3">
                    <img src="https://sumum.soahospitals.com/wp-content/uploads/2022/01/patient-1.png" alt="" class="mb-3" style="max-height:72px;width:auto;">
                    <h4 class="sum-commitment-card__title h5">Transparency for patient centric healthcare</h4>
                    <p class="sum-commitment-card__text mb-0 small">The hospital aims to build a “Bridge of Trust” with the community we serve by fostering a new era of transparency with focus on patient friendly healthcare</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="sum-commitment-card p-4 h-100 text-center border rounded-3">
                    <img src="https://sumum.soahospitals.com/wp-content/uploads/2022/01/ClinicalOutcome.png" alt="" class="mb-3" style="max-height:72px;width:auto;">
                    <h4 class="sum-commitment-card__title h5">Ultimate Clinical Outcome</h4>
                    <p class="sum-commitment-card__text mb-0 small">By inculcating the culture of "Empathy and Compassion combined with Coordination and Competency", the hospital has always delivered best in class clinical outcome.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Departments browse -->
<section class="sum-dept-browse space pt-0" aria-label="Browse departments and specialties">
    <div class="container-style8">
        <div class="sum-dept-browse__panel">
            <div class="sum-dept-browse__glow sum-dept-browse__glow--1" aria-hidden="true"></div>
            <div class="sum-dept-browse__glow sum-dept-browse__glow--2" aria-hidden="true"></div>

            <div class="sum-dept-browse__hero">
                <div class="sum-dept-browse__intro">
                    <span class="sum-dept-browse__eyebrow">Clinical Specialties</span>
                    <h2 class="sum-dept-browse__title">Browse Our Medical Departments</h2>
                    <p class="sum-dept-browse__lead">Explore <?php echo count($departmentItems); ?>+ specialties with expert consultants, advanced diagnostics, and coordinated care pathways — all under one roof at SUM Ultimate Medicare.</p>
                    <ul class="sum-dept-browse__stats">
                        <li>
                            <strong><?php echo count($departmentItems); ?>+</strong>
                            <span>Specialties</span>
                        </li>
                        <li>
                            <strong><?php echo count($doctors); ?>+</strong>
                            <span>Consultants</span>
                        </li>
                        <li>
                            <strong>24/7</strong>
                            <span>Emergency Care</span>
                        </li>
                    </ul>
                </div>

                <div class="sum-dept-browse__finder">
                    <p class="sum-dept-browse__finder-label"><i class="fas fa-search" aria-hidden="true"></i> Quick department finder</p>
                    <div class="sum-dept-browse__select-wrap">
                        <label class="visually-hidden" for="sumDepartmentSelect">Select department</label>
                        <select id="sumDepartmentSelect" class="sum-dept-browse__select">
                            <option value="" selected>Choose a department…</option>
                            <?php foreach ($departmentItems as $dept): ?>
                                <option value="<?php echo htmlspecialchars(sum_dept_slug($dept), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="sum-dept-browse__finder-actions">
                        <a href="department.php" class="sum-dept-browse__link-all">View all departments <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                        <a href="doctor.php" class="sum-dept-browse__link-docs">Meet our doctors</a>
                    </div>
                </div>
            </div>

            <div class="sum-dept-browse__slider-wrap">
                <div class="sum-dept-browse__slider-head">
                    <p class="sum-dept-browse__slider-label">Use the arrows to explore all specialties</p>
                    <div class="sum-dept-browse__slider-nav" id="sumDeptSliderNav" aria-label="Department slider arrows"></div>
                </div>
                <div class="sum-dept-browse__slider-stage">
                    <div class="sum-dept-browse__slider" role="list">
                    <?php
                    $deptTone = 0;
                    foreach ($departments as $dept):
                        $deptTone++;
                        $icon = sum_dept_icon($dept['name']);
                        $docCount = sum_doctors_in_department($dept['name']);
                        $serviceCount = count($dept['services'] ?? []);
                        $deptUrl = 'department-detail.php?dept=' . urlencode($dept['slug']);
                        $toneClass = 'sum-dept-card--tone-' . (($deptTone - 1) % 4 + 1);
                    ?>
                        <div class="sum-dept-slide" role="listitem">
                            <a class="sum-dept-card <?php echo $toneClass; ?>" href="<?php echo htmlspecialchars($deptUrl, ENT_QUOTES, 'UTF-8'); ?>">
                                <span class="sum-dept-card__icon" aria-hidden="true"><i class="fas <?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>"></i></span>
                                <h3 class="sum-dept-card__name"><?php echo htmlspecialchars($dept['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="sum-dept-card__text"><?php echo htmlspecialchars(sum_excerpt($dept['overview']), ENT_QUOTES, 'UTF-8'); ?></p>
                                <ul class="sum-dept-card__meta">
                                    <?php if ($docCount > 0): ?>
                                        <li><i class="fas fa-user-md" aria-hidden="true"></i> <?php echo (int) $docCount; ?> consultant<?php echo $docCount > 1 ? 's' : ''; ?></li>
                                    <?php endif; ?>
                                    <li><i class="fas fa-check-circle" aria-hidden="true"></i> <?php echo (int) $serviceCount; ?> key services</li>
                                </ul>
                                <span class="sum-dept-card__cta">Explore department <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sum-facilities-tabs-section space pt-0">
    <div class="container-style8">
        <div class="sum-facilities-head text-center">
            <span class="sum-facilities-eyebrow">MEDICAL SERVICES</span>
            <h2>What Facilities We Provided</h2>
        </div>
        <div class="sum-facilities-layout" id="sumFacilitiesTabs">
            <div class="sum-facilities-left" role="tablist" aria-label="Medical facilities">
                <?php
                $firstDept = $departmentItems[0] ?? 'Cardiology';
                foreach ($departmentItems as $dept):
                    $info = $facilityInfo[$dept] ?? null;
                    $text = $info['text'] ?? ('Specialty services, diagnostics, and coordinated care for ' . $dept . ' with a patient-first approach.');
                    $points = $info['points'] ?? ['Consultation and diagnosis', 'Advanced procedures', 'In-patient & out-patient care', 'Follow-up and recovery'];
                    $pointsRaw = implode('|', $points);
                    $isActive = $dept === $firstDept;
                ?>
                    <button class="sum-facility-tab<?php echo $isActive ? ' is-active' : ''; ?>" type="button" role="tab" aria-selected="<?php echo $isActive ? 'true' : 'false'; ?>"
                        data-title="<?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?>"
                        data-text="<?php echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?>"
                        data-points="<?php echo htmlspecialchars($pointsRaw, ENT_QUOTES, 'UTF-8'); ?>">
                        <i class="far fa-plus" aria-hidden="true"></i><span><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="sum-facilities-center" aria-hidden="true">
                <div class="sum-facilities-circle-wrap">
                    <img src="assets/img/service/ser9-2.jpg" alt="Medical laboratory facility">
                </div>
                <span class="sum-facilities-icon"><i class="fas fa-hand-holding-medical"></i></span>
            </div>

            <div class="sum-facilities-right">
                <article class="sum-facility-panel">
                    <h3 id="facilityTitle"><?php echo htmlspecialchars($firstDept, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <?php
                    $firstInfo = $facilityInfo[$firstDept] ?? null;
                    $firstText = $firstInfo['text'] ?? ('Specialty services, diagnostics, and coordinated care for ' . $firstDept . ' with a patient-first approach.');
                    $firstPoints = $firstInfo['points'] ?? ['Consultation and diagnosis', 'Advanced procedures', 'In-patient & out-patient care', 'Follow-up and recovery'];
                    ?>
                    <p id="facilityText"><?php echo htmlspecialchars($firstText, ENT_QUOTES, 'UTF-8'); ?></p>
                    <ul id="facilityPoints">
                        <?php foreach ($firstPoints as $pt): ?>
                            <li><?php echo htmlspecialchars($pt, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="department-detail.php?dept=<?php echo urlencode(sum_dept_slug($firstDept)); ?>">Learn More</a>
                </article>
            </div>
        </div>
    </div>
</section>

<div class="brand-section-six">
    <div class="container">
        <div class="brand-slider text-center vs-carousel" data-slide-show="5" data-lg-slide-show="4" data-md-slide-show="3" data-sm-slide-show="2" data-xs-slide-show="1">
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-1.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-2.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-3.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-5.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-4.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-1.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-2.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-3.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-5.png" alt="image"></div>
            <div class="brand-img-six"><img src="assets/img/brand/brand-6-4.png" alt="image"></div>
        </div>
    </div>
</div>

<section class="main-section space" data-bg-src="assets/img/bg/ser-bg9-1.jpg">
    <div class="service-section-ten space pb-0">
        <div class="container-style8">
            <div class="outer-box">
                <div class="service-block-ten">
                    <div class="ser-icon-ten"><img src="assets/img/service/ser-icon10-1.svg" alt=""></div>
                    <div class="ser-content-ten">
                        <h4 class="title">+91 0674<br>3 500 500</h4>
                        <span>EPABX (24/7)</span>
                    </div>
                </div>
                <div class="service-block-ten">
                    <div class="ser-icon-ten"><img src="assets/img/service/ser-icon10-2.svg" alt=""></div>
                    <div class="ser-content-ten">
                        <h4 class="title">+91 0674<br>266 1111</h4>
                        <span>Ambulance</span>
                    </div>
                </div>
                <div class="service-block-ten">
                    <div class="ser-icon-ten"><img src="assets/img/service/ser-icon10-3.svg" alt=""></div>
                    <div class="ser-content-ten">
                        <h4 class="title">24<span> Hours</span></h4>
                        <span>Emergency &amp; Pharmacy</span>
                    </div>
                </div>
                <div class="service-block-ten">
                    <div class="ser-icon-ten"><img src="assets/img/service/ser-icon10-4.svg" alt=""></div>
                    <div class="ser-content-ten">
                        <h4 class="title">JCI<span> Prime</span></h4>
                        <span>First in Odisha</span>
                    </div>
                </div>
                <div class="service-block-ten">
                    <div class="ser-icon-ten"><img src="assets/img/service/ser-icon10-5.svg" alt=""></div>
                    <div class="ser-content-ten">
                        <h4 class="title">NABH<span>+</span></h4>
                        <span>Quality &amp; safety</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonial-section-eight space pt-0">
    <div class="container-style8">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="testi-content-eight">
                    <div class="title-area-four">
                        <span class="sub-title8 v1">Patient feedback</span>
                        <h2>ULTIMATE REVIEWS</h2>
                    </div>
                    <div class="testi-slider-eight">
                        <div class="testi-info-eight">
                            <p>It's a nice hospital. Nursing staff are very professional and well behaved. All other support services and related staff are doing their duty with utmost care. My mother has been admitted under observation of Dr. Sarat Sahoo, Cardiac Department. He is a nice gentleman and cordial. I salute the hospitality of such a nice hospital. My best wishes.</p>
                            <div class="testi-auther-eight">
                                <h4 class="title">Suvendu Ray</h4>
                                <span class="designation">Patient</span>
                            </div>
                        </div>
                        <div class="testi-info-eight">
                            <p>One of the best hospital in private hospital in Bhubaneswar. Very professional and good hospitality.</p>
                            <div class="testi-auther-eight">
                                <h4 class="title">Saroj Senapati</h4>
                                <span class="designation">Patient</span>
                            </div>
                        </div>
                        <div class="testi-info-eight">
                            <p>Recently am admitted her, am personally recommend you there is so good place and here staff is very friendly and here conditions and also care take care very good.</p>
                            <div class="testi-auther-eight">
                                <h4 class="title">Bhubaneswar Chandan</h4>
                                <span class="designation">Patient</span>
                            </div>
                        </div>
                        <div class="testi-info-eight">
                            <p>Very good experience in this hospital. Dr. Jayant kumar Dash sir is excellent and patient friendly. Mr. Devi and Mr.Kirtan is very nice and cooperative, they both made our stay in hospital comfortable. Hats up. keep it up. Thank you Doctor and coordinator.</p>
                            <div class="testi-auther-eight">
                                <h4 class="title">Bilasini Panda</h4>
                                <span class="designation">Patient</span>
                            </div>
                        </div>
                        <div class="testi-info-eight">
                            <p>Hospital, an institution that is built, staffed, and equipped for the diagnosis of disease; for the treatment, both medical and surgical, of the sick and the injured; and for their housing during this process. The modern hospital also often serves as a centre for investigation and for teaching. All staff's behavior is so nice.</p>
                            <div class="testi-auther-eight">
                                <h4 class="title">Liza Liza</h4>
                                <span class="designation">Patient</span>
                            </div>
                        </div>
                    </div>
                    <div id="slidenav4" class="custom-arrows-eight"></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12" id="book-appointment">
                <?php
                $appointmentReturnTo = 'index.php';
                $appointmentFormIdPrefix = 'sumHomeAppt';
                include __DIR__ . '/includes/appointment-form-partial.php';
                ?>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        var deptSelect = document.getElementById('sumDepartmentSelect');
        if (deptSelect) {
            deptSelect.addEventListener('change', function () {
                var value = (deptSelect.value || '').trim();
                if (!value) return;
                window.location.href = 'department-detail.php?dept=' + encodeURIComponent(value);
            });
        }

        var root = document.getElementById("sumFacilitiesTabs");
        if (!root) return;
        var tabs = Array.prototype.slice.call(root.querySelectorAll(".sum-facility-tab"));
        var titleEl = document.getElementById("facilityTitle");
        var textEl = document.getElementById("facilityText");
        var pointsEl = document.getElementById("facilityPoints");

        function setPanel(btn) {
            tabs.forEach(function (tab) {
                tab.classList.remove("is-active");
                tab.setAttribute("aria-selected", "false");
            });
            btn.classList.add("is-active");
            btn.setAttribute("aria-selected", "true");
            if (titleEl) titleEl.textContent = btn.getAttribute("data-title") || "";
            if (textEl) textEl.textContent = btn.getAttribute("data-text") || "";
            if (pointsEl) {
                var pointsRaw = btn.getAttribute("data-points") || "";
                var points = pointsRaw.split("|").map(function (x) { return x.trim(); }).filter(Boolean);
                pointsEl.innerHTML = points.map(function (point) {
                    return "<li>" + point.replace(/</g, "&lt;").replace(/>/g, "&gt;") + "</li>";
                }).join("");
            }
        }

        tabs.forEach(function (btn) {
            btn.addEventListener("click", function () {
                setPanel(btn);
            });
        });
    })();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
