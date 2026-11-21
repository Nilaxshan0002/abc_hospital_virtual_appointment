<?php
// data/doctors.php

require_once __DIR__ . '/../config/constants-doctors.php';

$doctors = [
    [
        'id' => 1,
        'name' => 'Dr. Kamal Perera',
        'slug' => 'kamal-perera',
        'specialty' => 'Senior Cardiologist',
        'specialty_key' => 'cardiology',
        'qualifications' => 'MBBS, MD (Cardiology), FRCP',
        'experience' => 15,
        'patients' => 5000,
        'satisfaction' => 98,
        'image' => 'Dr. Kamal Perera.jpg',
        'bio' => 'Dr. Kamal Perera is a leading cardiologist with over 15 years of experience.',
        'languages' => ['English', 'Sinhala', 'Tamil']
    ],
    [
        'id' => 2,
        'name' => 'Dr. Priyani Silva',
        'slug' => 'priyani-silva',
        'specialty' => 'Consultant Neurologist',
        'specialty_key' => 'neurology',
        'qualifications' => 'MBBS, MD (Neurology), DM',
        'experience' => 12,
        'patients' => 3500,
        'satisfaction' => 97,
        'image' => 'Dr. Priyani Silva.jpg',
        'bio' => 'Dr. Priyani Silva specializes in treating complex neurological disorders.',
        'languages' => ['English', 'Sinhala']
    ],
    [
        'id' => 3,
        'name' => 'Dr. Nuwan Fernando',      // Display name (with 'u')
        'slug' => 'nuwan-fernando',
        'specialty' => 'Orthopedic Surgeon',
        'specialty_key' => 'orthopedics',
        'qualifications' => 'MBBS, MS (Ortho), MCh',
        'experience' => 10,
        'patients' => 3000,
        'satisfaction' => 96,
        'image' => 'Dr. Nuvan Fernando.jpg',  // Filename (without 'u') - MATCHES YOUR FOLDER
        'bio' => 'Dr. Nuwan Fernando is an expert in joint replacement and sports medicine.',
        'languages' => ['English', 'Sinhala']
    ],
    [
        'id' => 4,
        'name' => 'Dr. Malini Dissanayake',
        'slug' => 'malini-dissanayake',
        'specialty' => 'Senior Pediatrician',
        'specialty_key' => 'pediatrics',
        'qualifications' => 'MBBS, MD (Pediatrics), DCH',
        'experience' => 18,
        'patients' => 6000,
        'satisfaction' => 99,
        'image' => 'Dr. Malini Dissanayake.jpg',
        'bio' => 'Dr. Malini Dissanayake has dedicated her career to children\'s health.',
        'languages' => ['English', 'Sinhala', 'Tamil']
    ],
    [
        'id' => 5,
        'name' => 'Dr. Sanjay Rathnayake',
        'slug' => 'sanjay-rathnayake',
        'specialty' => 'Consultant Dermatologist',
        'specialty_key' => 'dermatology',
        'qualifications' => 'MBBS, MD (Dermatology), DVD',
        'experience' => 8,
        'patients' => 2500,
        'satisfaction' => 95,
        'image' => 'Dr. Sanjay Rathnayake.jpg',
        'bio' => 'Dr. Sanjay Rathnayake offers advanced treatments for all skin conditions.',
        'languages' => ['English', 'Sinhala']
    ],
    [
        'id' => 6,
        'name' => 'Dr. Thusitha Jayawardena',
        'slug' => 'thusitha-jayawardena',
        'specialty' => 'General Physician',
        'specialty_key' => 'general',
        'qualifications' => 'MBBS, MD (Internal Medicine)',
        'experience' => 20,
        'patients' => 8000,
        'satisfaction' => 98,
        'image' => 'Dr. Thusitha Jayawardena.jpg',
        'bio' => 'Dr. Thusitha Jayawardena provides comprehensive primary care.',
        'languages' => ['English', 'Sinhala']
    ]
];

$totalDoctors = count($doctors);
?>