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
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (252,149,5,'男性は３本足である。'),(251,149,4,'鳥類は４本足である。'),(250,149,3,'哺乳類は全て２本足である。'),(249,149,2,'爬虫類は全て４本足である。'),(248,149,1,'昆虫は６本足である。'),(247,148,3,'ちょうふく'),(246,148,2,'じゅうふく'),(245,148,1,'おもふく'),(244,147,5,'コムピューター'),(243,147,4,'コンピュータ'),(242,147,3,'コンプータ'),(241,147,2,'コムピューター'),(240,147,1,'コムピュータ'),(239,146,6,'ミーチング'),(238,146,5,'ミティング'),(237,146,4,'メティング'),(236,146,3,'ミッティング'),(235,146,2,'メーティング'),(234,146,1,'ミーティング');
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
  `CatName` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CatId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
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
INSERT INTO `comments` VALUES (1,67,2,'fasdfasdf','2014-04-24 18:50:20',0,'2014-04-24 18:50:20');
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
  `ConfigValue` int(11) DEFAULT NULL,
  `ConfigUnit` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`ConfigId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
INSERT INTO `configs` VALUES (1,'session_timeout',3600,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'auto_backup',36000,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'login_fail',3,'回','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'lock_time',5,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'lesson_cost',20000,'VND','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'test_time',1800,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'share_rate',40,'%','0000-00-00 00:00:00','0000-00-00 00:00:00');
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
  `IsBlocked` int(11) DEFAULT '0',
  PRIMARY KEY (`FileId`),
  KEY `files - users` (`LessonId`),
  CONSTRAINT `files - users` FOREIGN KEY (`LessonId`) REFERENCES `lessons` (`LessonId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,1,'dsonlinecohb20131.pdf','','/uploads/jugyou/File-1-1-414992.pdf',1,'pdf','2014-04-24 18:34:51','2014-04-24 18:34:51',0,0),(2,1,'allpass1.jpg','','/uploads/jugyou/File-1-2-64771.jpg',1,'jpg','2014-04-24 18:34:51','2014-04-24 18:34:51',0,0),(3,2,'allpass1.jpg','','/uploads/jugyou/File-2-1-64771.jpg',1,'jpg','2014-04-24 18:49:49','2014-04-24 18:49:49',0,0),(4,2,'dsonlinecohb20131.pdf','','/uploads/jugyou/File-2-2-414992.pdf',1,'pdf','2014-04-24 18:49:49','2014-04-24 18:49:49',0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips`
--

LOCK TABLES `ips` WRITE;
/*!40000 ALTER TABLE `ips` DISABLE KEYS */;
INSERT INTO `ips` VALUES (5,50,'127.0.0.1',NULL,'2014-04-18 09:40:50','2014-04-18 09:40:50'),(6,63,'127.0.0.1',NULL,'2014-04-21 11:11:01','2014-04-21 11:11:01'),(7,63,'99.99.99.88',NULL,'2014-04-21 11:15:13','2014-04-21 11:15:13'),(8,50,'88.8.8.8',NULL,'2014-04-23 18:51:25','2014-04-23 18:51:25');
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
  `IsBlocked` int(11) DEFAULT '0',
  PRIMARY KEY (`LessonId`),
  KEY `Lesson -  User` (`UserId`),
  CONSTRAINT `Lesson -  User` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (1,'','ABC','ABC',NULL,1,1,65,'2014-04-24 18:34:51','2014-04-24 18:34:51',0,0),(2,'','ABC','ABC',NULL,0,3,67,'2014-04-24 18:49:49','2014-04-24 18:49:49',0,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,67,1,'','2014-04-24 18:46:17','2014-04-24 18:46:17',1);
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
INSERT INTO `student_histories` VALUES (66,1,'2014-04-24 18:41:56','2014-05-01 18:41:56',20000,1,0),(66,2,'2014-04-25 08:25:09','1970-01-01 01:00:00',20000,0,0),(66,2,'2014-04-25 08:26:15','1970-01-01 01:00:00',20000,0,0),(66,2,'2014-04-25 08:30:14','1970-01-01 01:00:00',20000,0,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=421 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (419,1,'english','2014-04-24 18:34:51','2014-04-24 18:34:51'),(420,2,'english','2014-04-24 18:49:49','2014-04-24 18:49:49');
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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (50,'student1','3ce93cdfb8d0a198d51ff487f2125e12d3b984ae','39a6c8cd3fb6d38bccc4e29d243e56bc02b7e4d2',3,'Super Admin','1996-02-05','','','','',0,'','','admin@gmail.comasda',NULL,NULL,NULL,'2014-04-18 07:28:40','2014-04-18 07:28:40',1,NULL,'11223344556611','312421354123'),(55,'mrhieusd','0c0133dae1234c3e04edb522706a62afb9d686ca','0c0133dae1234c3e04edb522706a62afb9d686ca',2,'Mac Hieu','1996-04-21','f3b577db70ac2a1d5723abd8cd0296b216d82745','f3b577db70ac2a1d5723abd8cd0296b216d82745','f3b577db70ac2a1d5723abd8cd0296b216d82745','f3b577db70ac2a1d5723abd8cd0296b216d82745',1,'','','',NULL,'123.1.1.124',NULL,'2014-04-21 04:49:15','2014-04-21 05:14:53',1,NULL,'12314345234234','2453523452345'),(56,'tanvn','975c267bc444991bc019c7cb9e96ab7862390771','975c267bc444991bc019c7cb9e96ab7862390771',1,'Nhat Tan','1996-04-21','','','','',1,'','','',NULL,'123.1.1.124',NULL,'2014-04-21 05:05:57','2014-04-21 05:13:03',1,NULL,'','12345667'),(57,'Teacher01','f2d45cc9062c78e8c468c90cd7c5860b5db8d9ba','f2d45cc9062c78e8c468c90cd7c5860b5db8d9ba',2,'Mac Hieu','1996-04-21','831adc7a11ec05e39a2db74ef7ea1d1fdfc4707b','831adc7a11ec05e39a2db74ef7ea1d1fdfc4707b','a6fc2996628d2fb7c37bf9fa0666a2464bab0315','a6fc2996628d2fb7c37bf9fa0666a2464bab0315',0,'','','',NULL,'123.1.1.124',NULL,'2014-04-21 05:23:40','2014-04-24 18:31:58',1,NULL,'','431241234'),(58,'Teacher02','8c15a5568a2d529f43a583b84885c1d8fa3c17fb','8c15a5568a2d529f43a583b84885c1d8fa3c17fb',2,'Nhat Tan01','1991-08-13','fae27fc8e9ec0c95e50d9dc0686ba986ba64752a','fae27fc8e9ec0c95e50d9dc0686ba986ba64752a','f832cec62a3018f1a9a036d15b4b9d557b14c57b','f832cec62a3018f1a9a036d15b4b9d557b14c57b',2,'','','tanvn@gmail.com',NULL,'123.1.1.124',NULL,'2014-04-21 05:25:56','2014-04-21 05:47:15',1,NULL,'2345234452345234',''),(59,'Teacher03','cc170ce8800e17445868da3a267173c9b54df82c','cc170ce8800e17445868da3a267173c9b54df82c',2,'Le Vinh','1996-04-21','c46a776264ebba19c70e35f2b320cfcc911e7e6a','c46a776264ebba19c70e35f2b320cfcc911e7e6a','33cf74cb1bf19010b54f1126d2f50e9fb0ba9faa','33cf74cb1bf19010b54f1126d2f50e9fb0ba9faa',1,'','','',NULL,NULL,NULL,'2014-04-21 05:26:31','2014-04-21 05:26:31',2,NULL,'2536478',''),(60,'Student01','e54b98817b7c69c9153fa917713304799c28130b','db30de4bf2e151790518301a0b2bc445a05fd171',1,'Tuan Anh','1996-04-21','','','','',1,'','','',NULL,'123.1.1.124',NULL,'2014-04-21 05:27:38','2014-04-21 05:50:14',1,NULL,'','235434523452'),(61,'Student02','a8947fc639b5d079fface5b075617c30ec6c1568','a8947fc639b5d079fface5b075617c30ec6c1568',1,'Dinh Quan','1996-04-21','','','','',NULL,'','','',NULL,'123.1.1.124',NULL,'2014-04-21 05:28:08','2014-04-21 05:50:29',1,NULL,'','215234534'),(62,'Student03','f26604f641e43887e0e67b2a6efece3f605fd425','f26604f641e43887e0e67b2a6efece3f605fd425',1,'Minh Luong','1996-04-21','','','','',NULL,'','','',NULL,NULL,NULL,'2014-04-21 05:28:40','2014-04-21 05:28:40',1,NULL,'','43535243'),(63,'Admin00','8d5aae31937df87c344d0e77e42806c842132524','8d5aae31937df87c344d0e77e42806c842132524',3,NULL,NULL,'Default Question','12345678','Default Answer','12345678',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-04-21 11:10:24','2014-04-21 11:10:24',1,NULL,NULL,NULL),(64,'admin01','03f083f44e673ea68fcbef92cd35b8e2cd54a8df','03f083f44e673ea68fcbef92cd35b8e2cd54a8df',3,NULL,NULL,'Default Question','12345678','Default Answer','12345678',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-04-21 18:33:46','2014-04-21 18:33:46',1,NULL,NULL,NULL),(65,'teacher','4b9251b8987d4d0da115f39e74ca671843a9dcbb','4b9251b8987d4d0da115f39e74ca671843a9dcbb',2,'123','1996-04-24','bc74b655059e9f0605dbf3527408e30d0dc4887f','bc74b655059e9f0605dbf3527408e30d0dc4887f','bc74b655059e9f0605dbf3527408e30d0dc4887f','bc74b655059e9f0605dbf3527408e30d0dc4887f',NULL,'','','',NULL,'123.1.1.124',NULL,'2014-04-24 18:33:17','2014-04-24 18:33:46',1,NULL,'1234567891234567891234567891',''),(66,'student','21e7f43976c3dc3814ca97c76fe48342b5e1be7f','21e7f43976c3dc3814ca97c76fe48342b5e1be7f',1,'321','1996-04-24','','','','',NULL,'','','',NULL,NULL,NULL,'2014-04-24 18:39:22','2014-04-24 18:39:22',1,NULL,'','123456789123456789'),(67,'teacher22','9a2f1643766375af3e07c3b77d3d5c0806048949','9a2f1643766375af3e07c3b77d3d5c0806048949',2,'123','1996-04-24','3f5dad5730d6b106246a79a0cc44c66fbd8f1746','3f5dad5730d6b106246a79a0cc44c66fbd8f1746','3f5dad5730d6b106246a79a0cc44c66fbd8f1746','3f5dad5730d6b106246a79a0cc44c66fbd8f1746',NULL,'','','',NULL,'123.1.1.124',NULL,'2014-04-24 18:45:20','2014-04-24 18:45:44',1,NULL,'1234567891234567891234567891','123456789123456789'),(68,'teachera1','e010af68afd289aabacb2fbc01bb3c7c61f6f412','e010af68afd289aabacb2fbc01bb3c7c61f6f412',2,'dinh quan','1996-04-25','c51af8b519a9f00c68d11b10795db3df896af5ee','c51af8b519a9f00c68d11b10795db3df896af5ee','c22f788d6fae7c4b151cc618bdc7a4feb278ca66','c22f788d6fae7c4b151cc618bdc7a4feb278ca66',NULL,'','','',NULL,'123.1.1.124',NULL,'2014-04-25 10:08:03','2014-04-25 10:21:52',1,NULL,'0123456789012345678901234567','1234567890123456789012345678');
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

-- Dump completed on 2014-04-25 16:07:03
