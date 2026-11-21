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

-- Dumping structure for table abc_virtual_hospital.request_your_data
CREATE TABLE IF NOT EXISTS `request_your_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `nic_passport` varchar(50) NOT NULL,
  `request_type` enum('Complete Medical Records','Personal Information Only','Medical History Only') NOT NULL,
  `request_status` enum('pending','processing','completed','rejected') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_at` timestamp NULL DEFAULT NULL,
  `processed_by` int(11) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Request a copy of your personal data.';

-- Dumping data for table abc_virtual_hospital.request_your_data: ~3 rows (approximately)
INSERT INTO `request_your_data` (`id`, `full_name`, `email_address`, `nic_passport`, `request_type`, `request_status`, `admin_notes`, `requested_at`, `processed_at`, `processed_by`, `ip_address`) VALUES
	(1, 'John Doe', 'johndoe@email.com', '951234567V', 'Medical History Only', 'processing', 'Data archive compiled and securely emailed via encrypted link.', '2026-06-03 17:19:22', '2026-06-03 17:19:25', 0, '192.168.1.45'),
	(2, 'Jane Smith', 'janesmith@email.com', 'N7894561', 'Personal Information Only', 'pending', 'Awaiting user to reply to the identity confirmation email.', '2026-06-03 17:21:31', '2026-06-03 17:24:08', 0, '203.0.113.195'),
	(3, 'Alex Silva', 'alex.silva@email.com', '200012345678', 'Medical History Only', 'rejected', 'Rejected. Provided NIC does not match the registered NIC for this email address.', '2026-06-03 17:23:41', '2026-06-03 17:24:09', 0, '198.51.100.12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
