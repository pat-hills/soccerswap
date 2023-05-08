/*
SQLyog Enterprise - MySQL GUI v6.13
MySQL - 5.5.5-10.4.14-MariaDB : Database - soccer_swap_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `soccer_swap_db`;

USE `soccer_swap_db`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `country` */

insert  into `country`(`id`,`name`) values (1,'Afghanistan'),(2,'Albania'),(3,'Algeria'),(4,'Andorra'),(5,'Angola'),(6,'Antigua and Barbuda'),(7,'Argentina'),(8,'Armenia'),(9,'Australia'),(10,'Austria'),(11,'Azerbaijan'),(12,'Bahamas'),(13,'Bahrain'),(14,'Bangladesh'),(15,'Barbados'),(16,'Belarus'),(17,'Belgium'),(18,'Belize'),(19,'Benin'),(20,'Bhutan'),(21,'Bolivia'),(22,'Bosnia and Herzegovina'),(23,'Botswana'),(24,'Brazil'),(25,'Brunei'),(26,'Bulgaria'),(27,'Burkina Faso'),(28,'Burundi'),(29,'Cambodia'),(30,'Cameroon'),(31,'Canada'),(32,'Cape Verde'),(33,'Central African Republic'),(34,'Chad'),(35,'Chile'),(36,'China'),(37,'Colombia'),(38,'Comoros'),(39,'Congo (Brazzaville)'),(40,'Congo'),(41,'Costa Rica'),(42,'Ivory Coast'),(43,'Croatia'),(44,'Cuba'),(45,'Cyprus'),(46,'Czech Republic'),(47,'Denmark'),(48,'Djibouti'),(49,'Dominica'),(50,'Dominican Republic'),(51,'East Timor (Timor Timur)'),(52,'Ecuador'),(53,'Egypt'),(54,'El Salvador'),(55,'Equatorial Guinea'),(56,'Eritrea'),(57,'Estonia'),(58,'Ethiopia'),(59,'Fiji'),(60,'Finland'),(61,'France'),(62,'Gabon'),(63,'Gambia, The'),(64,'Georgia'),(65,'Germany'),(66,'Ghana'),(67,'Greece'),(68,'Grenada'),(69,'Guatemala'),(70,'Guinea'),(71,'Guinea-Bissau'),(72,'Guyana'),(73,'Haiti'),(74,'Honduras'),(75,'Hungary'),(76,'Iceland'),(77,'India'),(78,'Indonesia'),(79,'Iran'),(80,'Iraq'),(81,'Ireland'),(82,'Israel'),(83,'Italy'),(84,'Jamaica'),(85,'Japan'),(86,'Jordan'),(87,'Kazakhstan'),(88,'Kenya'),(89,'Kiribati'),(90,'Korea, North'),(91,'Korea, South'),(92,'Kuwait'),(93,'Kyrgyzstan'),(94,'Laos'),(95,'Latvia'),(96,'Lebanon'),(97,'Lesotho'),(98,'Uruguay'),(99,'Uzbekistan'),(100,'Vanuatu'),(101,'Vatican City (Holy See)'),(102,'Venezuela'),(103,'Vietnam'),(104,'Yemen'),(105,'Zambia'),(106,'Zimbabwe');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
