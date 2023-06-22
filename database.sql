-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Versie:              12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Databasestructuur van knowitall wordt geschreven
CREATE DATABASE IF NOT EXISTS `knowitall` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `knowitall`;

-- Structuur van  tabel knowitall.account wordt geschreven
CREATE TABLE IF NOT EXISTS `account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `userpassword` varchar(255) DEFAULT NULL,
  `permission` int(1) DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `ban` int(11) DEFAULT 0,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumpen data van tabel knowitall.account: ~0 rows (ongeveer)
REPLACE INTO `account` (`account_id`, `username`, `userpassword`, `permission`, `email`, `ban`) VALUES
	(92, 'julian', '$2y$10$olYW9BL3oIwOHQKInuj7i.7LH1rHssVldNEfJp0FqGM2yg2oxzHTi', 3, 'berlejulian@gmail.com', 0);

-- Structuur van  tabel knowitall.ban wordt geschreven
CREATE TABLE IF NOT EXISTS `ban` (
  `ban_id` int(11) NOT NULL AUTO_INCREMENT,
  `ban_date` date DEFAULT NULL,
  `bancol` varchar(45) DEFAULT NULL,
  `account_account_id` int(11) NOT NULL,
  PRIMARY KEY (`ban_id`),
  KEY `fk_ban_account_idx` (`account_account_id`),
  CONSTRAINT `fk_ban_account` FOREIGN KEY (`account_account_id`) REFERENCES `account` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumpen data van tabel knowitall.ban: ~0 rows (ongeveer)

-- Structuur van  tabel knowitall.message wordt geschreven
CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_date` date DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `approval` int(1) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `fact_date` date DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `account_account_id` int(11) NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `fk_message_account1_idx` (`account_account_id`),
  CONSTRAINT `fk_message_account1` FOREIGN KEY (`account_account_id`) REFERENCES `account` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumpen data van tabel knowitall.message: ~0 rows (ongeveer)
REPLACE INTO `message` (`message_id`, `post_date`, `title`, `approval`, `description`, `fact_date`, `image`, `account_account_id`) VALUES
	(26, '2023-06-22', 'jan', 2, '12345trfgf', '2023-06-15', 'IMG-64944e34462590.91234036.jpg', 92);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
