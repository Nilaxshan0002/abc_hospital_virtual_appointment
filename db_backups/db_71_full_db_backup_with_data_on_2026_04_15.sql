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

-- Dumping structure for table abc_virtual_hospital.book_your_appointment
CREATE TABLE IF NOT EXISTS `book_your_appointment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `scan_type` enum('MRI Scan - LKR 25,000','CT Scan - LKR 15,000','X-Ray - LKR 3,500','Ultrasound - LKR 5,000','Mammogram - LKR 8,000') NOT NULL DEFAULT 'MRI Scan - LKR 25,000',
  `preferred_date` date NOT NULL,
  `preferred_time` enum('9.00 AM','10.00 AM','11.00 AM','2.00 PM','3.00 PM','4.00 PM') NOT NULL DEFAULT '9.00 AM',
  `referring_doctor` varchar(100) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `terms_agreed` tinytext NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Advanced imaging technology with expert radiologists.';

-- Dumping data for table abc_virtual_hospital.book_your_appointment: ~3 rows (approximately)
INSERT INTO `book_your_appointment` (`id`, `full_name`, `email_address`, `phone_number`, `scan_type`, `preferred_date`, `preferred_time`, `referring_doctor`, `additional_notes`, `terms_agreed`, `created_at`, `updated_at`) VALUES
	(1, 'Nimal Jayasinghe', 'nimal.j@gmail.com', '+94715551234', 'MRI Scan - LKR 25,000', '2026-06-10', '9.00 AM', 'Dr. K. L. Perera', 'Claustrophobic, might need sedation assistance if possible.', '1', '2026-06-03 17:48:19', '2026-06-03 17:50:29'),
	(2, 'Emily Watson', 'emily.w@yahoo.com', '+15559876543', 'X-Ray - LKR 3,500', '2026-06-03', '2.00 PM', 'Dr. Ananya Sharma', 'Routine pregnancy checkup.', '1', '2026-06-03 17:52:39', '2026-06-03 17:52:39'),
	(3, 'Thusitha Silva', 'thusitha.s@mail.lk', '+94771112222', 'Ultrasound - LKR 5,000', '2026-06-08', '11.00 AM', NULL, 'Persistent cough for two weeks.', '1', '2026-06-03 17:53:54', '2026-06-03 17:53:54');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
