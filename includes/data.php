<?php

require_once __DIR__ . '/doctors-store.php';

function sum_dept_slug(string $name): string
{
    $name = strtolower($name);
    return trim(preg_replace('/[^a-z0-9]+/', '-', $name), '-');
}

require_once __DIR__ . '/departments-store.php';
require_once __DIR__ . '/gallery-store.php';
require_once __DIR__ . '/contact-store.php';
require_once __DIR__ . '/appointments-store.php';
require_once __DIR__ . '/db-config-store.php';

$contactDetails = sum_contact_load();

/** Web root path when the app lives in a subdirectory (e.g. /sumum). */
function sum_site_base_path(): string
{
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = str_replace('\\', '/', dirname($script));
    if ($dir === '/' || $dir === '.') {
        return '';
    }
    return rtrim($dir, '/');
}

/** Base URL for document base so assets work on rewritten paths like /doctors/slug. */
function sum_base_href(): string
{
    $base = sum_site_base_path();
    return $base === '' ? '/' : $base . '/';
}

function sum_absolute_url(string $relativePath): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $path = '/' . ltrim(str_replace('\\', '/', $relativePath), '/');
    $base = sum_site_base_path();
    if ($base !== '') {
        $path = $base . $path;
    }
    return $scheme . '://' . $host . $path;
}

$menuItems = [
    ['key' => 'home', 'label' => 'Home', 'url' => 'index.php'],
    ['key' => 'about', 'label' => 'About Us', 'url' => 'about.php'],
    ['key' => 'departments', 'label' => 'Departments', 'url' => 'department.php'],
    ['key' => 'doctors', 'label' => 'Doctors', 'url' => 'doctor.php'],
    ['key' => 'career', 'label' => 'Career', 'url' => 'career.php'],
    ['key' => 'contact', 'label' => 'Contact', 'url' => 'contact.php'],
];

$headerHighlightNav = [
    ['key' => 'packages', 'label' => 'Health Check Packages', 'url' => 'health-packages.php', 'icon' => 'fa-notes-medical'],
    ['key' => 'partners', 'label' => 'Healthcare Partners', 'url' => 'healthcare-partners.php', 'icon' => 'fa-handshake'],
];

$headerExtraNav = [
    ['key' => 'gallery', 'label' => 'Gallery', 'url' => 'gallery.php'],
    ['key' => 'awards', 'label' => 'Awards and Accolades', 'url' => 'awards-accreditations.php'],
];

function sum_nav_link_attrs(string $key, string $currentPage, bool $external = false): string
{
    $attrs = $currentPage === $key ? ' aria-current="page" class="sum-nav-active"' : '';
    if ($external) {
        $attrs .= ' target="_blank" rel="noopener"';
    }
    return $attrs;
}

function sum_nav_dept_icon(string $deptName): string
{
    $icons = [
        'Cardiac Sciences' => 'fa-heartbeat',
        'Nephrology' => 'fa-tint',
        'Diabetology/Endocrinology' => 'fa-syringe',
        'Oncology' => 'fa-ribbon',
        'And-rology' => 'fa-mars',
        'Clinical Haematology and BMT' => 'fa-vial',
        'Gastroenterology and GI Surgery' => 'fa-stethoscope',
        'Mental Health and Behavioural Sciences' => 'fa-brain',
        'Obstetrics & Gynaecology' => 'fa-baby',
        'Organ Transplant and Bariatric' => 'fa-procedures',
        'Urology' => 'fa-procedures',
        'Nuclear Medicine' => 'fa-radiation',
        'Critical Care' => 'fa-hospital',
        'Emergency and Trauma' => 'fa-ambulance',
        'General Surgery' => 'fa-cut',
        'Internal Medicine' => 'fa-user-md',
        'Paediatrics' => 'fa-child',
        'Physical Medicine & Rehabilitation' => 'fa-wheelchair',
        'Plastic & Cosmetic Surgery' => 'fa-magic',
        'Rheumatology' => 'fa-bone',
        'Vascular & Endovascular Surgery' => 'fa-heart',
        'Infertility Medicine' => 'fa-venus',
        'Dental Science' => 'fa-tooth',
        'Neurology' => 'fa-brain',
        'Ophthalmology' => 'fa-eye',
        'Pulmonology' => 'fa-lungs',
        'Ear Nose Throat & Head Neck Surgery' => 'fa-head-side-virus',
        'Orthopedics' => 'fa-bone',
        'Anaesthesiology' => 'fa-syringe',
        'Medical Gastroenterology' => 'fa-stethoscope',
        'Dermatology' => 'fa-allergies',
        'Neurosurgery' => 'fa-brain',
        'Radiology' => 'fa-x-ray',
        'Interventional Radiology' => 'fa-x-ray',
        'Surgical Oncology' => 'fa-ribbon',
        'Radiation Oncology' => 'fa-radiation',
        'Pathology' => 'fa-microscope',
        'Nutrition & Dietetics' => 'fa-apple-alt',
        'Physiotherapy' => 'fa-walking',
        'Psychiatry' => 'fa-comments',
        'Clinical Laboratory' => 'fa-flask',
        'Foetal Medicine' => 'fa-baby',
        'Infectious Diseases' => 'fa-virus',
        'Endocrine Surgery' => 'fa-cut',
        'Geriatric Medicine' => 'fa-user-friends',
        'ENT' => 'fa-head-side-virus',
        'Haematology' => 'fa-vial',
        'Medical Genetics' => 'fa-dna',
        'Gastroenterology' => 'fa-stethoscope',
        'Paediatrics' => 'fa-child',
        'Dermatology' => 'fa-allergies',
    ];
    return $icons[$deptName] ?? 'fa-hand-holding-medical';
}

