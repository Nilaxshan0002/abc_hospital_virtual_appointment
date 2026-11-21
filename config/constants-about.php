<?php
// config/constants-about.php
session_start();
$pageTitle = "About ABC Virtual - Healthcare Management System";
$base_url = '/abc_hospital_virtual_appointment';
$companyInfo = [
    'name' => 'ABC Hospital',
    'established' => '1959',
    'years' => '64+',
    'mission' => 'To provide accessible, high-quality healthcare through innovative digital solutions while maintaining the highest standards of patient care and compassion.',
    'vision' => 'To be Sri Lanka\'s most trusted and technologically advanced healthcare provider, setting benchmarks in virtual healthcare delivery.',
    'patients_served' => '50000+',
    'doctors_count' => '150+',
    'departments_count' => '30+',
    'locations' => '5+'
];

$milestones = [
    ['year' => '1959', 'title' => 'Foundation', 'description' => 'ABC Hospital established as a small clinic in Colombo'],
    ['year' => '1985', 'title' => 'Expansion', 'description' => 'Expanded to multi-speciality hospital with 200 beds'],
    ['year' => '2000', 'title' => 'Digital Transformation', 'description' => 'First private hospital in Sri Lanka with fully digital records'],
    ['year' => '2015', 'title' => 'JCI Accreditation', 'description' => 'Achieved international gold standard in healthcare'],
    ['year' => '2020', 'title' => 'Virtual Healthcare', 'description' => 'Launched ABC Virtual for online consultations'],
    ['year' => '2024', 'title' => 'AI Integration', 'description' => 'Implemented AI-powered diagnostic support systems']
];

$leadership = [
    [
        'name' => 'Dr. Kamal Perera',
        'position' => 'Chairman & Senior Consultant Cardiologist',
        'image' => 'dr-kamal-perera.jpg',
        'bio' => 'With over 35 years of experience, Dr. Perera has been instrumental in shaping modern healthcare in Sri Lanka.'
    ],
    [
        'name' => 'Mrs. Priyani Silva',
        'position' => 'Chief Executive Officer',
        'image' => 'priyani-silva.jpg',
        'bio' => 'Leading healthcare administration with 20+ years of experience in hospital management.'
    ],
    [
        'name' => 'Prof. Nimal Fernando',
        'position' => 'Medical Director',
        'image' => 'nimal-fernando.jpg',
        'bio' => 'Rennowned neurologist and academic, pioneering research in neurological disorders.'
    ]
];

$awards = [
    ['icon' => 'trophy', 'title' => 'Best Private Hospital', 'year' => '2023', 'organization' => 'Sri Lanka Healthcare Awards'],
    ['icon' => 'award', 'title' => 'Digital Innovation Award', 'year' => '2022', 'organization' => 'Asia Pacific Healthcare Congress'],
    ['icon' => 'medal', 'title' => 'Patient Safety Award', 'year' => '2021', 'organization' => 'WHO Regional Office'],
    ['icon' => 'certificate', 'title' => 'JCI Accreditation', 'year' => '2015-2024', 'organization' => 'Joint Commission International']
];
?>