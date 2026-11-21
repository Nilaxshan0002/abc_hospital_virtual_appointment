<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/abc_hospital_virtual_appointment';
$pageTitle = "ABC Virtual Healthcare | Right to Portability";
$metaDescription = "Request your personal data in a portable format at ABC Hospital";
$metaKeywords = "data portability, export data, download medical records";
$pageCSS = "rights-pages";
$pageJS = "rights-pages";

// Handle download request - THIS IS THE KEY PART
if (isset($_GET['action']) && $_GET['action'] === 'download') {
    $format = isset($_GET['format']) ? $_GET['format'] : 'json';
    $fullname = isset($_GET['fullname']) ? $_GET['fullname'] : 'Patient';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $phone = isset($_GET['phone']) ? $_GET['phone'] : '';
    $nic = isset($_GET['nic']) ? $_GET['nic'] : '';
    $dob = isset($_GET['dob']) ? $_GET['dob'] : '1985-05-15';
    $address = isset($_GET['address']) ? $_GET['address'] : '';
    $patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
    $data_scope = isset($_GET['data_scope']) ? $_GET['data_scope'] : 'all';
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
    $include_notes = isset($_GET['include_notes']) ? true : false;
    
    // Generate data
    $data = generateSampleData($fullname, $email, $phone, $nic, $dob, $address, $patient_id, $data_scope, $date_from, $date_to, $include_notes);
    
    // Set headers for download
    switch($format) {
        case 'json':
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="medical_data_' . preg_replace('/[^a-zA-Z0-9]/', '_', $fullname) . '_' . date('Ymd_His') . '.json"');
            header('Pragma: no-cache');
            header('Expires: 0');
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;
            
        case 'csv':
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="medical_data_' . preg_replace('/[^a-zA-Z0-9]/', '_', $fullname) . '_' . date('Ymd_His') . '.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            $output = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Hospital Header
            fputcsv($output, ['ABC VIRTUAL HEALTHCARE - MEDICAL DATA EXPORT']);
            fputcsv($output, ['Export Date:', $data['data_export_date']]);
            fputcsv($output, ['Patient:', $data['requested_by']]);
            fputcsv($output, []);
            
            // Personal Information
            if (isset($data['personal_information'])) {
                fputcsv($output, ['PERSONAL INFORMATION']);
                foreach ($data['personal_information'] as $key => $value) {
                    fputcsv($output, [ucwords(str_replace('_', ' ', $key)), $value]);
                }
                fputcsv($output, []);
            }
            
            // Medical Records
            if (isset($data['medical_records'])) {
                fputcsv($output, ['MEDICAL RECORDS']);
                $headers = array_keys($data['medical_records'][0]);
                fputcsv($output, array_map('ucwords', str_replace('_', ' ', $headers)));
                foreach ($data['medical_records'] as $record) {
                    fputcsv($output, $record);
                }
                fputcsv($output, []);
            }
            
            fclose($output);
            break;
            
        case 'pdf':
            header('Content-Type: text/html; charset=utf-8');
            header('Content-Disposition: attachment; filename="medical_data_' . preg_replace('/[^a-zA-Z0-9]/', '_', $fullname) . '_' . date('Ymd_His') . '.html"');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            echo generatePDFHTML($data, $fullname, $base_url);
            break;
    }
    exit;
}

