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

-- Dumping structure for table abc_virtual_hospital.login
CREATE TABLE IF NOT EXISTS `login` (
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Welcome Back\r\nSign in to continue to ABC Virtual.';

-- Dumping data for table abc_virtual_hospital.login: ~15 rows (approximately)
INSERT INTO `login` (`user_id`, `username`, `password`, `email`, `full_name`, `user_role`, `status`, `login_attempts`, `last_failed_login`, `last_login`, `last_login_ip`, `login_count`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '$2y$10$sZO8z03tRqjJp2zoJ1JNeehuyxtSH/j9KKmt64s1D3Zhqt8aSeagy', 'admin@abchospital.lk', 'System Administrator', 'admin', 'active', 1, '2026-03-09 15:54:37', NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-09 15:54:37'),
	(2, 'admin2', '$2y$10$wppLoKe5Ax.c49eGjBJLOOOh/yEbc2LXXDORSs6f7kPQidK918DAu', 'admin2@abchospital.lk', 'Senior Admin', 'admin', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-08 03:26:37'),
	(3, 'Kamal', '$2y$10$TSHG6Bcduf6fclP5WoAGxOpo03TBRhWxj6zqFSpcvvPtFJP.hNlxq', 'kamal@abchospital.lk', 'Kamal Admin', 'admin', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-08 03:26:37'),
	(4, 'dr.kamal', '$2y$10$Nf8tllL4whVpjm8ABJ3YVO9CAxSOL/FvJpn9ELxQEPQ06ayJk./Re', 'kamal.perera@abchospital.lk', 'Dr. Kamal Perera', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-08 03:26:37'),
	(5, 'dr.nimali', '$2y$10$IE8MOlhAwbu6G.5ntooPxOY3KtBLgT9et8atZVY1KsWFQqv2Mo21a', 'nimali.fernando@abchospital.lk', 'Dr. Nimali Fernando', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-08 03:26:37'),
	(6, 'dr.sunil', '$2y$10$zFKUhtAY09bXUe4vfVBOsOELt9JVhExzAZHgf7LnjI6wjDZj2eCQ6', 'sunil.wijesinghe@abchospital.lk', 'Dr. Sunil Wijesinghe', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-08 03:26:37'),
	(7, 'dr.priyani', '$2y$10$oCLddKJZusGbAf.lPd8zKuTgwDTIDYu7E.F3cKV/2xWQXI1Lx6zfG', 'priyani.jayawardena@abchospital.lk', 'Dr. Priyani Jayawardena', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-08 03:26:37'),
	(8, 'dr.ruwan', '$2y$10$fIBATJV6s5KrCZBjDAHLaORXF4M.YpsUZpF9Ht1pgLezRrsTbTH/C', 'ruwan.silva@abchospital.lk', 'Dr. Ruwan Silva', 'doctor', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:37', '2026-03-08 03:26:37'),
	(9, 'saman.k', '$2y$10$SSINOcMC2DQCisSdIh7DQ.aL.QYxTXkPItcrP9.8D/KaC1etpkXiS', 'saman.k@email.com', 'Saman Kumara', 'patient', 'active', 1, '2026-03-09 15:55:13', NULL, NULL, 0, '2026-03-08 03:26:38', '2026-03-09 15:55:13'),
	(10, 'malini.f', '$2y$10$YxF4jLnTwVPrG718BaUbfe1UPNb.eNAUfYo9DSVS3b8yYD2awdLTS', 'malini.f@email.com', 'Malini Fonseka', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:38', '2026-03-08 03:26:38'),
	(11, 'vijay.k', '$2y$10$AiYj08LSIIy68cNfPJjfFuJ3JCqUclhFOFWLQZ8P9uu6bgcCICxS.', 'vijay.k@email.com', 'Vijay Kumaratunga', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:38', '2026-03-08 03:26:38'),
	(12, 'nimal.p', '$2y$10$aoxDTAxjJxPPteMyNVe8M.gNvp/WhScSa8dk80Gm380KJFH4H4vJG', 'nimal.p@email.com', 'Nimal Perera', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:38', '2026-03-08 03:26:38'),
	(13, 'chamari.a', '$2y$10$r/u3q4.mpP8twKqYa88WCuWXd6DHX4hWO.9mSFkbZmS4oToh2443a', 'chamari.a@email.com', 'Chamari Athapaththu', 'patient', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:38', '2026-03-08 03:26:38'),
	(14, 'reception1', '$2y$10$SwDfenAbBUEzZ8UUfVYh9uoZQk/h8w2MT3Xyb0xFL8fSnZL/TjWlW', 'reception@abchospital.lk', 'Dilshan Fernando', 'receptionist', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:38', '2026-03-08 03:26:38'),
	(15, 'reception2', '$2y$10$xy7NzxS5KForljmHcCRR2.pwA20nSq30ebWBhOuk/YusZ3A/ztWgC', 'frontdesk@abchospital.lk', 'Kavisha Silva', 'receptionist', 'active', 0, NULL, NULL, NULL, 0, '2026-03-08 03:26:38', '2026-03-08 03:26:38');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