function sum_dept_nav_local_name(string $navName): ?string
{
    $map = [
        'Cardiac Sciences' => 'Cardiology',
        'Diabetology/Endocrinology' => 'General Medicine',
        'Emergency and Trauma' => 'Emergency Medicine',
        'Internal Medicine' => 'General Medicine',
        'Gastroenterology and GI Surgery' => 'Gastroenterology',
        'Medical Gastroenterology' => 'Gastroenterology',
        'Pulmonology' => 'Pulmonology',
        'Infertility Medicine' => 'Obstetrics & Gynaecology',
        'Orthopedics' => 'Orthopedics',
        'Psychiatry' => 'General Medicine',
        'Mental Health and Behavioural Sciences' => 'Neurology',
        'Foetal Medicine' => 'General Medicine',
        'Infectious Diseases' => 'General Medicine',
        'Endocrine Surgery' => 'General Medicine',
        'Geriatric Medicine' => 'General Medicine',
        'ENT' => 'General Medicine',
        'Haematology' => 'Oncology',
        'Medical Genetics' => 'General Medicine',
        'Paediatrics' => 'General Medicine',
        'Dental Science' => 'General Medicine',
        'Dermatology' => 'General Medicine',
        'Neurosurgery' => 'Neurology',
    ];
    return $map[$navName] ?? $navName;
}

function sum_dept_nav_url(string $navName): string
{
    global $departments;

    $localName = sum_dept_nav_local_name($navName);
    $slug = sum_dept_slug($localName);
    if (isset($departments[$slug])) {
        return 'department-detail.php?dept=' . urlencode($slug);
    }

    $slug = sum_dept_slug($navName);
    if (isset($departments[$slug])) {
        return 'department-detail.php?dept=' . urlencode($slug);
    }

    return 'doctor.php?department=' . urlencode($localName);
}

function sum_render_dept_mega_item(array $item): void
{
    $name = $item['name'];
    $url = sum_dept_nav_url($name);
    $icon = sum_nav_dept_icon($name);
    $featured = !empty($item['featured']);
    $itemClass = 'sum-dept-mega-item' . ($featured ? ' sum-dept-mega-item--featured' : '');

    echo '<a class="' . $itemClass . '" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">';
    echo '<span class="sum-dept-mega-item__icon" aria-hidden="true"><i class="fas ' . htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') . '"></i></span>';
    echo '<span class="sum-dept-mega-item__label">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</span>';
    echo '<span class="sum-dept-mega-item__chevron" aria-hidden="true"><i class="fal fa-chevron-right"></i></span>';
    echo '</a>';
}

