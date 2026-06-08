<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'Healthcare Partners | SUM Ultimate Medicare';
$currentPage = 'partners';
$bodyClass = 'sum-partners-page';
$metaDescription = 'Insurance, corporate TPA, and government scheme partners at SUM Ultimate Medicare, Bhubaneswar — cashless hospitalization and trusted coverage support.';
include __DIR__ . '/includes/header.php';

$partnerCount = 0;
foreach ($healthPartners as $partners) {
    $partnerCount += count($partners);
}
?>

<section class="sum-hp-hero">
    <div class="sum-hp-hero__bg" aria-hidden="true"></div>
    <div class="container-style8 sum-hp-hero__inner">
        <nav class="sum-hp-breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <span aria-hidden="true">/</span>
            <span>Healthcare Partners</span>
        </nav>
        <div class="row align-items-end g-4">
            <div class="col-lg-7">
                <p class="sum-hp-hero__eyebrow"><i class="fas fa-handshake" aria-hidden="true"></i> Trusted network</p>
                <h1>Healthcare Partners</h1>
                <p class="sum-hp-hero__intro">We work with leading insurers, TPAs, and government schemes so you can focus on recovery — not paperwork. Transparent billing, dedicated coordination, and cashless options where applicable.</p>
            </div>
            <div class="col-lg-5">
                <div class="sum-hp-hero__stats">
                    <div class="sum-hp-stat">
                        <span class="sum-hp-stat__value"><?php echo (int) $partnerCount; ?>+</span>
                        <span class="sum-hp-stat__label">Partner organisations</span>
                    </div>
                    <div class="sum-hp-stat">
                        <span class="sum-hp-stat__value">24×7</span>
                        <span class="sum-hp-stat__label">Billing support desk</span>
                    </div>
                    <div class="sum-hp-stat">
                        <span class="sum-hp-stat__value">Cashless</span>
                        <span class="sum-hp-stat__label">Where policy allows</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sum-hp-benefits">
    <div class="container-style8">
        <div class="row g-3 g-lg-4">
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-file-invoice-dollar"></i></span>
                    <h2>Cashless care</h2>
                    <p>Pre-authorisation support for eligible insurance and TPA policies at admission.</p>
                </article>
            </div>
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-clock"></i></span>
                    <h2>Faster claims</h2>
                    <p>Structured documentation and billing team assistance to reduce processing delays.</p>
                </article>
            </div>
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-hospital"></i></span>
                    <h2>Wide acceptance</h2>
                    <p>Network tie-ups across insurance, corporate wellness, and public health programmes.</p>
                </article>
            </div>
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-headset"></i></span>
                    <h2>Dedicated desk</h2>
                    <p>On-site coordinators to guide patients and families through coverage queries.</p>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="sum-hp-network pb-5">
    <div class="container-style8">
        <header class="sum-hp-section-head">
            <h2>Our partner network</h2>
            <p>Select a category to explore organisations we collaborate with for patient coverage and billing.</p>
        </header>

        <?php foreach ($healthPartners as $segment => $partners):
            $meta = $healthPartnerSegments[$segment] ?? ['icon' => 'fa-hospital', 'description' => ''];
        ?>
        <div class="sum-hp-segment">
            <div class="sum-hp-segment__head">
                <span class="sum-hp-segment__icon" aria-hidden="true"><i class="fas <?php echo htmlspecialchars($meta['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i></span>
                <div>
                    <h3><?php echo htmlspecialchars($segment, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p><?php echo htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <span class="sum-hp-segment__count"><?php echo count($partners); ?> partners</span>
            </div>
            <div class="row g-3 g-lg-4">
                <?php foreach ($partners as $partner): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <article class="sum-hp-partner-card">
                        <div class="sum-hp-partner-card__logo">
                            <img src="<?php echo htmlspecialchars($partner['logo'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($partner['name'], ENT_QUOTES, 'UTF-8'); ?> logo" loading="lazy">
                        </div>
                        <h4><?php echo htmlspecialchars($partner['name'], ENT_QUOTES, 'UTF-8'); ?></h4>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="sum-hp-cta">
    <div class="container-style8">
        <div class="sum-hp-cta__box">
            <div class="sum-hp-cta__content">
                <h2>Questions about coverage or cashless admission?</h2>
                <p>Our billing and insurance desk can verify your policy, explain documents needed, and guide you before or during your visit.</p>
            </div>
            <div class="sum-hp-cta__actions">
                <a href="tel:+916743500500" class="sum-hp-cta__btn sum-hp-cta__btn--outline"><i class="fas fa-phone-alt" aria-hidden="true"></i> +91 0674 3 500 500</a>
                <a href="contact.php" class="sum-hp-cta__btn sum-hp-cta__btn--ghost">Contact us</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
