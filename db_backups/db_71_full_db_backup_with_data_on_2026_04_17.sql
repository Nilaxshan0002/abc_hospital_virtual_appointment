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

-- Dumping structure for table abc_virtual_hospital.doctor
CREATE TABLE IF NOT EXISTS `doctor` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `experience` varchar(20) NOT NULL,
  `availability` varchar(20) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_active` tinytext DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Meet our team of 6 highly qualified medical professionals dedicated to your health.';

-- Dumping data for table abc_virtual_hospital.doctor: ~3 rows (approximately)
INSERT INTO `doctor` (`id`, `name`, `specialty`, `experience`, `availability`, `profile_image`, `is_active`, `created_at`) VALUES
	(1, 'Dr. K. L. Perera', 'Cardiologist', '12 years', 'Mon, Wed 09:00 - 13:', 'uploads/doctors/dr_perera.jpg', '1', '2026-06-03 17:45:11'),
	(2, 'Dr. Ananya Sharma', 'Pediatrician', '8 years', 'Tue, Thu 14:00 - 18:', 'uploads/doctors/dr_sharma.jpg', '1', '2026-06-03 17:45:43'),
	(3, 'Dr. Michael Chang', 'Dermatologist', '15 years', 'Fri 16:00 - 20:00', 'uploads/doctors/dr_chang.jpg', '0', '2026-06-03 17:46:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