function sum_render_departments_nav_item(string $currentPage): void
{
    global $navMegaDepartments;

    $deptActive = $currentPage === 'departments' ? ' sum-nav-item--active' : '';
    echo '<li class="menu-item-has-children sum-dept-mega-parent' . $deptActive . '">';
    echo '<a href="department.php"' . sum_nav_link_attrs('departments', $currentPage) . '>Departments</a>';
    echo '<ul class="sub-menu sum-dept-dropdown sum-dept-mega-dropdown">';
    echo '<li class="sum-dept-mega-panel">';
    echo '<div class="sum-dept-mega-grid" role="list">';
    foreach ($navMegaDepartments as $column) {
        echo '<div class="sum-dept-mega-col" role="listitem">';
        foreach ($column as $item) {
            sum_render_dept_mega_item($item);
        }
        echo '</div>';
    }
    echo '</div>';
    echo '<a class="sum-dept-mega-all" href="department.php"' . sum_nav_link_attrs('departments', $currentPage) . '>View all departments <i class="fal fa-arrow-right" aria-hidden="true"></i></a>';
    echo '</li></ul></li>';
}

function sum_render_nav_primary(string $currentPage): void
{
    global $menuItems, $headerExtraNav;

    foreach ($menuItems as $item) {
        if ($item['key'] === 'departments') {
            sum_render_departments_nav_item($currentPage);
            continue;
        }

        echo '<li>';
        echo '<a href="' . htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') . '"' . sum_nav_link_attrs($item['key'], $currentPage) . '>';
        echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') . '</a></li>';
    }

    foreach ($headerExtraNav as $extra) {
        $extraKey = $extra['key'] ?? '';
        $external = !empty($extra['external']);
        echo '<li><a href="' . htmlspecialchars($extra['url'], ENT_QUOTES, 'UTF-8') . '"' . sum_nav_link_attrs($extraKey, $currentPage, $external) . '>';
        echo htmlspecialchars($extra['label'], ENT_QUOTES, 'UTF-8') . '</a></li>';
    }
}

function sum_render_nav_highlights(string $currentPage): void
{
    global $headerHighlightNav;

    foreach ($headerHighlightNav as $item) {
        $isActive = $currentPage === $item['key'];
        $activeClass = $isActive ? ' sum-nav-highlight--active' : '';
        $ariaCurrent = $isActive ? ' aria-current="page"' : '';
        $icon = $item['icon'] ?? 'fa-star';
        echo '<li class="sum-nav-highlight' . $activeClass . '">';
        echo '<a href="' . htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') . '" class="sum-nav-highlight__link"' . $ariaCurrent . '>';
        echo '<i class="fas ' . htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') . '" aria-hidden="true"></i>';
        echo '<span>' . htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') . '</span>';
        echo '</a></li>';
    }
}

function sum_render_primary_nav(string $currentPage): void
{
    echo '<li class="sum-mobile-nav-section-label" aria-hidden="true">Featured</li>';
    sum_render_nav_highlights($currentPage);
    echo '<li class="sum-mobile-nav-section-label" aria-hidden="true">Menu</li>';
    sum_render_nav_primary($currentPage);
}

$visionText = 'To be the most trusted multi-super specialty healthcare destination in Eastern India, setting benchmarks in clinical excellence, technology, and patient experience.';

$missionText = 'To provide next generation treatments and care in patient centric and technology enhanced settings to improve health outcomes. We are dedicated to delivering safe, accessible, effective and compassionate care with integrity and accountability in an ecosystem that integrates excellence in medical research and education.';

$aboutInstitutional = [
    'intro' => 'SUM Ultimate Medicare is a multi-super specialty quaternary care hospital in Bhubaneswar, Odisha, committed to medical excellence across the full spectrum of medical and surgical interventions.',
    'highlights' => [
        ['title' => 'NABH Accredited', 'text' => 'Quality and safety standards aligned with national accreditation benchmarks.'],
        ['title' => 'JCI Prime', 'text' => 'First hospital in Odisha to achieve JCI Prime certification.'],
        ['title' => 'Advanced Technology', 'text' => 'State-of-the-art diagnostics, cath lab, OT complexes, and critical care infrastructure.'],
        ['title' => 'Patient Centricity', 'text' => 'Transparent, compassionate care with coordinated follow-up services.'],
    ],
    'story' => 'With a robust presence across the healthcare ecosystem, SUM Ultimate Medicare integrates clinical education and research to deliver advanced care. The hospital addresses capacity, safety, quality, and wait-time challenges while fostering a culture of empathy, coordination, and competency.',
    'values' => [
        'Empathy & compassion in every patient interaction',
        'Clinical coordination across specialties',
        'Transparency in processes and communication',
        'Continuous learning and research-driven care',
    ],
];

