# Host: localhost  (Version: 5.5.5-10.1.25-MariaDB)
# Date: 2018-01-19 17:15:55
# Generator: MySQL-Front 5.3  (Build 1.27)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

USE `db_expert`;

#
# Source for table "ds_evidences"
#

DROP TABLE IF EXISTS `ds_evidences`;
CREATE TABLE `ds_evidences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

#
# Data for table "ds_evidences"
#

/*!40000 ALTER TABLE `ds_evidences` DISABLE KEYS */;
INSERT INTO `ds_evidences` VALUES (1,'G1','Berkurangnya rasa, terutama di tangan'),(2,'G2','Darah di Dalam air kencing (hematuria)'),(3,'G3','Demam'),(4,'G4','Kejang'),(5,'G5','Kencing di malam hari (Nokturia)'),(6,'G6','Menggigil'),(7,'G7','Mual'),(8,'G8','Mudah lelah'),(9,'G9','Muntah'),(10,'G10','Nafsu makan menurun '),(11,'G11','Nanah di air kencing '),(12,'G12','Nyeri di tulang pinggul'),(13,'G13','Nyeri di daerah kandung kemih '),(14,'G14','Nyeri di daerah ginjal'),(15,'G15','Nyeri ketika kencing (Disuria)'),(16,'G16','Nyeri perut'),(17,'G17','Desakan untuk kencing'),(18,'G18','Nyeri punggung bagian bawah'),(19,'G19','Nyeri yang hilang timbul'),(20,'G20','pembekakan bagian tubuh tertentu ');
/*!40000 ALTER TABLE `ds_evidences` ENABLE KEYS */;

#
# Source for table "ds_problems"
#

DROP TABLE IF EXISTS `ds_problems`;
CREATE TABLE `ds_problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "ds_problems"
#

/*!40000 ALTER TABLE `ds_problems` DISABLE KEYS */;
INSERT INTO `ds_problems` VALUES (1,'P1','Gagal Ginjal Akut'),(2,'P2','Kanker Ginjal'),(3,'P3','Pielonefritis'),(4,'P4','Sindrom Nefrotik'),(5,'P5','Hidronefrosis'),(6,'P6','Kanker Kandung Kemih'),(7,'P7','Ginjal Polikista'),(8,'P8','Nefritis Tububinterstisialis'),(9,'P9','Sislitis'),(10,'P10','Infeksi Saluran Kemih');
/*!40000 ALTER TABLE `ds_problems` ENABLE KEYS */;

#
# Source for table "ds_rules"
#

DROP TABLE IF EXISTS `ds_rules`;
CREATE TABLE `ds_rules` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_problem` int(11) DEFAULT NULL,
  `id_evidence` int(11) DEFAULT NULL,
  `cf` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

#
# Data for table "ds_rules"
#

/*!40000 ALTER TABLE `ds_rules` DISABLE KEYS */;
INSERT INTO `ds_rules` VALUES (1,1,1,0.3),(6,1,2,0.2),(7,2,2,0.2),(8,4,2,0.2),(9,5,2,0.2),(10,6,2,0.2),(11,7,2,0.2),(12,8,2,0.2),(13,9,2,0.2),(14,1,3,0.3),(15,2,3,0.3),(16,3,3,0.3),(17,5,3,0.3),(18,6,3,0.3),(19,8,3,0.3),(20,9,3,0.3),(21,6,4,0.5),(22,8,4,0.5),(23,9,4,0.5),(24,1,5,0.4),(25,1,6,0.6),(26,8,6,0.6),(27,3,7,0.7),(28,8,7,0.7),(29,1,8,0.4),(30,3,8,0.4),(31,5,8,0.4),(32,7,8,0.4),(33,8,8,0.4),(34,1,9,0.5),(35,2,9,0.5),(36,7,9,0.5),(37,1,10,0.5),(38,3,10,0.5),(39,5,10,0.5),(40,8,10,0.5),(41,4,11,0.3),(42,5,12,0.5),(43,10,12,0.5),(44,5,13,0.4),(45,10,13,0.4),(46,2,14,0.5),(47,5,14,0.5),(48,3,15,0.4),(49,7,15,0.4),(50,3,16,0.6),(51,4,16,0.6),(52,6,16,0.6),(53,8,16,0.6),(54,9,16,0.6),(55,10,16,0.6),(56,3,17,0.5),(57,4,17,0.5),(58,5,17,0.5),(59,3,18,0.4),(60,4,18,0.4),(61,7,18,0.4),(62,8,18,0.4),(63,9,18,0.4),(64,5,19,0.6),(65,4,20,0.5);
/*!40000 ALTER TABLE `ds_rules` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