function generateSampleData($fullname, $email, $phone, $nic, $dob, $address, $patient_id, $scope, $date_from, $date_to, $include_notes) {
    $timestamp = date('Y-m-d H:i:s');
    
    // Use provided values or defaults
    $dob = !empty($dob) ? $dob : '1985-05-15';
    $phone = !empty($phone) ? $phone : '+94 77 123 4567';
    $address = !empty($address) ? $address : '123 Main Street, Colombo 05, Sri Lanka';
    $nic = !empty($nic) ? $nic : '853151234V';
    $patient_id = !empty($patient_id) ? $patient_id : 'PAT-' . rand(10000, 99999);
    
    // Calculate age from DOB
    $birthDate = new DateTime($dob);
    $today = new DateTime('today');
    $age = $birthDate->diff($today)->y;
    
    // Base personal information
    $personal_info = [
        'full_name' => $fullname,
        'email' => $email,
        'phone' => $phone,
        'nic_passport' => $nic,
        'date_of_birth' => $dob,
        'age' => $age . ' years',
        'patient_id' => $patient_id,
        'address' => $address,
        'blood_group' => 'O+',
        'emergency_contact' => '+94 71 987 6543'
    ];
    
    // Medical records
    $medical_records = [
        [
            'date' => '2026-02-15',
            'doctor' => 'Dr. Kamal Perera',
            'department' => 'Cardiology',
            'diagnosis' => 'Hypertension follow-up',
            'prescription' => 'Amlodipine 5mg daily',
            'notes' => $include_notes ? 'Blood pressure stable at 120/80' : ''
        ],
        [
            'date' => '2026-01-10',
            'doctor' => 'Dr. Nimali Silva',
            'department' => 'General Medicine',
            'diagnosis' => 'Seasonal allergies',
            'prescription' => 'Cetirizine 10mg',
            'notes' => $include_notes ? 'Allergic to dust and pollen' : ''
        ]
    ];
    
    // Build data based on scope
    $data = [
        'hospital' => 'ABC Virtual Healthcare',
        'data_export_date' => $timestamp,
        'requested_by' => $fullname,
        'data_scope' => $scope
    ];
    
    if ($scope === 'all' || $scope === 'personal') {
        $data['personal_information'] = $personal_info;
    }
    
    if ($scope === 'all' || $scope === 'medical') {
        $data['medical_records'] = $medical_records;
    }
    
    return $data;
}

