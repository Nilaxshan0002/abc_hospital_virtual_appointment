-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.12.0.7122
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for abc_virtual_hospital
CREATE DATABASE IF NOT EXISTS `abc_virtual_hospital` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `abc_virtual_hospital`;

-- Dumping structure for table abc_virtual_hospital.patients
CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `patient_code` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `emergency_contact` varchar(15) DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`patient_id`),
  UNIQUE KEY `patient_code` (`patient_code`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `idx_blood_group` (`blood_group`),
  CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Book appointments, view your schedule, and manage your health records.';

-- Dumping data for table abc_virtual_hospital.patients: ~5 rows (approximately)
INSERT INTO `patients` (`patient_id`, `user_id`, `patient_code`, `date_of_birth`, `gender`, `blood_group`, `address`, `phone`, `emergency_contact`, `medical_history`, `allergies`, `created_at`) VALUES
	(1, 9, 'P001', '1990-05-15', 'male', 'O+', '123 Main St, Colombo 03', '0771112233', '0771112244', 'None', 'None', '2026-03-08 03:26:38'),
	(2, 10, 'P002', '1985-08-22', 'female', 'A+', '456 Park Ave, Kandy', '0772223344', '0772223355', 'Asthma', 'Pollen', '2026-03-08 03:26:38'),
	(3, 11, 'P003', '1978-03-10', 'male', 'B+', '789 Lake Rd, Galle', '0773334455', '0773334466', 'Hypertension', 'None', '2026-03-08 03:26:38'),
	(4, 12, 'P004', '1995-11-30', 'male', 'AB-', '321 Beach Rd, Negombo', '0774445566', '0774445577', 'None', 'Shellfish', '2026-03-08 03:26:38'),
	(5, 13, 'P005', '1988-07-18', 'female', 'O-', '654 Hill St, Nuwara Eliya', '0775556677', '0775556688', 'None', 'None', '2026-03-08 03:26:38');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
