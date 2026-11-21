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

-- Dumping structure for table abc_virtual_hospital.appointment_details
CREATE TABLE IF NOT EXISTS `appointment_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_name` varchar(100) NOT NULL,
  `doctor_specialty` varchar(100) DEFAULT NULL,
  `patient_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `appointment_date` date NOT NULL,
  `consultation_type` varchar(50) NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `reason_for_visit` text DEFAULT NULL,
  `status` enum('Physical Visit','Video Consultaton','Phone Consultaton') DEFAULT 'Physical Visit',
  `booking_reference` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Schedule your visit with our expert doctors. Choose your preferred doctor, date, and time.';

-- Dumping data for table abc_virtual_hospital.appointment_details: ~3 rows (approximately)
INSERT INTO `appointment_details` (`id`, `doctor_name`, `doctor_specialty`, `patient_name`, `phone_number`, `email_address`, `appointment_date`, `consultation_type`, `time_slot`, `reason_for_visit`, `status`, `booking_reference`, `created_at`, `updated_at`) VALUES
	(1, 'Dr. K. L. Perera', 'Cardiologist', 'Kasun Jayawardena', '+94717778888', 'kasun.j@mail.com', '2026-06-03', 'Video Consultation', '09:00 - 09:30', 'Chest tightness and routine pressure follow-up.', 'Physical Visit', 'ABC-2026-0001', '2026-06-03 17:57:38', '2026-06-03 17:57:38'),
	(2, 'Dr. Ananya Sharma', 'Pediatrician', 'Minoli Perera', '+94772223333', 'minoli.p@outlook.com', '2026-06-11', 'Physical Visit', '14:30 - 15:00', 'Infant vaccination booster schedule.', 'Phone Consultaton', 'ABC-2026-0002', '2026-06-03 18:00:12', '2026-06-03 18:00:34'),
	(3, 'Dr. Michael Chang', 'Dermatologist', 'Liam Davies', '+15554443322', 'liam.d@gmail.com', '2026-06-08', 'Video Consultation', '16:15 - 16:45', 'Persistent skin rash evaluation.', 'Phone Consultaton', 'Cancelled', '2026-06-03 18:02:11', '2026-06-03 18:02:11');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
