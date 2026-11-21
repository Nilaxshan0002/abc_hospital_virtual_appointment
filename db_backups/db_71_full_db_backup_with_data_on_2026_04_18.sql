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

-- Dumping structure for table abc_virtual_hospital.doctors
CREATE TABLE IF NOT EXISTS `doctors` (
  `doctor_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `doctor_code` varchar(20) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `qualification` text DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT NULL,
  `available_days` text DEFAULT NULL,
  `available_time` varchar(50) DEFAULT NULL,
  `max_appointments_per_day` int(11) DEFAULT 10,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`doctor_id`),
  UNIQUE KEY `doctor_code` (`doctor_code`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `idx_specialization` (`specialization`),
  CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Meet our team of 6 highly qualified medical professionals dedicated to your health.';

-- Dumping data for table abc_virtual_hospital.doctors: ~5 rows (approximately)
INSERT INTO `doctors` (`doctor_id`, `user_id`, `doctor_code`, `specialization`, `qualification`, `experience_years`, `consultation_fee`, `available_days`, `available_time`, `max_appointments_per_day`, `bio`, `created_at`) VALUES
	(1, 4, 'D001', 'Cardiologist', 'MBBS, MD (Cardiology)', 15, 2500.00, 'Monday,Wednesday,Friday', '9:00 AM - 4:00 PM', 15, NULL, '2026-03-08 03:26:38'),
	(2, 5, 'D002', 'Pediatrician', 'MBBS, DCH', 12, 2000.00, 'Tuesday,Thursday,Saturday', '10:00 AM - 5:00 PM', 12, NULL, '2026-03-08 03:26:38'),
	(3, 6, 'D003', 'Neurologist', 'MBBS, MD (Neurology), FRCP', 20, 3000.00, 'Monday,Wednesday,Friday', '8:00 AM - 3:00 PM', 10, NULL, '2026-03-08 03:26:38'),
	(4, 7, 'D004', 'Dermatologist', 'MBBS, DVD', 10, 1800.00, 'Tuesday,Thursday,Saturday', '9:00 AM - 4:00 PM', 12, NULL, '2026-03-08 03:26:38'),
	(5, 8, 'D005', 'Orthopedic Surgeon', 'MBBS, MS (Ortho)', 18, 2800.00, 'Monday,Thursday,Saturday', '10:00 AM - 5:00 PM', 12, NULL, '2026-03-08 03:26:38');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