// FIXED FUNCTION - NO EXTRA TEXT SHOWING
function generatePDFHTML($data, $patientName, $base_url) {
    // Get the full URL for the logo
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $logo_full_url = $protocol . $host . $base_url . '/images/ABC logo.webp';
    
    // Create a data URI fallback (ABC letter logo in case image doesn't load)
    $svg_fallback = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120"><rect width="120" height="120" rx="24" fill="%234f46e5"/><text x="60" y="80" font-family="Arial" font-size="48" font-weight="bold" text-anchor="middle" fill="white">ABC</text></svg>';
    
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <title>Medical Records Export - ' . $patientName . '</title>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                margin: 40px; 
                color: #333;
                line-height: 1.6;
            }
            .header { 
                text-align: center;
                margin-bottom: 40px; 
                padding-bottom: 30px;
                border-bottom: 3px solid #4f46e5;
            }
            .logo-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
            }
            .hospital-logo {
                width: 120px;
                height: 120px;
                margin-bottom: 20px;
                border-radius: 20px;
                box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
                object-fit: cover;
            }
            .hospital-name {
                font-size: 32px;
                font-weight: bold;
                color: #4f46e5;
                margin-bottom: 5px;
            }
            .hospital-tagline {
                color: #64748b;
                font-size: 16px;
                margin-bottom: 5px;
            }
            .hospital-address {
                color: #94a3b8;
                font-size: 14px;
                margin-bottom: 10px;
            }
            h1 { 
                color: #1e293b; 
                margin: 20px 0 10px;
                font-size: 26px;
                text-align: center;
            }
            .export-info {
                text-align: center;
                color: #64748b;
                font-size: 14px;
                margin-bottom: 30px;
                padding: 10px;
                background: #f8fafc;
                border-radius: 50px;
                display: inline-block;
                padding: 8px 25px;
            }
            h2 { 
                color: #1e293b; 
                margin-top: 40px;
                margin-bottom: 20px;
                padding-left: 15px;
                border-left: 5px solid #4f46e5;
                font-size: 22px;
            }
            table { 
                width: 100%; 
                border-collapse: collapse; 
                margin: 25px 0; 
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                border-radius: 12px;
                overflow: hidden;
            }
            th { 
                background: #4f46e5; 
                color: white; 
                padding: 15px; 
                text-align: left; 
                font-weight: 600;
                font-size: 15px;
            }
            td { 
                border: 1px solid #e2e8f0; 
                padding: 12px 15px; 
            }
            tr:nth-child(even) {
                background: #f8fafc;
            }
            .info-section {
                background: #f8fafc;
                padding: 25px;
                border-radius: 15px;
                margin: 25px 0;
                border: 1px solid #e2e8f0;
            }
            .info-section p {
                margin: 10px 0;
                font-size: 15px;
            }
            .info-section strong {
                color: #1e293b;
                width: 180px;
                display: inline-block;
            }
            .footer { 
                margin-top: 60px; 
                text-align: center; 
                color: #94a3b8; 
                font-size: 12px;
                padding-top: 25px;
                border-top: 2px solid #e2e8f0;
            }
            .watermark {
                position: fixed;
                bottom: 30px;
                right: 30px;
                opacity: 0.05;
                font-size: 80px;
                transform: rotate(-15deg);
                pointer-events: none;
                color: #4f46e5;
                font-weight: bold;
            }
            .export-id {
                font-family: monospace;
                background: #e2e8f0;
                padding: 3px 8px;
                border-radius: 5px;
                color: #4f46e5;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo-container">
                <img src="' . $logo_full_url . '" 
                     alt="ABC Hospital Logo" 
                     class="hospital-logo"
                     onerror="this.onerror=null; this.src=\'' . $svg_fallback . '\'">
            </div>
            <div class="hospital-name">ABC Virtual Healthcare</div>
            <div class="hospital-tagline">Your Trusted Healthcare Partner Since 1959</div>
            <div class="hospital-address">123 Hospital Road, Colombo 05, Sri Lanka</div>
        </div>
        
        <div style="text-align: center;">
            <h1>Medical Records Export</h1>
            <div class="export-info">
                <strong>Export Date:</strong> ' . $data['data_export_date'] . ' | 
                <strong>Export ID:</strong> <span class="export-id">MED-' . date('Ymd') . '-' . rand(1000, 9999) . '</span><br>
                <strong>Patient:</strong> ' . $patientName . '
            </div>
        </div>';
    
    // Personal Information Section
    if (isset($data['personal_information'])) {
        $html .= '<h2>Personal Information</h2>';
        $html .= '<div class="info-section">';
        foreach ($data['personal_information'] as $key => $value) {
            if (!empty($value)) {
                $html .= '<p><strong>' . ucwords(str_replace('_', ' ', $key)) . ':</strong> ' . $value . '</p>';
            }
        }
        $html .= '</div>';
    }
    
    // Medical Records Section
    if (isset($data['medical_records'])) {
        $html .= '<h2>Medical Records</h2>';
        $html .= '<table>';
        $html .= '<tr>';
        $headers = array_keys($data['medical_records'][0]);
        foreach ($headers as $header) {
            if ($header !== 'notes' || !empty($data['medical_records'][0]['notes'])) {
                $html .= '<th>' . ucwords(str_replace('_', ' ', $header)) . '</th>';
            }
        }
        $html .= '</tr>';
        
        foreach ($data['medical_records'] as $record) {
            $html .= '<tr>';
            foreach ($record as $key => $value) {
                if ($key !== 'notes' || !empty($value)) {
                    $html .= '<td>' . $value . '</td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
    }
    
    // Data Scope Information
    $html .= '<div style="margin: 30px 0; padding: 15px; background: #f1f5f9; border-radius: 10px; text-align: center;">
        <p style="color: #475569;"><strong>Data Scope:</strong> ' . ucwords(str_replace('_', ' ', $data['data_scope'])) . '</p>
        <p style="color: #475569; font-size: 13px;">This document contains confidential medical information. Handle with care.</p>
    </div>';
    
    $html .= '<div class="footer">
        <p>This document is generated under the Sri Lanka Personal Data Protection Act No. 9 of 2022</p>
        <p>© ' . date('Y') . ' ABC Virtual Healthcare. All rights reserved.</p>
        <p style="margin-top: 10px;">📞 +94 11 234 5678 | 📧 dpo@abchospital.lk | 🌐 www.abchospital.lk</p>
        <p style="margin-top: 15px; font-size: 11px; color: #94a3b8;">Export ID: MED-' . date('Ymd') . '-' . rand(1000, 9999) . ' | Generated for: ' . $patientName . '</p>
    </div>
    
    <div class="watermark">ABC HOSPITAL</div>
    
    </body>
    </html>';
    
    return $html;
}

include_once 'includes/header02.php';
?>

<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php echo $base_url; ?>/index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="<?php echo $base_url; ?>/privacy-policy.php">Privacy Policy</a>
            <i class="fas fa-chevron-right"></i>
            <span>Right to Portability</span>
        </div>
        
        <h1>
            <i class="fas fa-download"></i> 
            Right to Portability
        </h1>
        
        <p class="header-tagline">
            Download your medical data instantly
        </p>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="content-card">
        <div class="rights-content">
            <h2><i class="fas fa-info-circle"></i> Download Your Data</h2>
            <p>Fill in your details and click download. Your file will start downloading immediately with your medical records.</p>

            <div class="format-grid">
                <div class="format-card" onclick="selectFormat('json')" id="card-json">
                    <i class="fas fa-file-code"></i>
                    <h4>JSON</h4>
                    <p>For developers</p>
                </div>
                <div class="format-card" onclick="selectFormat('csv')" id="card-csv">
                    <i class="fas fa-file-csv"></i>
                    <h4>CSV</h4>
                    <p>For Excel</p>
                </div>
                <div class="format-card" onclick="selectFormat('pdf')" id="card-pdf">
                    <i class="fas fa-file-pdf"></i>
                    <h4>HTML</h4>
                    <p>Printable format with Logo</p>
                </div>
            </div>

            <div class="request-form">
                <h3><i class="fas fa-edit"></i> Your Information</h3>
                
                <form id="downloadForm" onsubmit="return false;">
                    <!-- Personal Information -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" id="fullname" value="John Doe" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" id="dob" value="1985-05-15">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" id="email" value="john@example.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" id="phone" value="+94 77 123 4567">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>NIC/Passport *</label>
                            <input type="text" id="nic" value="853151234V" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Patient ID</label>
                            <input type="text" id="patient_id" value="PAT-12345">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Address</label>
                        <textarea id="address" rows="2">123 Main Street, Colombo 05</textarea>
                    </div>
                    
                    <!-- Data Selection -->
                    <h4 style="margin: 20px 0 10px; color: #4f46e5;">Data Options</h4>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date From</label>
                            <input type="date" id="date_from" value="2025-01-01">
                        </div>
                        
                        <div class="form-group">
                            <label>Date To</label>
                            <input type="date" id="date_to" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Data to Include</label>
                        <select id="data_scope">
                            <option value="all">Complete Medical Records</option>
                            <option value="personal">Personal Information Only</option>
                            <option value="medical">Medical History Only</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Format *</label>
                        <select id="format">
                            <option value="json">JSON Format</option>
                            <option value="csv">CSV Format (Excel)</option>
                            <option value="pdf">HTML Format with Logo (Printable)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="include_notes" checked>
                            <span>Include doctor's notes</span>
                        </label>
                    </div>
                    
                    <!-- Consent -->
                    <div class="consent-box">
                        <label class="checkbox-label">
                            <input type="checkbox" id="confirm" checked>
                            <span>I confirm this is my own data</span>
                        </label>
                    </div>
                    
                    <!-- Download Button -->
                    <div class="form-actions">
                        <button type="button" class="btn-primary" id="downloadBtn" onclick="downloadData()">
                            <i class="fas fa-download"></i> Download Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.format-card {
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s;
    text-align: center;
    padding: 20px;
}

.format-card.selected {
    border-color: #4f46e5;
    background: #f0f3ff;
    transform: scale(1.05);
}

#downloadBtn {
    width: 100%;
    padding: 15px;
    font-size: 1.2rem;
    background: #4f46e5;
    color: white;
    border: none;
    border-radius: 50px;
    cursor: pointer;
}

#downloadBtn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
let selectedFormat = 'json';

function selectFormat(format) {
    selectedFormat = format;
    document.querySelectorAll('.format-card').forEach(c => c.classList.remove('selected'));
    document.getElementById('card-' + format).classList.add('selected');
    document.getElementById('format').value = format;
}

function downloadData() {
    // Check consent
    if (!document.getElementById('confirm').checked) {
        alert('Please confirm that this is your own data');
        return;
    }
    
    // Get form values
    const fullname = document.getElementById('fullname').value.trim();
    if (!fullname) {
        alert('Please enter your full name');
        return;
    }
    
    // Show loading
    const btn = document.getElementById('downloadBtn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing download...';
    btn.disabled = true;
    
    // Build URL with parameters
    const params = new URLSearchParams({
        action: 'download',
        format: selectedFormat,
        fullname: fullname,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        nic: document.getElementById('nic').value,
        dob: document.getElementById('dob').value,
        address: document.getElementById('address').value,
        patient_id: document.getElementById('patient_id').value,
        data_scope: document.getElementById('data_scope').value,
        date_from: document.getElementById('date_from').value,
        date_to: document.getElementById('date_to').value,
        include_notes: document.getElementById('include_notes').checked ? '1' : '0'
    });
    
    // Trigger download by redirecting to download URL
    window.location.href = '?' + params.toString();
    
    // Reset button after 3 seconds
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 3000);
}

// Set default format on load
window.addEventListener('load', function() {
    selectFormat('json');
    
    // Set default dates if empty
    if (!document.getElementById('date_to').value) {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date_to').value = today;
    }
});
</script>

<?php include_once 'includes/footer02.php'; ?>