<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'About Us | SUM Ultimate Medicare';
$currentPage = 'about';
include __DIR__ . '/includes/header.php';
?>

<section class="sum-page-hero">
    <div class="container-style8">
        <p class="sum-department-eyebrow">ABOUT US</p>
        <h1>About SUM Ultimate Medicare</h1>
        <p class="sum-department-intro"><?php echo htmlspecialchars($aboutInstitutional['intro'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</section>

<section class="about-section-eight sum-about-revamp space pt-0">
    <div class="container-style8">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="sum-about-media sum-about-media--single">
                    <figure class="sum-about-media__img sum-about-media__img--full">
                        <img src="assets/img/about/mission-vision-left.png" alt="SUM Ultimate Medicare">
                    </figure>
                    <div class="sum-about-vision-card">
                        <div class="sum-about-vision-card__icon">
                            <img src="assets/img/about/about8-3.svg" alt="">
                        </div>
                        <div>
                            <h6>VISION</h6>
                            <p><?php echo htmlspecialchars($visionText, ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <article class="about-content-eight sum-about-content-card">
                    <div class="sum-about-mission-box">
                        <div class="icon-box"><img src="assets/img/about/about8-3.svg" alt=""></div>
                        <div class="content-box">
                            <span class="h6 d-block mb-2">MISSION</span>
                            <p class="mb-0"><?php echo htmlspecialchars($missionText, ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="space pt-0">
    <div class="container-style8">
        <div class="sum-content-card mb-4">
            <h2 class="h4 mb-3">Our Story</h2>
            <p class="mb-0"><?php echo htmlspecialchars($aboutInstitutional['story'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="row g-4 mb-4">
            <?php foreach ($aboutInstitutional['highlights'] as $item): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="sum-highlight-card h-100">
                        <h3 class="h6"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p class="mb-0"><?php echo htmlspecialchars($item['text'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="sum-content-card">
            <h2 class="h4 mb-3">Core Values</h2>
            <ul class="sum-check-list mb-0">
                <?php foreach ($aboutInstitutional['values'] as $value): ?>
                    <li><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section class="space pt-0 pb-5">
    <div class="container-style8">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="sum-content-card h-100 text-center">
                    <h3 class="h6 text-uppercase">Location</h3>
                    <p class="mb-0"><?php echo nl2br(sum_contact_e('address')); ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sum-content-card h-100 text-center">
                    <h3 class="h6 text-uppercase">EPABX</h3>
                    <p class="mb-0"><a href="tel:<?php echo sum_contact_e('epabx_tel'); ?>"><?php echo sum_contact_e('epabx_display'); ?></a></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sum-content-card h-100 text-center">
                    <h3 class="h6 text-uppercase">Email</h3>
                    <p class="mb-0"><a href="mailto:<?php echo sum_contact_e('email'); ?>"><?php echo sum_contact_e('email'); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
