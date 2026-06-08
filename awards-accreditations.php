<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'Awards & Accreditations | SUM Ultimate Medicare';
$currentPage = 'awards';
$bodyClass = 'sum-awards-page';
$metaDescription = 'Awards, accolades, and accreditations at SUM Ultimate Medicare — NABH, JCI Prime, clinical excellence, and national healthcare recognitions in Bhubaneswar.';
include __DIR__ . '/includes/header.php';
?>

<section class="sum-hp-hero sum-awards-hero">
    <div class="sum-hp-hero__bg" aria-hidden="true"></div>
    <div class="container-style8 sum-hp-hero__inner">
        <nav class="sum-hp-breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <span aria-hidden="true">/</span>
            <span>Awards &amp; Accreditations</span>
        </nav>
        <div class="row align-items-end g-4">
            <div class="col-lg-7">
                <p class="sum-hp-hero__eyebrow"><i class="fas fa-trophy" aria-hidden="true"></i> Recognitions</p>
                <h1>Awards &amp; Accreditations</h1>
                <p class="sum-hp-hero__intro">Our commitment to clinical excellence, patient safety, and quality care is reflected in national and international accreditations — and accolades that celebrate the teams behind every milestone.</p>
            </div>
            <div class="col-lg-5">
                <div class="sum-hp-hero__stats">
                    <?php foreach ($awardsStats as $stat): ?>
                        <div class="sum-hp-stat">
                            <span class="sum-hp-stat__value"><?php echo htmlspecialchars($stat['value'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="sum-hp-stat__label"><?php echo htmlspecialchars($stat['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sum-awards-highlights">
    <div class="container-style8">
        <header class="sum-awards-section-head text-center">
            <h2>Accreditation highlights</h2>
            <p>Independent validation of our quality systems, patient safety culture, and commitment to international standards of care.</p>
        </header>
        <div class="row g-4">
            <?php foreach ($accreditationHighlights as $item): ?>
                <div class="col-lg-4">
                    <article class="sum-award-highlight sum-award-highlight--<?php echo htmlspecialchars($item['tone'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="sum-award-highlight__top">
                            <span class="sum-award-highlight__icon" aria-hidden="true"><i class="fas <?php echo htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i></span>
                            <?php if (!empty($item['badge'])): ?>
                                <span class="sum-award-highlight__badge"><?php echo htmlspecialchars($item['badge'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="sum-award-highlight__year"><?php echo htmlspecialchars($item['year'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <h3><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p class="sum-award-highlight__subtitle"><?php echo htmlspecialchars($item['subtitle'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="sum-award-highlight__text"><?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="sum-awards-timeline pb-5">
    <div class="container-style8">
        <header class="sum-awards-section-head">
            <h2>Milestones &amp; accolades</h2>
            <p>A timeline of recognitions that reflect our journey toward safer, smarter, and more compassionate healthcare.</p>
        </header>

        <div class="sum-awards-timeline__track">
            <?php foreach ($awardsTimeline as $index => $award): ?>
                <article class="sum-award-entry<?php echo $index % 2 === 0 ? ' sum-award-entry--left' : ' sum-award-entry--right'; ?>">
                    <div class="sum-award-entry__marker" aria-hidden="true">
                        <span class="sum-award-entry__year"><?php echo htmlspecialchars($award['year'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="sum-award-entry__dot"><i class="fas <?php echo htmlspecialchars($award['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i></span>
                    </div>
                    <div class="sum-award-entry__card">
                        <span class="sum-award-entry__category"><?php echo htmlspecialchars($award['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <h3><?php echo htmlspecialchars($award['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><?php echo htmlspecialchars($award['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="sum-awards-trust">
    <div class="container-style8">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="sum-awards-trust__visual">
                    <img src="assets/img/about/mission-vision-left.png" alt="SUM Ultimate Medicare excellence" loading="lazy">
                    <div class="sum-awards-trust__badge">
                        <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        <span>Trusted care<br>since day one</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2>Why accreditations matter</h2>
                <p class="sum-awards-trust__lead">Accreditations are more than certificates — they represent rigorous audits, measurable outcomes, and a hospital-wide commitment to doing what is right for every patient.</p>
                <ul class="sum-check-list sum-awards-trust__list">
                    <li>Standardised clinical protocols and safety checklists</li>
                    <li>Transparent infection control and medication practices</li>
                    <li>Continuous staff training and competency assessment</li>
                    <li>Patient rights, feedback loops, and grievance redressal</li>
                    <li>Evidence-based care aligned with global best practices</li>
                </ul>
                <a href="about.php" class="sum-awards-trust__link">Learn about our hospital <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>

<section class="sum-hp-cta">
    <div class="container-style8">
        <div class="sum-hp-cta__box">
            <div class="sum-hp-cta__content">
                <h2>Experience accredited care firsthand</h2>
                <p>Book a consultation or speak with our team to learn how our quality systems translate into safer, better outcomes for you and your family.</p>
            </div>
            <div class="sum-hp-cta__actions">
                <a href="https://appt.soahospitals.com/" class="sum-hp-cta__btn sum-hp-cta__btn--primary" target="_blank" rel="noopener"><i class="fas fa-calendar-check" aria-hidden="true"></i> Book appointment</a>
                <a href="tel:+916743500500" class="sum-hp-cta__btn sum-hp-cta__btn--outline"><i class="fas fa-phone-alt" aria-hidden="true"></i> Call us</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
