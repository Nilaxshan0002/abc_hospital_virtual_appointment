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

-- Dumping structure for table abc_virtual_hospital.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `user_role` enum('admin','doctor','patient','receptionist') NOT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `login_attempts` int(11) DEFAULT 0,
  `last_failed_login` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `login_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`user_role`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abc_virtual_hospital.users: ~15 rows (approximately)
INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `full_name`, `user_role`, `status`, `login_attempts`, `last_failed_login`, `last_login`, `last_login_ip`, `login_count`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '$2y$10$MHb8jlQb4Vx40RD3TPA19.tJRUYQLALfHF0oi20c16jkmjt7/sDKG', 'admin@abchospital.lk', 'System Administrator', 'admin', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:30', '2026-03-09 16:24:30'),
	(2, 'admin2', '$2y$10$tjQWu3KmYpTzWqLIW/.ugulrpudUrNt52IpycKWpjYQiRfJkY0uyi', 'admin2@abchospital.lk', 'Senior Admin', 'admin', 'active', 1, '2026-06-01 16:32:47', NULL, NULL, 0, '2026-03-09 16:24:30', '2026-06-01 16:32:47'),
	(3, 'Kamal', '$2y$10$YxLIhkHeO0gLuXM7MWo7BeJumKS2n5LBdapVeZh5RD0F1h7Vp24j2', 'kamal@abchospital.lk', 'Kamal Admin', 'admin', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:30', '2026-03-09 16:24:30'),
	(4, 'dr.kamal', '$2y$10$vh08MWQGmRiMaQeE8pxeVu8TRhol..2P87OhoQ3VHKJc2O/z6qo6S', 'kamal.perera@abchospital.lk', 'Dr. Kamal Perera', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:30', '2026-03-09 16:24:30'),
	(5, 'dr.nimali', '$2y$10$LJcloQdnLTu40LSD5lCaXeWBrv7pRitgGlvYKdSxQXPX9by/n/4WG', 'nimali.fernando@abchospital.lk', 'Dr. Nimali Fernando', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:30', '2026-03-09 16:24:30'),
	(6, 'dr.sunil', '$2y$10$0fTEvi7GIU.baS4vrPCk0uPrffq4PolSkEX1q5Q3EcussZnxmZTI6', 'sunil.wijesinghe@abchospital.lk', 'Dr. Sunil Wijesinghe', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:30', '2026-03-09 16:24:30'),
	(7, 'dr.priyani', '$2y$10$Bw0H0GubpBNIqXgSL.RQ1OEbFMh/M6TkjeI3xoZpHwWbDP3cl0NgC', 'priyani.jayawardena@abchospital.lk', 'Dr. Priyani Jayawardena', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(8, 'dr.ruwan', '$2y$10$pZRKukzf8eb/yU5CS621gewkMOOrYsPP5CN72XKutIjwJPjPCxtRa', 'ruwan.silva@abchospital.lk', 'Dr. Ruwan Silva', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(9, 'saman.k', '$2y$10$dw7Uab5ANttHQwtlqqxe/ODbqpsnroDyKRe5ZbaoBX/Cv14zxEnCa', 'saman.k@email.com', 'Saman Kumara', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(10, 'malini.f', '$2y$10$SG.CdfSNYcrP0q4Tu2fHZOz2Njw6V63BZRKVx/hVg9ANe/t86AbFW', 'malini.f@email.com', 'Malini Fonseka', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(11, 'vijay.k', '$2y$10$VZNucwiWsa3SISeQSFg4vuMgOZV3vWzemQdmFdvC9L7jXbufItB8O', 'vijay.k@email.com', 'Vijay Kumaratunga', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(12, 'nimal.p', '$2y$10$o1dUb822kMviLAZmApC9IOJSgpovJn3sUGBrYRU5RMCt8.1u1Qspe', 'nimal.p@email.com', 'Nimal Perera', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(13, 'chamari.a', '$2y$10$gOKNgvHb4JLgo6AmTKhr8Oi/k4jUuYSSiw1M3VCgNsGCV0G.1d/SO', 'chamari.a@email.com', 'Chamari Athapaththu', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(14, 'reception1', '$2y$10$VBcPfpSccUNtNRECjFHZv.yuM5skbfn30RJxBuuK.JklcYMklSNDe', 'reception@abchospital.lk', 'Dilshan Fernando', 'receptionist', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31'),
	(15, 'reception2', '$2y$10$ETITTwSljbpXGOkR74MiIugkFM41v0iOc9RkiJAoAg/vxUgqr.lAW', 'frontdesk@abchospital.lk', 'Kavisha Silva', 'receptionist', 'active', 0, NULL, NULL, NULL, 0, '2026-03-09 16:24:31', '2026-03-09 16:24:31');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
