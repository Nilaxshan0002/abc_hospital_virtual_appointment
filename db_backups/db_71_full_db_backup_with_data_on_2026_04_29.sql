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

-- Dumping structure for table abc_virtual_hospital.request_correction
CREATE TABLE IF NOT EXISTS `request_correction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `nic_passport` varchar(50) DEFAULT NULL,
  `data_requiring_correction` text DEFAULT NULL,
  `corrected_information` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Correct inaccurate or incomplete information.';

-- Dumping data for table abc_virtual_hospital.request_correction: ~3 rows (approximately)
INSERT INTO `request_correction` (`id`, `full_name`, `email_address`, `nic_passport`, `data_requiring_correction`, `corrected_information`, `created_at`) VALUES
	(1, 'Alice Perera', 'alice.p@outlook.com', '199578432V', 'Wrong phone number in profile.', 'Please update it to +94 77 123 4567.', '2026-06-03 17:29:51'),
	(2, 'David Miller', 'davidmiller@gmail.com', 'N9876543', 'Home address misspelled as "Main Stret".', 'It should be "45 Main Street, Colombo 03".', '2026-06-03 17:30:32'),
	(3, 'Fatima Asma', 'fatima.b@domain.com', '200365400122', 'Incorrect date of birth on file (1993-05-12).', 'Correct date of birth is 1993-11-12.', '2026-06-03 17:30:45');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
