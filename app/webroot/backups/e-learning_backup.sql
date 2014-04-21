-- MySQL dump 10.13  Distrib 5.5.34, for Win32 (x86)
--
-- Host: localhost    Database: e-learning
-- ------------------------------------------------------
-- Server version	5.5.34

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `AnswerId` int(11) NOT NULL AUTO_INCREMENT,
  `QuesId` int(11) NOT NULL,
  `AnswerNumber` int(11) NOT NULL,
  `AnswerContent` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`AnswerId`)
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `CatId` int(11) NOT NULL AUTO_INCREMENT,
  `CatName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CatId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'数学','2014-03-10 03:48:12','2014-03-10 03:48:15',0),(2,'物理','2014-03-10 00:00:00','2014-03-10 00:00:00',0),(3,'化学','2014-03-10 03:51:04','2014-03-10 03:51:06',0),(4,'文学','2014-03-10 03:51:08','2014-03-10 03:51:11',0),(5,'地理','2014-03-10 03:51:42','2014-03-10 03:51:44',0),(6,'歴史','2014-03-10 03:51:46','2014-03-10 03:51:49',0),(7,' 医学','2014-03-10 03:52:21','2014-03-10 03:52:24',0),(8,'外国語','2014-03-10 03:52:26','2014-03-10 03:52:29',0),(9,'経済と社会','2014-03-10 03:52:46','2014-03-10 03:52:49',0),(10,'コンピュータサイエンス','2014-03-10 03:53:07','2014-03-10 03:53:10',0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `CommentId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `Content` text NOT NULL,
  `created` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `UserId` (`UserId`),
  CONSTRAINT `UserId` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,46,124,'fsgdjk;u\'o','2014-04-17 11:31:27',0,'2014-04-17 11:31:27');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configs` (
  `ConfigId` int(11) NOT NULL AUTO_INCREMENT,
  `ConfigName` varchar(45) DEFAULT NULL,
  `ConfigValue` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`ConfigId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