$departmentRecords = sum_departments_load();
$departmentItems = sum_departments_active_names();

$navMegaDepartments = [
    [
        ['name' => 'Cardiac Sciences'],
        ['name' => 'Nephrology'],
        ['name' => 'Diabetology/Endocrinology'],
        ['name' => 'Foetal Medicine'],
        ['name' => 'Infectious Diseases'],
        ['name' => 'Oncology'],
    ],
    [
        ['name' => 'Nuclear Medicine', 'featured' => true],
        ['name' => 'Critical Care', 'featured' => true],
        ['name' => 'Emergency and Trauma'],
        ['name' => 'General Surgery'],
        ['name' => 'Internal Medicine'],
        ['name' => 'Paediatrics'],
    ],
    [
        ['name' => 'Infertility Medicine'],
        ['name' => 'Dental Science'],
        ['name' => 'Endocrine Surgery'],
        ['name' => 'Geriatric Medicine'],
        ['name' => 'Neurology'],
        ['name' => 'Ophthalmology'],
    ],
    [
        ['name' => 'Gastroenterology'],
        ['name' => 'Dermatology'],
        ['name' => 'ENT'],
        ['name' => 'Haematology'],
        ['name' => 'Medical Genetics'],
        ['name' => 'Neurosurgery'],
    ],
];

$facilityInfo = [
    'Cardiology' => [
        'text' => 'Comprehensive heart care from prevention to intervention with experienced cardiologists and cath-lab support.',
        'points' => ['24x7 cardiac emergency', 'ECG, Echo and stress test', 'Interventional cardiology', 'Post-procedure rehab'],
    ],
    'Neurology' => [
        'text' => 'Dedicated neuro sciences support for stroke, epilepsy, headache, and movement disorders with modern imaging.',
        'points' => ['Acute stroke response', 'EEG and neuro diagnostics', 'Seizure and migraine care', 'Neuro-rehabilitation path'],
    ],
    'Gastroenterology' => [
        'text' => 'Advanced diagnostics and treatment for digestive, liver, and GI conditions with patient-focused long-term care.',
        'points' => ['Therapeutic endoscopy', 'Liver and biliary care', 'IBD and reflux management', 'Nutrition-guided recovery'],
    ],
    'Emergency Medicine' => [
        'text' => 'Rapid triage, stabilization, and emergency response with 24x7 clinician support and critical care coordination.',
        'points' => ['24x7 emergency response', 'Trauma and resuscitation', 'Fast diagnostics', 'Ambulance coordination'],
    ],
];

$departments = [];
foreach ($departmentRecords as $record) {
    if (empty($record['active'])) {
        continue;
    }
    $deptName = $record['name'];
    $slug = $record['id'] ?: sum_dept_slug($deptName);
    $info = $facilityInfo[$deptName] ?? null;
    $defaultOverview = 'The ' . $deptName . ' department at SUM Ultimate Medicare provides comprehensive diagnosis, treatment, and follow-up care with experienced consultants and modern facilities.';
    $departments[$slug] = [
        'name' => $deptName,
        'slug' => $slug,
        'overview' => $record['overview'] !== '' ? $record['overview'] : ($info['text'] ?? $defaultOverview),
        'services' => $info['points'] ?? ['Consultation & diagnosis', 'Advanced procedures', 'In-patient & out-patient care', 'Recovery & rehabilitation'],
        'photos' => [
            'assets/img/service/ser9-2.jpg',
            'assets/img/blog/b-8-1.jpg',
            'assets/img/blog/b-8-2.jpg',
        ],
    ];
}

function sum_dept_icon(string $deptName): string
{
    $icons = [
        'Cardiology' => 'fa-heartbeat',
        'Neurology' => 'fa-brain',
        'Nephrology' => 'fa-tint',
        'Orthopedics' => 'fa-bone',
        'Pulmonology' => 'fa-lungs',
        'Gastroenterology' => 'fa-stethoscope',
        'Oncology' => 'fa-ribbon',
        'Urology' => 'fa-procedures',
        'General Medicine' => 'fa-user-md',
        'Critical Care' => 'fa-hospital',
        'Emergency Medicine' => 'fa-ambulance',
    ];
    return $icons[$deptName] ?? 'fa-hand-holding-medical';
}

