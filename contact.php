<?php
require_once __DIR__ . '/includes/data.php';
$pageTitle = 'Contact | SUM Ultimate Medicare';
$currentPage = 'contact';
include __DIR__ . '/includes/header.php';
?>
<main>
    <section class="sum-department-hero">
        <div class="container-style8">
            <p class="sum-department-eyebrow">CONTACT</p>
            <h1>Get In Touch</h1>
            <p class="sum-department-intro"><?php echo sum_contact_e('contact_intro'); ?></p>
        </div>
    </section>
    <section class="sum-department-listing pb-5">
        <div class="container-style8">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                        <h5>Contact Details</h5>
                        <p class="mb-2"><i class="fas fa-map-marker-alt text-theme me-2" aria-hidden="true"></i><?php echo nl2br(sum_contact_e('address')); ?></p>
                        <p class="mb-1">EPABX: <a href="tel:<?php echo sum_contact_e('epabx_tel'); ?>"><?php echo sum_contact_e('epabx_display'); ?></a></p>
                        <?php if (sum_contact_val('ambulance_display') !== ''): ?>
                            <p class="mb-1">Ambulance: <a href="tel:<?php echo sum_contact_e('ambulance_tel'); ?>"><?php echo sum_contact_e('ambulance_display'); ?></a></p>
                        <?php endif; ?>
                        <p class="mb-1">Email: <a href="mailto:<?php echo sum_contact_e('email'); ?>"><?php echo sum_contact_e('email'); ?></a></p>
                        <?php if (sum_contact_val('map_url') !== ''): ?>
                            <p class="mb-0"><a href="<?php echo sum_contact_e('map_url'); ?>" target="_blank" rel="noopener">View on Google Maps <i class="fas fa-external-link-alt" aria-hidden="true"></i></a></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                        <h5>Visiting Hours</h5>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><strong>Mon – Fri:</strong> <?php echo sum_contact_e('hours_weekdays'); ?></li>
                            <li class="mb-2"><strong>Saturday:</strong> <?php echo sum_contact_e('hours_saturday'); ?></li>
                            <li class="mb-2"><strong>Sunday:</strong> <?php echo sum_contact_e('hours_sunday'); ?></li>
                        </ul>
                        <a href="<?php echo sum_contact_e('appointment_url'); ?>" class="btn btn-primary" target="_blank" rel="noopener">
                            <i class="fas fa-calendar-check" aria-hidden="true"></i> Book appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
