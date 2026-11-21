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

-- Dumping structure for table abc_virtual_hospital.appointments
CREATE TABLE IF NOT EXISTS `appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_code` varchar(20) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed','no_show') DEFAULT 'pending',
  `payment_status` enum('pending','paid','refunded') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`appointment_id`),
  UNIQUE KEY `appointment_code` (`appointment_code`),
  KEY `idx_date` (`appointment_date`),
  KEY `idx_status` (`status`),
  KEY `idx_patient` (`patient_id`),
  KEY `idx_doctor` (`doctor_id`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=849 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Schedule your visit with our expert doctors. Choose your preferred doctor, date, and time.';

-- Dumping data for table abc_virtual_hospital.appointments: ~3 rows (approximately)
INSERT INTO `appointments` (`appointment_id`, `appointment_code`, `patient_id`, `doctor_id`, `doctor_name`, `appointment_date`, `appointment_time`, `reason`, `notes`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
	(1, 'APT-9821', 4, 1, 'Dr. K. L. Perera', '2026-06-10', '216:00:00', 'Chronic hypertension', 'First-time consultation for this specialist.', 'confirmed', 'paid', '2026-06-03 18:08:44', '2026-06-03 18:08:44'),
	(2, 'APT-3402', 5, 2, 'Dr. Ananya Sharma', '2026-06-11', '339:00:00', 'Seasonal allergies', 'Patient requests a digital prescription copy.', 'pending', 'refunded', '2026-06-03 18:09:15', '2026-06-03 18:10:08'),
	(3, 'APT-7110', 4, 3, 'Dr. Michael Chang', '2026-06-08', '385:05:00', 'Eczema flare-up', 'Canceled due to doctor scheduling conflict.', 'cancelled', 'refunded', '2026-06-03 18:11:30', '2026-06-03 18:11:30');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
