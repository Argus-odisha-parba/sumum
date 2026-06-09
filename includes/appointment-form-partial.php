<?php
/**
 * Reusable appointment booking form.
 *
 * Optional variables before include:
 * @var string $appointmentBookStatus  'success' | 'error' | ''
 * @var string $appointmentReturnTo    redirect target after submit (e.g. appointment.php)
 * @var string $appointmentPreselect   pre-selected department/service name
 * @var string $appointmentFormIdPrefix unique ID prefix when multiple forms on one page
 */

$appointmentBookStatus = $appointmentBookStatus ?? ($_GET['booked'] ?? '');
$appointmentReturnTo = $appointmentReturnTo ?? 'appointment.php';
$appointmentPreselect = trim($appointmentPreselect ?? ($_GET['service'] ?? ''));
$appointmentFormIdPrefix = $appointmentFormIdPrefix ?? 'sumAppt';

if ($appointmentPreselect === '' && !empty($_GET['dept'])) {
    $deptSlug = trim((string) $_GET['dept']);
    foreach ($departmentItems as $deptName) {
        if (sum_dept_slug($deptName) === $deptSlug) {
            $appointmentPreselect = $deptName;
            break;
        }
    }
}
?>
<?php if ($appointmentBookStatus === 'success'): ?>
    <div class="sum-appointment-alert sum-appointment-alert--success" role="status">Thank you! Your appointment request has been submitted. Our team will contact you shortly.</div>
<?php elseif ($appointmentBookStatus === 'error'): ?>
    <div class="sum-appointment-alert sum-appointment-alert--error" role="alert">Please fill in all required fields correctly and try again.</div>
<?php endif; ?>
<form action="appointment-submit.php" method="post" class="form-wrap4 sum-appointment-form">
    <input type="hidden" name="return_to" value="<?php echo htmlspecialchars($appointmentReturnTo, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="testi-form-title">
        <div class="icon-box"><img src="assets/img/testimonial/testi8-1.svg" alt=""></div>
        <div class="content-box">
            <h4 class="title">Book An Appointment</h4>
            <span>Please fill in your details — our team will confirm your slot</span>
        </div>
    </div>
    <div class="form-box-three">
        <div class="row">
            <div class="col-lg-12 col-md-6 form-group">
                <label class="visually-hidden" for="<?php echo $appointmentFormIdPrefix; ?>Service">Type of Service</label>
                <select class="form-select" id="<?php echo $appointmentFormIdPrefix; ?>Service" name="service" required>
                    <option value="" hidden disabled<?php echo $appointmentPreselect === '' ? ' selected' : ''; ?>>Type of Service</option>
                    <?php foreach ($departmentItems as $dept): ?>
                        <option value="<?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $appointmentPreselect === $dept ? ' selected' : ''; ?>><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6 col-md-6 form-group">
                <label class="visually-hidden" for="<?php echo $appointmentFormIdPrefix; ?>Date">Date</label>
                <input type="text" class="date-pick form-control" id="<?php echo $appointmentFormIdPrefix; ?>Date" name="appointment_date" placeholder="Preferred date" required autocomplete="off">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <div class="col-lg-6 col-md-6 form-group">
                <label class="visually-hidden" for="<?php echo $appointmentFormIdPrefix; ?>Time">Time</label>
                <input type="text" class="time-pick form-control" id="<?php echo $appointmentFormIdPrefix; ?>Time" name="appointment_time" placeholder="Preferred time" required autocomplete="off">
                <i class="fa fa-clock" aria-hidden="true"></i>
            </div>
            <div class="col-lg-6 col-md-6 form-group">
                <label class="visually-hidden" for="<?php echo $appointmentFormIdPrefix; ?>Name">Name</label>
                <input type="text" class="form-control" id="<?php echo $appointmentFormIdPrefix; ?>Name" name="name" placeholder="Full name" required>
            </div>
            <div class="col-lg-6 col-md-6 form-group">
                <label class="visually-hidden" for="<?php echo $appointmentFormIdPrefix; ?>Email">Email</label>
                <input type="email" class="form-control" id="<?php echo $appointmentFormIdPrefix; ?>Email" name="email" placeholder="Email address" required>
            </div>
            <div class="col-lg-12 col-md-6 form-group">
                <label class="visually-hidden" for="<?php echo $appointmentFormIdPrefix; ?>Phone">Phone No</label>
                <input type="tel" class="form-control" id="<?php echo $appointmentFormIdPrefix; ?>Phone" name="phone" placeholder="Phone number" required>
            </div>
            <div class="col-xl-6 col-lg-7 col-md-6 col-sm-6 form-group mb-0">
                <button type="submit" class="btn-style8 v10">Make Appointment</button>
            </div>
        </div>
    </div>
</form>
