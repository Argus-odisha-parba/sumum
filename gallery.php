<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'Gallery | SUM Ultimate Medicare';
$currentPage = 'gallery';
$bodyClass = 'sum-gallery-page';
$metaDescription = 'Photo gallery of SUM Ultimate Medicare, Bhubaneswar — hospital infrastructure, clinical care, technology, events, and community outreach.';
include __DIR__ . '/includes/header.php';
?>

<section class="sum-hp-hero sum-gallery-hero">
    <div class="sum-hp-hero__bg" aria-hidden="true"></div>
    <div class="container-style8 sum-hp-hero__inner">
        <nav class="sum-hp-breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <span aria-hidden="true">/</span>
            <span>Gallery</span>
        </nav>
        <div class="row align-items-end g-4">
            <div class="col-lg-7">
                <p class="sum-hp-hero__eyebrow"><i class="fas fa-images" aria-hidden="true"></i> Visual tour</p>
                <h1>Hospital Gallery</h1>
                <p class="sum-hp-hero__intro">Take a glimpse inside SUM Ultimate Medicare — our facilities, clinical teams, advanced technology, and community initiatives that define compassionate, world-class care in Bhubaneswar.</p>
            </div>
            <div class="col-lg-5">
                <div class="sum-hp-hero__stats">
                    <div class="sum-hp-stat">
                        <span class="sum-hp-stat__value"><?php echo count($galleryItems); ?>+</span>
                        <span class="sum-hp-stat__label">Photos &amp; moments</span>
                    </div>
                    <div class="sum-hp-stat">
                        <span class="sum-hp-stat__value"><?php echo count($galleryCategories) - 1; ?></span>
                        <span class="sum-hp-stat__label">Categories</span>
                    </div>
                    <div class="sum-hp-stat">
                        <span class="sum-hp-stat__value">24/7</span>
                        <span class="sum-hp-stat__label">Care &amp; emergency</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sum-gallery-benefits">
    <div class="container-style8">
        <div class="row g-3 g-lg-4">
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-hospital"></i></span>
                    <h2>World-class infrastructure</h2>
                    <p>Modern OT complexes, ICUs, and patient-friendly spaces designed for safety and comfort.</p>
                </article>
            </div>
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-microscope"></i></span>
                    <h2>Advanced technology</h2>
                    <p>State-of-the-art diagnostics, imaging, and lab services supporting precise clinical decisions.</p>
                </article>
            </div>
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-user-md"></i></span>
                    <h2>Expert clinicians</h2>
                    <p>Specialists across departments delivering coordinated, evidence-based treatment pathways.</p>
                </article>
            </div>
            <div class="col-md-6 col-lg-3">
                <article class="sum-hp-benefit">
                    <span class="sum-hp-benefit__icon" aria-hidden="true"><i class="fas fa-hands-helping"></i></span>
                    <h2>Community outreach</h2>
                    <p>Health camps, awareness drives, and initiatives that extend care beyond hospital walls.</p>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="sum-gallery-listing pb-5">
    <div class="container-style8">
        <header class="sum-gallery__head">
            <div>
                <h2 class="sum-gallery-page__title">Explore our spaces</h2>
                <p class="sum-gallery-page__subtitle">Filter by category or browse all photos. Click any image to view full size.</p>
            </div>
            <div class="sum-gallery__filter">
                <div class="sum-gallery-filters" role="tablist" aria-label="Gallery categories">
                    <?php foreach ($galleryCategories as $slug => $label): ?>
                        <button type="button"
                            class="sum-gallery-filter<?php echo $slug === 'all' ? ' is-active' : ''; ?>"
                            data-filter="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>"
                            role="tab"
                            aria-selected="<?php echo $slug === 'all' ? 'true' : 'false'; ?>">
                            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </header>

        <div class="sum-gallery-grid" id="sumGalleryGrid">
            <?php foreach ($galleryItems as $item):
                $isFeatured = !empty($item['featured']);
                $catLabel = $galleryCategories[$item['category']] ?? ucfirst($item['category']);
            ?>
                <article class="sum-gallery-card sum-gallery-card--page<?php echo $isFeatured ? ' sum-gallery-card--wide' : ''; ?>"
                    data-category="<?php echo htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8'); ?>">
                    <a href="<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" class="sum-gallery-card__link popup-image" title="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>">
                        <img src="<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                        <span class="sum-gallery-card__overlay" aria-hidden="true"><i class="fas fa-expand-alt"></i></span>
                        <span class="sum-gallery-card__tag"><?php echo htmlspecialchars($catLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                    </a>
                    <div class="sum-gallery-card__caption">
                        <h3><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="sum-gallery-empty text-center py-5 d-none" id="sumGalleryEmpty">No photos in this category yet.</p>
    </div>
</section>

<section class="sum-hp-cta">
    <div class="container-style8">
        <div class="sum-hp-cta__box">
            <div class="sum-hp-cta__content">
                <h2>Experience our care in person</h2>
                <p>Schedule a visit, book a consultation, or speak with our team to learn more about our facilities and services.</p>
            </div>
            <div class="sum-hp-cta__actions">
                <a href="https://appt.soahospitals.com/" class="sum-hp-cta__btn sum-hp-cta__btn--primary" target="_blank" rel="noopener"><i class="fas fa-calendar-check" aria-hidden="true"></i> Book appointment</a>
                <a href="contact.php" class="sum-hp-cta__btn sum-hp-cta__btn--ghost">Contact us</a>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var filters = document.querySelectorAll('.sum-gallery-filter');
    var cards = document.querySelectorAll('.sum-gallery-card--page');
    var emptyMsg = document.getElementById('sumGalleryEmpty');

    function applyFilter(category) {
        var visible = 0;
        cards.forEach(function (card) {
            var show = category === 'all' || card.getAttribute('data-category') === category;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        if (emptyMsg) {
            emptyMsg.classList.toggle('d-none', visible > 0);
        }
    }

    filters.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filters.forEach(function (b) {
                b.classList.remove('is-active');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.add('is-active');
            btn.setAttribute('aria-selected', 'true');
            applyFilter(btn.getAttribute('data-filter') || 'all');
        });
    });
})();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
