<?php
require_once __DIR__ . '/includes/data.php';

$pageTitle = 'Book Appointment | SUM Ultimate Medicare';
$currentPage = 'appointment';
$appointmentReturnTo = 'appointment.php';
$appointmentPreselect = trim($_GET['service'] ?? '');

include __DIR__ . '/includes/header.php';
?>
<main>
    <section class="sum-page-hero sum-page-hero--appointment">
        <div class="container-style8">
            <p class="sum-department-eyebrow">APPOINTMENT</p>
            <h1>Book An Appointment</h1>
            <p class="sum-department-intro">Schedule a visit with our specialists. Choose your department, preferred date and time, and we will contact you to confirm.</p>
        </div>
    </section>

    <section class="sum-appointment-page space pt-0 pb-5">
        <div class="container-style8">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <div class="sum-appointment-page__info">
                        <h2>How it works</h2>
                        <ol class="sum-appointment-page__steps">
                            <li>Fill in the appointment form with your preferred department and time.</li>
                            <li>Our coordination team reviews your request.</li>
                            <li>We call or email you to confirm your appointment slot.</li>
                        </ol>
                        <div class="sum-appointment-page__contact">
                            <h3>Need help?</h3>
                            <p class="mb-2"><i class="fas fa-phone-alt" aria-hidden="true"></i> <a href="tel:<?php echo sum_contact_e('epabx_tel'); ?>"><?php echo sum_contact_e('epabx_display'); ?></a></p>
                            <p class="mb-2"><i class="fas fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php echo sum_contact_e('email'); ?>"><?php echo sum_contact_e('email'); ?></a></p>
                            <p class="mb-0"><i class="fas fa-clock" aria-hidden="true"></i> <?php echo sum_contact_e('hours_summary'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" id="book-appointment">
                    <div class="sum-appointment-page__form-card">
                        <?php include __DIR__ . '/includes/appointment-form-partial.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
