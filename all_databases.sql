-- MySQL dump 10.14  Distrib 5.5.53-MariaDB, for Linux ()
--
-- Host: ORGAMIGOS    Database: ORGAMIGOS
-- ------------------------------------------------------
-- Server version	5.5.53-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `ORGAMIGOS`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ORGAMIGOS` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ORGAMIGOS`;

--
-- Table structure for table `ecocasa`
--

DROP TABLE IF EXISTS `ecocasa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ecocasa` (
  `UID` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ecocasa`
--

LOCK TABLES `ecocasa` WRITE;
/*!40000 ALTER TABLE `ecocasa` DISABLE KEYS */;
INSERT INTO `ecocasa` VALUES (1,'La casa orgánica de David el francés','Francisco I. Madero #5835 / int. 1 (entre calles Aldama y Cotilla) - colónia Jócotan - 451017 - Zapopan',20.687130,-103.441109,'abierto'),(2,'El eco-depa de la pintora','Diplomáticos 4541 / int 5, Jardines de Guadalupe, 45030 Zapopan, Jal.',20.664082,-103.419472,'proyecto'),(3,'El studio de foto','452 Calle Hospital\r\nGuadalajara, Jalisco',20.685413,-103.347702,'cerrado');
/*!40000 ALTER TABLE `ecocasa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ecocasa_members`
--

DROP TABLE IF EXISTS `ecocasa_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ecocasa_members` (
  `ecocasaid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  PRIMARY KEY (`ecocasaid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ecocasa_members`
--

LOCK TABLES `ecocasa_members` WRITE;
/*!40000 ALTER TABLE `ecocasa_members` DISABLE KEYS */;
INSERT INTO `ecocasa_members` VALUES (1,55),(2,55);
/*!40000 ALTER TABLE `ecocasa_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_home`
--

DROP TABLE IF EXISTS `user_home`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_home` (
  `userid` bigint(20) NOT NULL,
  `homeid` bigint(20) NOT NULL,
  KEY `userid` (`userid`),
  KEY `homeid` (`homeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_home`
--

LOCK TABLES `user_home` WRITE;
/*!40000 ALTER TABLE `user_home` DISABLE KEYS */;
INSERT INTO `user_home` VALUES (56,1),(56,1);
/*!40000 ALTER TABLE `user_home` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `UID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `fbid` bigint(20) unsigned NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `password` char(64) NOT NULL,
  `isVerified` enum('Y','N') NOT NULL DEFAULT 'N',
  `tokenCode` varchar(100) NOT NULL,
  `memberSInce` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `Femail` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (55,'ailidsystem@gmail.com',0,'David','AILI','$2y$10$vggg5yXyfQxL5WcGv/xKMe3IUL3uUwhAPZtQOwxnaYfKaVsmvFw3K','Y','8d26224c9276baeec689eb114ac8127a','2017-03-27 17:02:25'),(56,'david.aili@free.fr',0,'roger','roger','$2y$10$CE9oeULcu7kvp8tmTNW2gODzZJOOniK3eXpEbT5r78QSVREJDJsAG','Y','8fca8a450b8efc8f679803028d72069e','2017-03-28 03:48:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-29  5:18:32
