<?php
require_once __DIR__ . '/data.php';
if (!isset($pageTitle)) {
    $pageTitle = 'SUM Ultimate Medicare';
}
if (!isset($currentPage)) {
    $currentPage = '';
}
if (!isset($bodyClass)) {
    $bodyClass = '';
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <?php if (!empty($metaDescription)): ?>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <?php if (!empty($canonicalUrl)): ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="author" content="SUM Ultimate Medicare">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="<?php echo htmlspecialchars(sum_base_href(), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Quicksand:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/layerslider.min.css">
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/slick.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?php echo htmlspecialchars(trim($bodyClass), ENT_QUOTES, 'UTF-8'); ?>">
    <!--==============================
     Preloader
    ==============================-->
    <div class="preloader">
        <button class="vs-btn preloaderCls">Cancel Preloader </button>
        <div class="preloader-inner">
            <svg width="88px" height="108px" viewBox="0 0 54 64">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <path class="beat-loader" d="M0.5,38.5 L16,38.5 L19,25.5 L24.5,57.5 L31.5,7.5 L37.5,46.5 L43,38.5 L53.5,38.5" stroke-width="2"></path>
                </g>
            </svg>
        </div>
    </div>

    <!--==============================
    Mobile Menu
    ============================== -->
    <div class="vs-menu-wrapper">
        <div class="vs-menu-area sum-mobile-menu-theme">
            <div class="sum-mobile-drawer-head">
                <a href="index.php" class="sum-mobile-drawer-logo"><img src="assets/img/logo-mobile.svg" alt="SUM Ultimate Medicare"></a>
                <button type="button" class="vs-menu-toggle sum-mobile-drawer-close" aria-label="Close menu"><i class="fal fa-times" aria-hidden="true"></i></button>
            </div>
            <p class="sum-mobile-drawer-tagline">Multi-super specialty care · Bhubaneswar</p>
            <div class="vs-mobile-menu sum-mobile-nav-panel">
                <ul>
                    <?php sum_render_primary_nav($currentPage); ?>
                </ul>
                <div class="sum-mobile-nav-actions">
                    <a href="tel:<?php echo sum_contact_e('epabx_tel'); ?>" class="sum-mobile-nav-actions__call"><i class="fas fa-phone" aria-hidden="true"></i> <?php echo sum_contact_e('epabx_display'); ?></a>
                    <a href="<?php echo sum_contact_e('appointment_url'); ?>" class="sum-mobile-nav-actions__book"<?php echo sum_appointment_link_attrs(); ?>>Book Appointment</a>
                    <a href="https://appt.soahospitals.com/" class="sum-mobile-nav-actions__login" target="_blank" rel="noopener"><i class="fas fa-user" aria-hidden="true"></i> Login &amp; Register</a>
                </div>
            </div>
        </div>
    </div>

    <!--==============================
    Sidemenu
    ============================== -->
    <div class="sidemenu-wrapper d-none d-lg-block">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget footer-widget">
                <div class="vs-widget-about">
                    <div class="footer-logo">
                        <img src="assets/img/logo.png" alt="logo">
                    </div>
                    <p class="footer-text1">SUM Ultimate Medicare — multi-super specialty quaternary care in Bhubaneswar, Odisha. EPABX <?php echo sum_contact_e('epabx_display'); ?>.</p>
                    <div class="footer-social3">
                        <a href="https://www.facebook.com/soa.sumum" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/SUM_Ultimate" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/sum_ultimate_medicare/" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                        <a href="https://in.linkedin.com/company/sum-ultimate-medicare" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget footer-widget">
                <h3 class="widget_title">Visiting Hours</h3>
                <div class="footer-table">
                    <table>
                        <tr>
                            <td>Mon - Fri:</td>
                            <td><?php echo sum_contact_e('hours_weekdays'); ?></td>
                        </tr>
                        <tr>
                            <td>Saturday:</td>
                            <td><?php echo sum_contact_e('hours_saturday'); ?></td>
                        </tr>
                        <tr>
                            <td>Sunday:</td>
                            <td><?php echo sum_contact_e('hours_sunday'); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="address-line">
                    <i class="far fa-map-marker-alt text-theme fs-md"></i>
                    <a href="<?php echo sum_contact_e('map_url'); ?>" class="text-reset fs-md" target="_blank" rel="noopener"><?php echo sum_contact_e('address'); ?></a>
                </div>
            </div>
            <div class="widget footer-widget">
                <h4 class="widget_title">Gallery Posts</h4>
                <div class="footer-gallery">
                    <div class="gal-item"><a href="#"><img src="assets/img/widget/gal-1-1.jpg" alt="Gallery Image" class="w-100"></a></div>
                    <div class="gal-item"><a href="#"><img src="assets/img/widget/gal-1-2.jpg" alt="Gallery Image" class="w-100"></a></div>
                    <div class="gal-item"><a href="#"><img src="assets/img/widget/gal-1-3.jpg" alt="Gallery Image" class="w-100"></a></div>
                    <div class="gal-item"><a href="#"><img src="assets/img/widget/gal-1-4.jpg" alt="Gallery Image" class="w-100"></a></div>
                    <div class="gal-item"><a href="#"><img src="assets/img/widget/gal-1-5.jpg" alt="Gallery Image" class="w-100"></a></div>
                    <div class="gal-item"><a href="#"><img src="assets/img/widget/gal-1-6.jpg" alt="Gallery Image" class="w-100"></a></div>
                </div>
            </div>
        </div>
    </div>

    <!--==============================
    Popup Search Box
    ============================== -->
    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose border-theme text-theme"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" class="border-theme" placeholder="What are you looking for">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>

    <!--==============================
        Header Area
    ==============================-->
    <header class="header-wrapper header-layout8 sum-header-v8 sum-header-premium">
        <div class="sum-header-topbar-mobile d-lg-none">
            <div class="container-style8">
                <a href="tel:<?php echo sum_contact_e('epabx_tel'); ?>" class="sum-emergency-topbar sum-emergency-topbar--mobile">
                    <span class="sum-emergency-topbar__icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span>
                    <span class="sum-emergency-topbar__text">
                        <span class="sum-emergency-topbar__label">24/7 Emergency</span>
                        <span class="sum-emergency-topbar__number"><?php echo sum_contact_e('epabx_display'); ?></span>
                    </span>
                </a>
            </div>
        </div>

        <div class="header-top-eight d-none d-lg-block sum-header-topbar sum-ref-topbar">
            <div class="container-style8">
                <div class="sum-ref-topbar-shell">
                    <div class="sum-ref-topbar-start">
                        <a href="https://appt.soahospitals.com/" class="sum-ref-login-link sum-ref-login-pill" target="_blank" rel="noopener"><i class="fas fa-user" aria-hidden="true"></i> Login &amp; Register</a>
                        <a href="tel:<?php echo sum_contact_e('epabx_tel'); ?>" class="sum-emergency-topbar d-none d-lg-inline-flex">
                            <span class="sum-emergency-topbar__icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span>
                            <span class="sum-emergency-topbar__text">
                                <span class="sum-emergency-topbar__label">24/7 Emergency</span>
                                <span class="sum-emergency-topbar__number"><?php echo sum_contact_e('epabx_display'); ?></span>
                            </span>
                        </a>
                    </div>
                    <div class="sum-ref-topbar-center d-none d-xl-flex">
                        <span class="sum-ref-meta sum-ref-meta--pill"><i class="far fa-clock" aria-hidden="true"></i> <?php echo sum_contact_e('hours_summary'); ?></span>
                        <span class="sum-ref-meta sum-ref-meta--pill sum-ref-meta-address"><i class="far fa-map-marker-alt" aria-hidden="true"></i><a href="<?php echo sum_contact_e('map_url'); ?>" target="_blank" rel="noopener"><?php echo sum_contact_e('address_short'); ?></a></span>
                    </div>
                    <div class="sum-ref-topbar-center sum-ref-topbar-center--compact d-none d-lg-flex d-xl-none">
                        <span class="sum-ref-meta sum-ref-meta--pill"><i class="far fa-clock" aria-hidden="true"></i> <?php echo sum_contact_e('hours_compact'); ?></span>
                    </div>
                    <ul class="header-social-eight sum-ref-social-top mb-0 list-unstyled d-none d-lg-flex">
                        <li><a href="https://www.facebook.com/soa.sumum" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="https://twitter.com/SUM_Ultimate" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="https://www.instagram.com/sum_ultimate_medicare/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="sticky-wrap">
            <div class="sticky-active">
                <div class="header-main-eight">
                    <div class="container-style8">
                        <div class="sum-header-shell">
                            <div class="sum-header-brand">
                                <div class="header8-logo sum-header-logo-wrap">
                                    <a href="index.php" class="sum-header-logo-link"><img src="assets/img/logo.png" class="sum-header-logo-img" width="116" height="72" alt="SUM Ultimate Medicare"></a>
                                </div>
                            </div>

                            <nav class="main-menu menu-style8 sum-header-nav sum-ref-main-nav d-none d-lg-block" aria-label="Primary">
                                <div class="sum-header-nav__inner">
                                    <ul class="sum-header-nav__row sum-header-nav__row--main">
                                        <?php sum_render_nav_primary($currentPage); ?>
                                    </ul>
                                    <ul class="sum-header-nav__row sum-header-nav__row--highlights" aria-label="Featured services">
                                        <?php sum_render_nav_highlights($currentPage); ?>
                                    </ul>
                                </div>
                            </nav>

                            <div class="sum-header-tools d-lg-none">
                                <a href="<?php echo sum_contact_e('appointment_url'); ?>" class="sum-header-tool sum-header-tool--book"<?php echo sum_appointment_link_attrs(); ?>>Book</a>
                            </div>

                            <div class="sum-header-actions header-btn-eight sum-ref-header-actions d-none d-lg-flex">
                                <a href="<?php echo sum_contact_e('appointment_url'); ?>" class="btn-style8 book sum-book-cta sum-book-cta--premium"<?php echo sum_appointment_link_attrs(); ?>>
                                    <i class="fas fa-calendar-check" aria-hidden="true"></i>
                                    <span>Book Appointment</span>
                                </a>
                            </div>

                            <button type="button" class="vs-menu-toggle eight sum-header-menu-btn d-lg-none" aria-label="Open menu" aria-expanded="false"><i class="fas fa-bars" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky quick actions -->
    <div class="sum-sticky-actions" role="navigation" aria-label="Quick actions">
        <a class="sum-sticky-actions__btn sum-sticky-actions__btn--emergency" href="tel:<?php echo sum_contact_e('epabx_tel'); ?>" aria-label="Call emergency number">
            <span class="sum-sticky-actions__icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span>
            <span class="sum-sticky-actions__label">Emergency</span>
        </a>
        <a class="sum-sticky-actions__btn sum-sticky-actions__btn--book" href="<?php echo sum_contact_e('appointment_url'); ?>"<?php echo sum_appointment_link_attrs(); ?> aria-label="Book an appointment">
            <span class="sum-sticky-actions__icon" aria-hidden="true"><i class="fas fa-calendar-check"></i></span>
            <span class="sum-sticky-actions__label">Book Appointment</span>
        </a>
    </div>
