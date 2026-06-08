<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'Health Check Packages | SUM Ultimate Medicare';
$currentPage = 'packages';
$bodyClass = 'sum-packages-page';
$metaDescription = 'Preventive health check packages at SUM Ultimate Medicare — wellness screening, executive health, cardiac, maternity, senior care, and diabetes packages in Bhubaneswar.';
include __DIR__ . '/includes/header.php';
?>

<section class="sum-pkg-hero">
    <div class="sum-pkg-hero__bg" aria-hidden="true"></div>
    <div class="container-style8 sum-pkg-hero__inner">
        <nav class="sum-pkg-breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <span aria-hidden="true">/</span>
            <span>Health Check Packages</span>
        </nav>
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="sum-pkg-hero__eyebrow"><i class="fas fa-notes-medical" aria-hidden="true"></i> Preventive care</p>
                <h1>Health Check Packages</h1>
                <p class="sum-pkg-hero__intro">Early detection saves lives. Choose a curated screening package built around clinical protocols, same-day coordination, and specialist review — all under one roof at SUM Ultimate Medicare.</p>
                <div class="sum-pkg-hero__actions">
                    <a href="https://appt.soahospitals.com/" class="sum-pkg-hero__btn sum-pkg-hero__btn--primary" target="_blank" rel="noopener"><i class="fas fa-calendar-check" aria-hidden="true"></i> Book a package</a>
                    <a href="tel:+916743500500" class="sum-pkg-hero__btn sum-pkg-hero__btn--outline"><i class="fas fa-phone-alt" aria-hidden="true"></i> Call for details</a>
                </div>
            </div>
            <div class="col-lg-5">
                <ul class="sum-pkg-trust" aria-label="Package highlights">
                    <li><i class="fas fa-check-circle" aria-hidden="true"></i> NABH-accredited hospital</li>
                    <li><i class="fas fa-check-circle" aria-hidden="true"></i> Same-day sample collection</li>
                    <li><i class="fas fa-check-circle" aria-hidden="true"></i> Physician-led reports review</li>
                    <li><i class="fas fa-check-circle" aria-hidden="true"></i> Transparent, all-inclusive pricing</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="sum-pkg-steps">
    <div class="container-style8">
        <ol class="sum-pkg-steps__list">
            <li class="sum-pkg-step">
                <span class="sum-pkg-step__num">1</span>
                <div>
                    <strong>Choose your package</strong>
                    <span>Pick screening suited to age, lifestyle, or clinical need.</span>
                </div>
            </li>
            <li class="sum-pkg-step">
                <span class="sum-pkg-step__num">2</span>
                <div>
                    <strong>Book online or by phone</strong>
                    <span>Schedule a convenient date with our health check desk.</span>
                </div>
            </li>
            <li class="sum-pkg-step">
                <span class="sum-pkg-step__num">3</span>
                <div>
                    <strong>Visit &amp; get results</strong>
                    <span>Complete tests in one visit; receive guided follow-up.</span>
                </div>
            </li>
        </ol>
    </div>
</section>

<section class="sum-pkg-listing pb-5">
    <div class="container-style8">
        <header class="sum-pkg-section-head">
            <h2>Available packages</h2>
            <p>All packages include coordinated sample collection, core diagnostics, and a physician consultation unless noted otherwise.</p>
        </header>

        <div class="row g-4">
            <?php foreach ($healthPackages as $index => $package):
                $isFeatured = !empty($package['featured']);
                $icon = $package['icon'] ?? 'fa-notes-medical';
                $badge = $package['badge'] ?? '';
            ?>
            <div class="col-lg-4 col-md-6">
                <article class="sum-pkg-card<?php echo $isFeatured ? ' sum-pkg-card--featured' : ''; ?>" style="--pkg-delay: <?php echo (int) $index * 0.06; ?>s">
                    <?php if ($badge !== ''): ?>
                    <span class="sum-pkg-card__badge"><?php echo htmlspecialchars($badge, ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php endif; ?>
                    <div class="sum-pkg-card__top">
                        <span class="sum-pkg-card__icon" aria-hidden="true"><i class="fas <?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>"></i></span>
                        <div class="sum-pkg-card__price-wrap">
                            <span class="sum-pkg-card__from">Starting at</span>
                            <span class="sum-pkg-card__price"><?php echo htmlspecialchars($package['price'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                    <h3 class="sum-pkg-card__title"><?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="sum-pkg-card__desc"><?php echo htmlspecialchars($package['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="sum-pkg-card__includes">
                        <h4>What&rsquo;s included</h4>
                        <ul>
                            <?php foreach ($package['includes'] as $item): ?>
                            <li><i class="fas fa-check" aria-hidden="true"></i><?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <a href="https://appt.soahospitals.com/" class="sum-pkg-card__btn" target="_blank" rel="noopener">
                        Book this package <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="sum-pkg-why">
    <div class="container-style8">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <h2>Why book health checks with us?</h2>
                <p class="sum-pkg-why__lead">Screening at a multi-super specialty hospital means abnormal findings are acted on immediately — with specialists, advanced imaging, and emergency backup on campus.</p>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="sum-pkg-why-item">
                            <i class="fas fa-microscope" aria-hidden="true"></i>
                            <div>
                                <strong>Accredited lab</strong>
                                <span>Quality-controlled diagnostics with timely reporting.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sum-pkg-why-item">
                            <i class="fas fa-user-md" aria-hidden="true"></i>
                            <div>
                                <strong>Expert review</strong>
                                <span>Consultants interpret results and plan next steps.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sum-pkg-why-item">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <div>
                                <strong>One-campus convenience</strong>
                                <span>Tests, imaging, and consults in a single visit flow.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sum-pkg-why-item">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                            <div>
                                <strong>Continuity of care</strong>
                                <span>Seamless referral to departments if follow-up is needed.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sum-pkg-cta">
    <div class="container-style8">
        <div class="sum-pkg-cta__box">
            <div>
                <h2>Not sure which package fits you?</h2>
                <p>Call our health check desk — we&rsquo;ll recommend screening based on age, medical history, and your goals.</p>
            </div>
            <a href="tel:+916743500500" class="sum-pkg-cta__phone"><i class="fas fa-phone-alt" aria-hidden="true"></i> +91 0674 3 500 500</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