function sum_excerpt(string $text, int $maxLen = 88): string
{
    $text = trim($text);
    if (strlen($text) <= $maxLen) {
        return $text;
    }
    return rtrim(substr($text, 0, $maxLen)) . '…';
}

function sum_doctors_in_department(string $deptName): int
{
    global $doctors;
    $count = 0;
    foreach ($doctors as $doc) {
        if (($doc['department'] ?? '') === $deptName) {
            $count++;
        }
    }
    return $count;
}

$doctors = sum_doctors_load();

$healthPartnerSegments = [
    'Insurance Partners' => [
        'icon' => 'fa-shield-alt',
        'description' => 'Cashless and reimbursement support through leading insurance providers.',
    ],
    'Corporate & TPA' => [
        'icon' => 'fa-building',
        'description' => 'Corporate wellness and third-party administrator tie-ups for seamless claims.',
    ],
    'Government & Schemes' => [
        'icon' => 'fa-landmark',
        'description' => 'Access to approved government health schemes and subsidised care pathways.',
    ],
];

$healthPartners = [
    'Insurance Partners' => [
        ['name' => 'Star Health', 'logo' => 'assets/img/brand/brand-6-1.png'],
        ['name' => 'Medi Assist', 'logo' => 'assets/img/brand/brand-6-2.png'],
        ['name' => 'HDFC ERGO', 'logo' => 'assets/img/brand/brand-6-3.png'],
        ['name' => 'ICICI Lombard', 'logo' => 'assets/img/brand/brand-6-4.png'],
    ],
    'Corporate & TPA' => [
        ['name' => 'Medibuddy', 'logo' => 'assets/img/brand/brand-6-5.png'],
        ['name' => 'FHPL', 'logo' => 'assets/img/brand/brand-6-2.png'],
        ['name' => 'Paramount', 'logo' => 'assets/img/brand/brand-6-3.png'],
    ],
    'Government & Schemes' => [
        ['name' => 'Ayushman Bharat', 'logo' => 'assets/img/brand/brand-6-1.png'],
        ['name' => 'Biju Swasthya Kalyan Yojana', 'logo' => 'assets/img/brand/brand-6-4.png'],
    ],
];

$healthPackages = [
    [
        'name' => 'Ultimate Wellness Check',
        'price' => '₹4,999',
        'description' => 'Comprehensive screening with lab panels, physician consultation, and lifestyle guidance.',
        'includes' => ['Full body check-up', 'Cardiac risk screening', 'Diabetes profile', 'Physician review'],
        'icon' => 'fa-notes-medical',
        'badge' => 'Most Popular',
        'featured' => true,
    ],
    [
        'name' => 'Executive Health Package',
        'price' => '₹8,499',
        'description' => 'Premium health assessment designed for working professionals and corporate teams.',
        'includes' => ['Advanced blood work', 'ECG & chest X-ray', 'Abdominal ultrasound', 'Specialist consultation'],
        'icon' => 'fa-briefcase-medical',
        'badge' => 'Corporate',
        'featured' => false,
    ],
    [
        'name' => 'Maternity Care Package',
        'price' => '₹24,999',
        'description' => 'Antenatal to postnatal support with obstetrician-led care and wellness monitoring.',
        'includes' => ['Routine antenatal visits', 'Ultrasound scans', 'Nutrition counselling', 'Delivery planning'],
        'icon' => 'fa-baby',
        'badge' => 'Complete Care',
        'featured' => false,
    ],
    [
        'name' => 'Cardiac Screening Package',
        'price' => '₹6,999',
        'description' => 'Focused cardiac evaluation with cardiologist consultation and diagnostic tests.',
        'includes' => ['ECG & Echo', 'Lipid profile', 'TMT (if indicated)', 'Cardiologist consult'],
        'icon' => 'fa-heartbeat',
        'badge' => 'Heart Health',
        'featured' => false,
    ],
    [
        'name' => 'Senior Citizen Package',
        'price' => '₹5,499',
        'description' => 'Age-appropriate screening with emphasis on bone health, cardiac, and metabolic wellness.',
        'includes' => ['Bone density screening', 'Vision & hearing check', 'Geriatric assessment', 'Medication review'],
        'icon' => 'fa-user-friends',
        'badge' => '55+ Years',
        'featured' => false,
    ],
    [
        'name' => 'Diabetes Care Package',
        'price' => '₹3,999',
        'description' => 'Structured monitoring for diabetes management and complication prevention.',
        'includes' => ['HbA1c & glucose panel', 'Kidney function tests', 'Foot & eye screening', 'Dietician session'],
        'icon' => 'fa-syringe',
        'badge' => 'Best Value',
        'featured' => false,
    ],
];

