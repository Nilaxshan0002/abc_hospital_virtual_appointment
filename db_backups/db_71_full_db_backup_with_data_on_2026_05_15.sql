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

-- Dumping structure for table abc_virtual_hospital.send_us_a_message
CREATE TABLE IF NOT EXISTS `send_us_a_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `subject` enum('Appointment Query','Billing & Insurance','Medical Records','Technical Support','Feedback','General Inquiry') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='we''re here to help you with any questions or concerns for contact us section.';

-- Dumping data for table abc_virtual_hospital.send_us_a_message: ~5 rows (approximately)
INSERT INTO `send_us_a_message` (`id`, `name`, `email_address`, `phone_number`, `subject`, `message`, `created_at`) VALUES
	(1, 'John Smith', 'john.smith@gmail.com', '0771234567', 'Appointment Query', 'I would like to schedule an appointment with a cardiologist next week.', '2026-06-03 17:13:17'),
	(2, 'Sarah Johnson', 'sarah.johnson@gmail.com', '0712345678', 'Billing & Insurance', 'I believe there is an error in my hospital bill.', '2026-06-03 17:14:57'),
	(3, 'Michael Brown', 'michael.brown@yahoo.com', '0769876543', 'Technical Support', 'I am unable to log in to the patient portal.', '2026-06-03 17:15:41'),
	(4, 'Emily Davis', 'emily.davis@gmail.com', '0755555555', 'General Inquiry', 'What are the visiting hours for patients?', '2026-06-03 17:16:31'),
	(5, 'David Wilson', 'david.wilson@gmail.com', '0788888888', 'Feedback', 'The doctors and staff provided excellent care.', '2026-06-03 17:17:15');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
