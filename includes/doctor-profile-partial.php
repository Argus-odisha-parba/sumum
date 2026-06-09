<?php



function sum_doctor_profile_slug(string $id): string

{

    return preg_replace('/[^a-zA-Z0-9\-]/', '', $id);

}



function sum_doctor_profile_url(string $id): string

{

    $slug = sum_doctor_profile_slug($id);

    return $slug === '' ? 'doctor.php' : 'doctors/' . $slug;

}



function sum_doctor_profile_canonical_url(string $id): string

{

    return sum_absolute_url(sum_doctor_profile_url($id));

}



function sum_doctor_id_from_path(string $path): ?string

{

    if (preg_match('#/doctors/([a-zA-Z0-9\-]+)/?$#', $path, $m)) {

        return $m[1];

    }

    return null;

}



function sum_doctor_profile_description(array $doc): string

{

    $desc = trim($doc['description'] ?? '');

    if ($desc !== '') {

        return $desc;

    }

    $name = $doc['name'] ?? 'Our specialist';

    $dept = $doc['department'] ?? 'medicine';

    $qual = trim($doc['qualification'] ?? '');

    $text = $name . ' is a consultant in ' . $dept . ' at SUM Ultimate Medicare, Bhubaneswar.';

    if ($qual !== '') {

        $text .= ' Qualification: ' . $qual . '.';

    }

    $text .= ' Committed to compassionate, evidence-based care for patients and families.';

    return $text;

}



function sum_render_doctor_profile(array $doc, string $mode = 'page'): void