$galleryCategories = array_merge(['all' => 'All'], sum_gallery_category_options());
$galleryItems = sum_gallery_public_items();

$accreditationHighlights = [
    [
        'title' => 'NABH Accredited',
        'subtitle' => 'National Accreditation Board for Hospitals',
        'year' => '2023',
        'icon' => 'fa-award',
        'tone' => 'navy',
        'description' => 'Recognised for patient safety, clinical protocols, and quality management systems aligned with national healthcare standards.',
        'badge' => 'Quality Certified',
    ],
    [
        'title' => 'JCI Prime',
        'subtitle' => 'Joint Commission International',
        'year' => '2024',
        'icon' => 'fa-certificate',
        'tone' => 'teal',
        'description' => 'First hospital in Odisha to achieve JCI Prime certification — a milestone in international patient safety and care excellence.',
        'badge' => 'First in Odisha',
    ],
    [
        'title' => 'NABL Labs',
        'subtitle' => 'National Accreditation Board for Testing',
        'year' => '2023',
        'icon' => 'fa-flask',
        'tone' => 'green',
        'description' => 'Accredited laboratory services ensuring reliable diagnostics, traceability, and evidence-based clinical decision support.',
        'badge' => 'Diagnostics',
    ],
];

$awardsTimeline = [
    [
        'year' => '2024',
        'title' => 'JCI Prime Certification',
        'category' => 'International Accreditation',
        'description' => 'Achieved JCI Prime — setting a new benchmark for patient safety and quality in Eastern India.',
        'icon' => 'fa-globe',
    ],
    [
        'year' => '2023',
        'title' => 'NABH Accreditation within 365 Days',
        'category' => 'National Accreditation',
        'description' => 'Completed NABH accreditation in record time, reflecting robust processes and a culture of continuous quality improvement.',
        'icon' => 'fa-medal',
    ],
    [
        'year' => '2023',
        'title' => 'Excellence in Patient Experience',
        'category' => 'Hospital Award',
        'description' => 'Recognised for transparent communication, coordinated care pathways, and compassionate patient support services.',
        'icon' => 'fa-heart',
    ],
    [
        'year' => '2022',
        'title' => 'Advanced Cardiac Care Centre',
        'category' => 'Clinical Excellence',
        'description' => 'Acknowledged for interventional cardiology infrastructure, 24×7 cath-lab support, and cardiac emergency response.',
        'icon' => 'fa-heartbeat',
    ],
    [
        'year' => '2022',
        'title' => 'Digital Health Innovation',
        'category' => 'Technology',
        'description' => 'Honoured for technology-enhanced patient journeys — online appointments, digital records, and care coordination.',
        'icon' => 'fa-laptop-medical',
    ],
    [
        'year' => '2021',
        'title' => 'Community Health Leadership',
        'category' => 'CSR & Outreach',
        'description' => 'Awarded for preventive health camps, public awareness programmes, and outreach across Bhubaneswar and Odisha.',
        'icon' => 'fa-hands-helping',
    ],
];

$awardsStats = [
    ['value' => '2+', 'label' => 'Major accreditations'],
    ['value' => '6+', 'label' => 'Awards & recognitions'],
    ['value' => '365', 'label' => 'Days to NABH'],
    ['value' => '1st', 'label' => 'JCI Prime in Odisha'],
];

function sum_get_department(string $slug): ?array
{
    global $departments;
    return $departments[$slug] ?? null;
}

function sum_get_doctors(?string $department = null, bool $activeOnly = true): array
{
    $list = sum_doctors_load();
    if ($activeOnly) {
        $list = array_values(array_filter($list, static function ($doc) {
            return !empty($doc['active']);
        }));
    }
    if ($department === null || $department === '' || $department === 'All Departments') {
        return $list;
    }
    return array_values(array_filter($list, static function ($doc) use ($department) {
        return strcasecmp($doc['department'], $department) === 0;
    }));
}