INSERT INTO `configs` VALUES (1,'SessionTimeout','8000','2014-03-11 16:52:27','2014-03-11 16:52:29'),(2,'CourseFee','20000','2014-03-17 00:00:00','2014-03-17 00:00:00'),(3,'FailNumber','3','2014-03-17 00:00:00','2014-03-17 00:00:00'),(4,'SharingRate','40','2014-03-17 00:00:00','2014-03-17 00:00:00');
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `FileId` int(11) NOT NULL AUTO_INCREMENT,
  `LessonId` int(11) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `Alias` varchar(255) NOT NULL,
  `FileLink` text NOT NULL,
  `FileType` int(11) NOT NULL,
  `Extension` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  `IsBlocked` int(11) NOT NULL,
  PRIMARY KEY (`FileId`),
  KEY `files - users` (`LessonId`),
  CONSTRAINT `files - users` FOREIGN KEY (`LessonId`) REFERENCES `lessons` (`LessonId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (64,124,'3deec529d20b943102.pdf','','/uploads/jugyou/File-124-1-285896.pdf',1,'pdf','2014-04-17 11:27:53','2014-04-21 04:57:44',0,1),(65,125,'95259721-Cải-tiến-giải-thuật-mạng-noron-SOM-ap-dụng-để-phan-cụm-mau-ảnh.pdf','','/uploads/jugyou/File-125-1-1142250.pdf',1,'pdf','2014-04-17 15:55:28','2014-04-21 04:55:34',0,0);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ips` (
  `IpId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `IpAddress` varchar(45) DEFAULT NULL,
  `LastUsed` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`IpId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips`
--

LOCK TABLES `ips` WRITE;
/*!40000 ALTER TABLE `ips` DISABLE KEYS */;
INSERT INTO `ips` VALUES (1,10,'127.0.0.1','2014-03-08 15:42:53','2014-03-08 15:42:53','2014-03-08 15:42:53');
/*!40000 ALTER TABLE `ips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lessons` (
  `LessonId` int(11) NOT NULL AUTO_INCREMENT,
  `Category` varchar(255) NOT NULL,
  `Title` text NOT NULL,
  `Abstract` text,
  `Other` text,
  `LikeNumber` int(11) DEFAULT '0',
  `ViewNumber` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LessonId`),
  KEY `Lesson -  User` (`UserId`),
  CONSTRAINT `Lesson -  User` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (124,'1','dafsgh','fdsgdhjk',NULL,2,1,45,'2014-04-17 11:27:53','2014-04-17 11:27:53',0),(125,'3','dafsgdhfj','dasfdhjkg',NULL,0,0,47,'2014-04-17 15:55:28','2014-04-17 15:55:28',0);
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msgs`
--

DROP TABLE IF EXISTS `msgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msgs` (
  `MsgId` int(11) NOT NULL AUTO_INCREMENT,
  `Content` text CHARACTER SET utf8 NOT NULL,
  `UserId` int(11) NOT NULL,
  `MsgType` int(11) NOT NULL DEFAULT '1',
  `IsReaded` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`MsgId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msgs`
--

LOCK TABLES `msgs` WRITE;
/*!40000 ALTER TABLE `msgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `msgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `MesId` int(11) NOT NULL AUTO_INCREMENT,
  `Message` text CHARACTER SET utf8 NOT NULL,
  `UserId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MesId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `QuesId` int(11) NOT NULL AUTO_INCREMENT,
  `QuesNumber` int(11) NOT NULL,
  `TestId` int(11) NOT NULL,
  `QuesContent` text CHARACTER SET utf8 NOT NULL,
  `QuesAnswer` varchar(20) NOT NULL,
  `Point` int(11) NOT NULL,
  PRIMARY KEY (`QuesId`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `ReportId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `Content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ReportId`),
  KEY `reports - users` (`UserId`),
  KEY `reports - lessons` (`LessonId`),
  CONSTRAINT `reports - lessons` FOREIGN KEY (`LessonId`) REFERENCES `lessons` (`LessonId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `reports - users` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,46,124,'Copyright 違反','2014-04-17 11:32:07','2014-04-17 11:32:07',1),(2,47,124,'','2014-04-17 12:47:28','2014-04-17 12:47:28',1);
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_blocks`
--

DROP TABLE IF EXISTS `student_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_blocks` (
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`UserId`,`LessonId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_blocks`
--

LOCK TABLES `student_blocks` WRITE;
/*!40000 ALTER TABLE `student_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_histories`
--

DROP TABLE IF EXISTS `student_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_histories` (
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `StartDate` datetime NOT NULL,
  `ExpiryDate` datetime NOT NULL,
  `CourseFee` int(11) NOT NULL,
  `IsLike` tinyint(1) NOT NULL,
  `Blocked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`,`LessonId`,`StartDate`),
  KEY `student_history - users` (`UserId`),
  CONSTRAINT `student_history - users` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_histories`
--

LOCK TABLES `student_histories` WRITE;
/*!40000 ALTER TABLE `student_histories` DISABLE KEYS */;
INSERT INTO `student_histories` VALUES (46,124,'2014-04-17 11:29:03','2014-04-24 11:29:03',20000,1,0);
/*!40000 ALTER TABLE `student_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_tests`
--

DROP TABLE IF EXISTS `student_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_tests` (
  `UserId` int(11) NOT NULL,
  `TestId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `Point` int(11) NOT NULL,
  `Answer` varchar(50) NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`,`TestId`),
  KEY `student_test - users` (`UserId`),
  CONSTRAINT `student_test - users` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_tests`
--

LOCK TABLES `student_tests` WRITE;
/*!40000 ALTER TABLE `student_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `TagId` int(11) NOT NULL AUTO_INCREMENT,
  `LessonId` int(11) NOT NULL,
  `TagContent` varchar(200) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`TagId`)
) ENGINE=MyISAM AUTO_INCREMENT=386 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (385,125,'frgdhft','2014-04-17 15:55:28','2014-04-17 15:55:28'),(384,124,'dfshgk','2014-04-17 11:27:53','2014-04-17 11:27:53'),(380,120,'','2014-04-17 07:58:25','2014-04-17 07:58:25'),(379,120,'zxghcjkvlm','2014-04-17 07:58:25','2014-04-17 07:58:25'),(372,114,'zxcvbknm','2014-04-17 07:36:41','2014-04-17 07:36:41'),(371,113,'sadfsadf','2014-04-17 07:25:36','2014-04-17 07:25:36'),(369,111,'sdkgl;','2014-04-17 07:22:44','2014-04-17 07:22:44'),(368,110,'sdfghjkl','2014-04-17 07:16:02','2014-04-17 07:16:02'),(367,109,'kl;lhdcjvkj','2014-04-17 07:14:25','2014-04-17 07:14:25'),(365,107,'sdfgsfdg','2014-04-17 07:07:24','2014-04-17 07:07:24'),(363,105,'dfsdhjgk','2014-04-17 07:03:13','2014-04-17 07:03:13'),(359,102,'dàgjk','2014-04-17 06:57:46','2014-04-17 06:57:46'),(358,101,'djfgh','2014-04-17 06:55:17','2014-04-17 06:55:17'),(357,100,'sgdhfgh','2014-04-17 06:54:02','2014-04-17 06:54:02'),(355,99,'d','2014-04-17 06:49:22','2014-04-17 06:49:22'),(354,98,'sgdhfjkg','2014-04-17 06:46:38','2014-04-17 06:46:38'),(353,97,'shdfkl','2014-04-17 06:43:00','2014-04-17 06:43:00'),(351,95,'dsfhjgh','2014-04-16 12:17:57','2014-04-16 12:17:57'),(350,94,'sdhjfk','2014-04-16 12:09:47','2014-04-16 12:09:47'),(349,93,'sdfgdhjk','2014-04-16 12:07:48','2014-04-16 12:07:48'),(345,89,'fdasgdkhj','2014-04-16 11:59:22','2014-04-16 11:59:22'),(344,88,'','2014-04-16 11:52:40','2014-04-16 11:52:40'),(343,88,'dfsdgnfmg','2014-04-16 11:52:40','2014-04-16 11:52:40'),(342,87,'dqwjr','2014-04-16 11:48:20','2014-04-16 11:48:20'),(340,85,'dafsghrdjklk','2014-04-16 11:44:52','2014-04-16 11:44:52');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `TestId` int(11) NOT NULL AUTO_INCREMENT,
  `LessonId` int(11) NOT NULL,
  `Title` text CHARACTER SET utf8 NOT NULL,
  `SubTitle` text CHARACTER SET utf8 NOT NULL,
  `FileId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TestId`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `InitialPassword` varchar(255) NOT NULL,
  `UserType` tinyint(4) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `VerifyCodeQuestion` varchar(255) NOT NULL,
  `InitialCodeQuestion` varchar(255) NOT NULL,
  `VerifyCodeAnswer` varchar(255) NOT NULL,
  `InitialCodeAnswer` varchar(255) NOT NULL,
  `Gender` tinyint(4) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `ImageProfile` varchar(255) DEFAULT NULL,
  `IpAddress` varchar(20) DEFAULT NULL,
  `IsOnline` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `Violated` tinyint(4) DEFAULT NULL,
  `BankInfo` varchar(255) DEFAULT NULL,
  `CreditCard` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserId_UNIQUE` (`UserId`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'Admin','cc06b37d9558e740c71aab2d6f9716f88def12c1','cc06b37d9558e740c71aab2d6f9716f88def12c1',3,'Admin','1996-03-03','','','','',1,'','','',NULL,'127.0.0.1',NULL,'2014-04-17 11:28:29','2014-04-17 11:28:54',1,NULL,'',''),(45,'mrhieusd','975c267bc444991bc019c7cb9e96ab7862390771','975c267bc444991bc019c7cb9e96ab7862390771',2,'Mac Hieu','1996-04-17','0c0133dae1234c3e04edb522706a62afb9d686ca','0c0133dae1234c3e04edb522706a62afb9d686ca','0c0133dae1234c3e04edb522706a62afb9d686ca','0c0133dae1234c3e04edb522706a62afb9d686ca',NULL,'','','',NULL,'123.1.1.124',NULL,'2014-04-17 11:21:32','2014-04-17 11:36:54',1,NULL,'123456789',''),(46,'tanvn','975c267bc444991bc019c7cb9e96ab7862390771','975c267bc444991bc019c7cb9e96ab7862390771',1,'Nhat Tan','1996-04-17','','','','',1,'','','',NULL,'123.1.1.124',NULL,'2014-04-17 11:28:29','2014-04-17 16:49:56',3,NULL,'','1223523523525'),(47,'uploader','e8f05883591cacf38ca4426ce15e304c2f697808','e8f05883591cacf38ca4426ce15e304c2f697808',2,'Uploader','1996-04-17','d9d34302653945843c245f909d3b00feea84b50d','d9d34302653945843c245f909d3b00feea84b50d','d9d34302653945843c245f909d3b00feea84b50d','d9d34302653945843c245f909d3b00feea84b50d',NULL,'','','',NULL,'123.1.1.124',NULL,'2014-04-17 11:59:16','2014-04-17 14:56:44',3,NULL,'213434675687',''),(48,'admin3','984b4ef73145ada0b6da59dedd0f169898e06c5a','984b4ef73145ada0b6da59dedd0f169898e06c5a',3,'','2002-04-06','Default Question','12345678','Default Answer','12345678',1,'',NULL,'',NULL,NULL,NULL,'2014-04-21 05:09:22','2014-04-21 05:09:22',1,NULL,'',NULL);
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

-- Dump completed on 2014-04-21 11:05:09
