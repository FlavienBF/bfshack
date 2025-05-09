-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: BDD_upload
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `clics` int(11) NOT NULL AUTO_INCREMENT,
  `userName` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `ip` text NOT NULL,
  `heure` text NOT NULL,
  `date` text NOT NULL,
  `userAgent` text NOT NULL,
  `token` text NOT NULL,
  `admin` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`clics`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,'bf','mailfictif@bf.bf','$2y$10$3rx5yr4teygS7eOYzSe6He6v8a1OSNDdMZRVzh0KCDSZ2mQKte6P.','::1','11:50:49','2025-04-25','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','',1);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `clics` int(11) NOT NULL AUTO_INCREMENT,
  `compte` text NOT NULL,
  `prenom` text NOT NULL,
  `nom` text NOT NULL,
  `adresseMail` text NOT NULL,
  `abus` text NOT NULL,
  `message` text NOT NULL,
  `ip` text NOT NULL,
  `heure` text NOT NULL,
  `date` text NOT NULL,
  `userAgent` text NOT NULL,
  PRIMARY KEY (`clics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_admin`
--

DROP TABLE IF EXISTS `log_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_admin` (
  `clics` int(11) NOT NULL AUTO_INCREMENT,
  `compte` text NOT NULL,
  `page` text NOT NULL,
  `ip` text NOT NULL,
  `heure` text NOT NULL,
  `date` text NOT NULL,
  `userAgent` text NOT NULL,
  PRIMARY KEY (`clics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_admin`
--

LOCK TABLES `log_admin` WRITE;
/*!40000 ALTER TABLE `log_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_adminlogin`
--

DROP TABLE IF EXISTS `log_adminlogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_adminlogin` (
  `clics` int(11) NOT NULL AUTO_INCREMENT,
  `page` text NOT NULL,
  `ip` text NOT NULL,
  `heure` text NOT NULL,
  `date` text NOT NULL,
  `userAgent` text NOT NULL,
  PRIMARY KEY (`clics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_adminlogin`
--

LOCK TABLES `log_adminlogin` WRITE;
/*!40000 ALTER TABLE `log_adminlogin` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_adminlogin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_index`
--

DROP TABLE IF EXISTS `log_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_index` (
  `clics` int(11) NOT NULL AUTO_INCREMENT,
  `compte` text NOT NULL,
  `page` text NOT NULL,
  `ip` text NOT NULL,
  `heure` text NOT NULL,
  `date` text NOT NULL,
  `userAgent` text NOT NULL,
  PRIMARY KEY (`clics`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_index`
--

LOCK TABLES `log_index` WRITE;
/*!40000 ALTER TABLE `log_index` DISABLE KEYS */;
INSERT INTO `log_index` VALUES (1,'Utilisateur anonyme','Index','::1','11:50:38','25/04/2025','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36'),(2,'Utilisateur anonyme','Index','::1','11:50:54','25/04/2025','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36');
/*!40000 ALTER TABLE `log_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_upload`
--

DROP TABLE IF EXISTS `log_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_upload` (
  `clics` int(11) NOT NULL AUTO_INCREMENT,
  `compte` text NOT NULL,
  `page` text NOT NULL,
  `ip` text NOT NULL,
  `heure` text NOT NULL,
  `date` text NOT NULL,
  `userAgent` text NOT NULL,
  `image` text NOT NULL,
  `taille` text NOT NULL,
  `urlImage` text NOT NULL,
  PRIMARY KEY (`clics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_upload`
--

LOCK TABLES `log_upload` WRITE;
/*!40000 ALTER TABLE `log_upload` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_logout`
--

DROP TABLE IF EXISTS `login_logout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_logout` (
  `clics` int(11) NOT NULL AUTO_INCREMENT,
  `etat` text NOT NULL,
  `userName` text NOT NULL,
  `ip` text NOT NULL,
  `heure` text NOT NULL,
  `date` text NOT NULL,
  `userAgent` text NOT NULL,
  PRIMARY KEY (`clics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_logout`
--

LOCK TABLES `login_logout` WRITE;
/*!40000 ALTER TABLE `login_logout` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_logout` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-25 11:51:46
