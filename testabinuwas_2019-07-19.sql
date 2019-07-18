# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.28-MariaDB)
# Database: testabinuwas
# Generation Time: 2019-07-18 18:18:51 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Book`;

CREATE TABLE `Book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) DEFAULT '',
  `jumlah_halaman` int(11) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Book` WRITE;
/*!40000 ALTER TABLE `Book` DISABLE KEYS */;

INSERT INTO `Book` (`id`, `judul`, `jumlah_halaman`, `penerbit`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,'Learning Laravel',167,'Elexmedia',1,'2019-07-18 23:18:57',NULL),
	(2,'Learning React',201,'Elexmedia',2,'2019-07-18 23:18:57',NULL),
	(3,'Test',123,'Test',2,'2019-07-18 17:32:23','2019-07-19 01:12:17'),
	(4,'Test ABC',222,'Test BCV',1,'2019-07-18 17:34:55','2019-07-18 18:11:45'),
	(5,'Learning Laravel 2',44,'Test ACASDASd',1,'2019-07-18 18:06:13','2019-07-18 18:06:13');

/*!40000 ALTER TABLE `Book` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table User
# ------------------------------------------------------------

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;

INSERT INTO `User` (`id`, `nama`, `umur`, `created_at`, `updated_at`)
VALUES
	(1,'John Doe',26,'2019-07-18 23:18:18',NULL),
	(2,'Jane Doe',22,'2019-07-18 23:18:18','2019-07-18 18:01:21');

/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
