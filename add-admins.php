<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$admins = [
    ['Kamal', 'Kamal@123', 'kamal@abchospital.lk', 'Kamal Admin'],
    ['Vimal', 'Vimal@123', 'vimal@abchospital.lk', 'Vimal Admin'],
    ['Nimal', 'Nimal@123', 'nimal@abchospital.lk', 'Nimal Admin'],
    ['admin', 'admin@123', 'admin@abchospital.lk', 'System Admin']
];

foreach ($admins as $admin) {
    $hash = password_hash($admin[1], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name, user_role, status) VALUES (?, ?, ?, ?, 'admin', 'active')");
    $stmt->execute([$admin[0], $hash, $admin[2], $admin[3]]);
    echo "Added: " . $admin[0] . " with password: " . $admin[1] . "<br>";
}
?>