{

    $deptSlug = sum_dept_slug($doc['department'] ?? '');

    $deptUrl = 'department-detail.php?dept=' . urlencode($deptSlug);

    $bio = sum_doctor_profile_description($doc);

    $isModal = $mode === 'modal';

    $isPage = $mode === 'page';

    $name = $doc['name'] ?? '';

    $dept = $doc['department'] ?? '';

    $qual = $doc['qualification'] ?? '';

    $headingTag = $isPage ? 'h1' : 'h2';

    $aboutTag = $isPage ? 'h2' : 'h3';

    ?>

    <article class="sum-doctor-profile<?php echo $isModal ? ' sum-doctor-profile--modal' : ''; ?><?php echo $isPage ? ' sum-doctor-profile--page' : ''; ?>">

        <header class="sum-doctor-profile__hero">

            <div class="sum-doctor-profile__hero-bg" aria-hidden="true"></div>

            <div class="sum-doctor-profile__hero-grid">

                <div class="sum-doctor-profile__photo-wrap">

                    <div class="sum-doctor-profile__photo">

                        <img src="<?php echo htmlspecialchars($doc['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">

                    </div>

                    <?php if ($isPage): ?>

                    <span class="sum-doctor-profile__verified"><i class="fas fa-user-md" aria-hidden="true"></i> Consultant</span>

                    <?php endif; ?>

                </div>

                <div class="sum-doctor-profile__intro">

                    <?php if ($isModal): ?>

                        <p class="sum-doctor-profile__eyebrow">Consultant Profile</p>

                    <?php else: ?>

                        <p class="sum-doctor-profile__eyebrow">SUM Ultimate Medicare · Bhubaneswar</p>

                    <?php endif; ?>

                    <?php if ($dept !== ''): ?>

                        <a href="<?php echo htmlspecialchars($deptUrl, ENT_QUOTES, 'UTF-8'); ?>" class="sum-doctor-profile__badge"><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></a>

                    <?php endif; ?>

                    <<?php echo $headingTag; ?> class="sum-doctor-profile__name"<?php echo $isModal ? ' id="sumDoctorModalTitle"' : ''; ?>><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></<?php echo $headingTag; ?>>

                    <?php if ($qual !== ''): ?>

                        <p class="sum-doctor-profile__qual"><i class="fas fa-graduation-cap" aria-hidden="true"></i> <?php echo htmlspecialchars($qual, ENT_QUOTES, 'UTF-8'); ?></p>

                    <?php endif; ?>

                    <?php if ($isPage): ?>

                    <p class="sum-doctor-profile__tagline">Dedicated to safe, compassionate, and evidence-based patient care.</p>

                    <?php endif; ?>

                    <div class="sum-doctor-profile__actions">

                        <a href="<?php echo htmlspecialchars(sum_appointment_url($dept !== '' ? ['service' => $dept] : []), ENT_QUOTES, 'UTF-8'); ?>" class="sum-doctor-profile__btn sum-doctor-profile__btn--primary"<?php echo sum_appointment_link_attrs(); ?>>

                            <i class="fas fa-calendar-check" aria-hidden="true"></i> Book Appointment

                        </a>

                        <a href="tel:+916743500500" class="sum-doctor-profile__btn sum-doctor-profile__btn--outline">

                            <i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo $isPage ? '0674 350 0500' : 'Call Hospital'; ?>

                        </a>

                        <?php if ($isPage): ?>

                        <a href="<?php echo htmlspecialchars($deptUrl, ENT_QUOTES, 'UTF-8'); ?>" class="sum-doctor-profile__btn sum-doctor-profile__btn--ghost">

                            <i class="fas fa-hospital-alt" aria-hidden="true"></i> Department

                        </a>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </header>



        <div class="sum-doctor-profile__content">

            <?php if ($isPage): ?>

            <ul class="sum-doctor-profile__highlights" aria-label="Profile highlights">

                <li>

                    <span class="sum-doctor-profile__highlight-icon"><i class="fas fa-stethoscope" aria-hidden="true"></i></span>

                    <span class="sum-doctor-profile__highlight-text"><strong>Specialty</strong><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></span>

                </li>

                <?php if ($qual !== ''): ?>

                <li>

                    <span class="sum-doctor-profile__highlight-icon"><i class="fas fa-award" aria-hidden="true"></i></span>

                    <span class="sum-doctor-profile__highlight-text"><strong>Qualification</strong><?php echo htmlspecialchars($qual, ENT_QUOTES, 'UTF-8'); ?></span>

                </li>

                <?php endif; ?>

                <li>

                    <span class="sum-doctor-profile__highlight-icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>

                    <span class="sum-doctor-profile__highlight-text"><strong>Location</strong>Bhubaneswar, Odisha</span>

                </li>

                <li>

                    <span class="sum-doctor-profile__highlight-icon"><i class="fas fa-heartbeat" aria-hidden="true"></i></span>

                    <span class="sum-doctor-profile__highlight-text"><strong>Care</strong>Patient-first approach</span>

                </li>

            </ul>

            <?php endif; ?>



            <div class="sum-doctor-profile__layout">

                <div class="sum-doctor-profile__main">

                    <<?php echo $aboutTag; ?> class="sum-doctor-profile__heading">About <?php echo $isPage ? 'the doctor' : ''; ?></<?php echo $aboutTag; ?>>

                    <p class="sum-doctor-profile__bio"><?php echo nl2br(htmlspecialchars($bio, ENT_QUOTES, 'UTF-8')); ?></p>



                    <?php if ($isPage): ?>

                    <div class="sum-doctor-profile__care-box">

                        <h3 class="sum-doctor-profile__care-title"><i class="fas fa-hand-holding-medical" aria-hidden="true"></i> What you can expect</h3>

                        <ul class="sum-doctor-profile__care-list">

                            <li>Clear communication and thorough consultation</li>

                            <li>Evidence-based diagnosis and treatment plans</li>

                            <li>Coordination with SUM Ultimate Medicare departments</li>

                            <li>Access to modern diagnostics and hospital facilities</li>

                        </ul>

                    </div>

                    <?php endif; ?>

                </div>



                <?php if ($isPage): ?>

                <aside class="sum-doctor-profile__sidebar">

                    <div class="sum-doctor-profile__cta-card">

                        <p class="sum-doctor-profile__cta-label">Ready to visit?</p>

                        <h3>Book with <?php echo htmlspecialchars(explode(' ', $name)[0] ?? 'our team', ENT_QUOTES, 'UTF-8'); ?></h3>

                        <p>Schedule an appointment online or call our helpline for assistance.</p>

                        <a href="<?php echo htmlspecialchars(sum_appointment_url($dept !== '' ? ['service' => $dept] : []), ENT_QUOTES, 'UTF-8'); ?>" class="sum-doctor-profile__cta-btn"<?php echo sum_appointment_link_attrs(); ?>>

                            <i class="fas fa-calendar-check" aria-hidden="true"></i> Book online

                        </a>

                        <a href="tel:+916743500500" class="sum-doctor-profile__cta-phone">

                            <i class="fas fa-phone" aria-hidden="true"></i> +91 0674 350 0500

                        </a>

                    </div>

                    <ul class="sum-doctor-profile__facts">

                        <li>

                            <i class="fas fa-hospital-alt" aria-hidden="true"></i>

                            <div>

                                <strong>Department</strong>

                                <a href="<?php echo htmlspecialchars($deptUrl, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></a>

                            </div>

                        </li>

                        <?php if ($qual !== ''): ?>

                        <li>

                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>

                            <div>

                                <strong>Qualification</strong>

                                <span><?php echo htmlspecialchars($qual, ENT_QUOTES, 'UTF-8'); ?></span>

                            </div>

                        </li>

                        <?php endif; ?>

                        <li>

                            <i class="fas fa-building" aria-hidden="true"></i>

                            <div>

                                <strong>Hospital</strong>

                                <span>SUM Ultimate Medicare</span>

                            </div>

                        </li>

                    </ul>

                </aside>

                <?php else: ?>

                <ul class="sum-doctor-profile__facts sum-doctor-profile__facts--inline">

                    <li><strong>Department</strong><span><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></span></li>

                    <?php if ($qual !== ''): ?>

                    <li><strong>Qualification</strong><span><?php echo htmlspecialchars($qual, ENT_QUOTES, 'UTF-8'); ?></span></li>

                    <?php endif; ?>

                    <li><strong>Hospital</strong><span>SUM Ultimate Medicare, Bhubaneswar</span></li>

                </ul>

                <?php endif; ?>

            </div>

        </div>

    </article>

    <?php

}

