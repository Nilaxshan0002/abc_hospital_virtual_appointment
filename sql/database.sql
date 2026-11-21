-- Create database
CREATE DATABASE IF NOT EXISTS abc_hospital;
USE abc_hospital;

-- Doctors table
CREATE TABLE IF NOT EXISTS doctors (
    id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) DEFAULT 'password123',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Patients table
CREATE TABLE IF NOT EXISTS patients (
    id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Receptionists table
CREATE TABLE IF NOT EXISTS receptionists (
    id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) DEFAULT 'password123',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id VARCHAR(10) PRIMARY KEY,
    patient_id VARCHAR(10) NOT NULL,
    doctor_id VARCHAR(10) NOT NULL,
    doctor_name VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    INDEX idx_date (appointment_date),
    INDEX idx_status (status)
);

-- Insert sample data
INSERT INTO doctors (id, name, specialty, email, phone) VALUES
('D001', 'Dr. Kamal Perera', 'Cardiologist', 'kamal.perera@abchospital.lk', '+94 77 123 4567'),
('D002', 'Dr. Nimali Fernando', 'Pediatrician', 'nimali.fernando@abchospital.lk', '+94 77 234 5678'),
('D003', 'Dr. Sunil Wijesinghe', 'Neurologist', 'sunil.wijesinghe@abchospital.lk', '+94 77 345 6789'),
('D004', 'Dr. Priyani Jayawardena', 'Dermatologist', 'priyani.jayawardena@abchospital.lk', '+94 77 456 7890'),
('D005', 'Dr. Ruwan Silva', 'Orthopedic Surgeon', 'ruwan.silva@abchospital.lk', '+94 77 567 8901');

INSERT INTO patients (id, name, email, phone, password) VALUES
('P001', 'Saman Kumara', 'saman.k@email.com', '+94 77 111 2233', 'password123'),
('P002', 'Malini Fonseka', 'malini.f@email.com', '+94 77 222 3344', 'password123'),
('P003', 'Vijay Kumaratunga', 'vijay.k@email.com', '+94 77 333 4455', 'password123');

INSERT INTO receptionists (id, name, email, phone) VALUES
('R001', 'Chamari Athapaththu', 'chamari.a@abchospital.lk', '+94 71 123 4567'),
('R002', 'Nuwan Pradeep', 'nuwan.p@abchospital.lk', '+94 71 234 5678');

INSERT INTO appointments (id, patient_id, doctor_id, doctor_name, appointment_date, appointment_time, reason, status) VALUES
('A001', 'P001', 'D001', 'Dr. Kamal Perera', '2024-03-25', '09:00', 'Chest pain and shortness of breath', 'confirmed'),
('A002', 'P002', 'D002', 'Dr. Nimali Fernando', '2024-03-25', '10:30', 'Child vaccination', 'confirmed'),
('A003', 'P003', 'D003', 'Dr. Sunil Wijesinghe', '2024-03-26', '14:00', 'Severe headache', 'pending');