-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: cat100cat
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

CREATE DATABASE cat100cat;

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

USE cat100cat;

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `egg_id` varchar(255) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `is_selected` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `deck_id` (`deck_id`),
  CONSTRAINT `card_ibfk_1` FOREIGN KEY (`deck_id`) REFERENCES `deck` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `card`
--

LOCK TABLES `card` WRITE;
/*!40000 ALTER TABLE `card` DISABLE KEYS */;
INSERT INTO `card` VALUES (1,'5cac51240d488f0da6151bcd',7,0),(2,'5cac51240d488f0da6151bce',7,0),(3,'5cac51240d488f0da6151bcf',7,0),(4,'5cac51240d488f0da6151bd0',7,0),(5,'5cac51240d488f0da6151bd1',7,0),(6,'5cac51240d488f0da6151bd2',7,0),(7,'5cac51240d488f0da6151bd3',7,0),(8,'5cac51240d488f0da6151bd4',7,0),(9,'5cac51240d488f0da6151bd5',7,0),(10,'5cac51240d488f0da6151bcd',8,0),(11,'5cac51240d488f0da6151bce',8,0),(12,'5cac51240d488f0da6151bcf',8,0),(13,'5cac51240d488f0da6151bd0',8,0),(14,'5cac51240d488f0da6151bd1',8,0),(15,'5cac51240d488f0da6151bd2',8,0),(16,'5cac51240d488f0da6151bd3',8,0),(17,'5cac51240d488f0da6151bd4',8,0),(18,'5cac51240d488f0da6151bd5',8,0),(19,'5cac51240d488f0da6151bdf',9,0),(20,'5cac51240d488f0da6151be0',9,0),(21,'5cac51240d488f0da6151be1',9,0),(22,'5cac51240d488f0da6151be2',9,0),(23,'5cac51240d488f0da6151be3',9,0),(24,'5cac51240d488f0da6151be4',9,0),(25,'5cac51240d488f0da6151be5',9,0),(26,'5cac51240d488f0da6151be6',9,0),(27,'5cac51240d488f0da6151be7',9,0),(28,'5cac51240d488f0da6151bdf',10,1),(29,'5cac51240d488f0da6151be0',10,1),(30,'5cac51240d488f0da6151be1',10,0),(31,'5cac51240d488f0da6151be2',10,0),(32,'5cac51240d488f0da6151be3',10,1),(33,'5cac51240d488f0da6151be4',10,1),(34,'5cac51240d488f0da6151be5',10,1),(35,'5cac51240d488f0da6151be6',10,0),(36,'5cac51240d488f0da6151be7',10,0);
/*!40000 ALTER TABLE `card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deck`
--

DROP TABLE IF EXISTS `deck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lord_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `deck_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deck`
--

LOCK TABLES `deck` WRITE;
/*!40000 ALTER TABLE `deck` DISABLE KEYS */;
INSERT INTO `deck` VALUES (1,'Prout','5cac51240d488f0da6151c31',25),(2,'Caca','5cac51240d488f0da6151c32',27),(3,'test2','5cac51240d488f0da6151c34',25),(4,'Quentin','5cac51240d488f0da6151c34',28),(5,'Coucou','5cac51240d488f0da6151c33',29),(6,'coucou','5cac51240d488f0da6151c31',29),(7,'BOUH','5cac51240d488f0da6151c31',29),(8,'Pouet','5cac51240d488f0da6151c31',30),(9,'truc','5cac51240d488f0da6151c33',30),(10,'TeamCat','5cac51240d488f0da6151c33',26);
/*!40000 ALTER TABLE `deck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (25,'dremsis','dremsis64@hotmail.fr','$2y$10$u9k2u0zR8AUsfLUUsu7pJuvm73s2zN21/iD4LY6KxdlX14bAzUFhS'),(26,'ju','jul.bousseau@gmail.com','$2y$10$BprZYrXsfnFHHDNT2t1RPuXotTQXeHQ/.nTnHGtSvkhXTPVUyvNb2'),(27,'martinh','martinh@outlook.fr','$2y$10$BFRRzC0xE8O9rRwtlT3Xt.NMrfrGlIaXNeaiX8kFP55yYDsdCVzHW'),(28,'ad','adeline.dubosc@hotmail.fr','$2y$10$BOGSncc02YrYazeOSo.3ae9ObCCO.OkuV2Qhb4ilAoi7CmgZWJGmG'),(29,'split','mcuville@gmail.com','$2y$10$YfIvx7PMtUURGoK3NUYqUuxSYVEt/T4ESMLA/ya1qKKQ3hTqL85HS'),(30,'jef933','geoffrey@gmail.com','$2y$10$D1e0CbB8Tai6CsGgYqLdj.Ejli34cYy9cBNirJa3zm.4bzNF7xrk2');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-19 10:36:13
