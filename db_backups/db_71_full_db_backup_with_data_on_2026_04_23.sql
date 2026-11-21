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

-- Dumping structure for table abc_virtual_hospital.password_reset_logs
CREATE TABLE IF NOT EXISTS `password_reset_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_at` timestamp NULL DEFAULT NULL,
  `status` enum('requested','success','failed') DEFAULT 'requested',
  PRIMARY KEY (`log_id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `password_reset_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='passwords changing things.';

-- Dumping data for table abc_virtual_hospital.password_reset_logs: ~3 rows (approximately)
INSERT INTO `password_reset_logs` (`log_id`, `user_id`, `ip_address`, `user_agent`, `requested_at`, `reset_at`, `status`) VALUES
	(1, 2, '192.168.1.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', '2026-06-03 17:37:28', '2026-06-03 17:37:29', 'requested'),
	(2, 7, '203.0.113.195', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15)', '2026-06-03 17:37:56', '2026-06-03 17:37:57', 'requested'),
	(3, 4, '192.168.1.112', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5)', '2026-06-03 17:38:24', '2026-06-03 17:38:25', 'requested');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
