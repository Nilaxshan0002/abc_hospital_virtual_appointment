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

-- Dumping structure for table abc_virtual_hospital.registration_logs
CREATE TABLE IF NOT EXISTS `registration_logs` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `phone_number` varchar(15) NOT NULL,
  `emergency_contact` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `current_medications` text DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `primary_care_physician` varchar(100) DEFAULT NULL,
  `email_address` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Create Patient Account\r\nJoin ABC Virtual Healthcare System for Quality Medical Care.';

-- Dumping data for table abc_virtual_hospital.registration_logs: ~5 rows (approximately)
INSERT INTO `registration_logs` (`user_id`, `full_name`, `dob`, `gender`, `blood_group`, `phone_number`, `emergency_contact`, `address`, `city`, `postal_code`, `allergies`, `current_medications`, `medical_history`, `primary_care_physician`, `email_address`, `username`, `password`, `profile_picture`, `created_at`) VALUES
	(1, 'Kamal Perera', '2008-03-09', 'Male', 'A+', '0771556989', '0771556988', 'Colombo', 'Colombo', '2500816', '-', '-', '-', 'Dr. Kamal Perera', 'kamal@gmal.com', 'kamal002', '$2y$12$mG8uENqv6coB/VYYVzQOG.uYSUc02qnipDyjSgwrumshd5fW3Gkei', 'assets/uploads/profiles/profile_69aef68da99c2_1773074061.jpg', '2026-03-09 16:34:21'),
	(2, 'Vimal Vimal', '2008-03-08', 'Male', 'A-', '0775118969', '0775118967', 'Kandy 04', 'Kandy', '2500897', '-', '-', '-', 'Dr . Kamal Perera', 'vimal@gmail.com', 'Vimal003', 'Vimal@123', 'assets/uploads/profiles/profile_69aef8f96b444_1773074681.jpg', '2026-03-09 16:44:41'),
	(3, 'Rajini Rajini', '2008-03-05', 'Male', 'B-', '0778956899', '0778956898', 'Matale 09', 'Matale', '2500896', '-', '-', '-', 'Dr. Kamal Perera', 'rajini@gamail.com', 'rajini004', 'Rajini@123', 'assets/uploads/profiles/profile_69aef9a77f27b_1773074855.jpg', '2026-03-09 16:47:35'),
	(4, 'Kamal Kamal', '2008-03-02', 'Male', 'A+', '0778969565', '0778969568', 'Colombo 05', 'Colombo', '2500816', '-', '-', '-', 'Dr. Kamal Perera', 'kamal@gmail.com', 'Kamal0034', 'Kamal@234', 'assets/uploads/profiles/profile_69aefa1820823_1773074968.jpg', '2026-03-09 16:49:28'),
	(5, 'Santhosh', '2008-05-24', 'Male', 'A+', '0771556933', '0767166929', 'Colombo 05 Streeeet Road', 'Colombo', '250081693', '-', '-', '-', 'Dr.Kamal Perera', 'Santhosh@gmail.com', 'Santhosh', 'Santhosh@£$%123', 'assets/uploads/profiles/profile_6a1d91089ff59_1780322568.jpg', '2026-06-01 14:02:48');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
