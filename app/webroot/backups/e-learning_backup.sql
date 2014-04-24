-- MySQL dump 10.13  Distrib 5.5.34, for Win32 (x86)
--
-- Host: localhost    Database: e-learning
-- ------------------------------------------------------
-- Server version	5.5.25

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
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,1,1,'ミーティング'),(2,1,2,'メーティング'),(3,1,3,'ミッティング'),(4,1,4,'メティング'),(5,1,5,'ミティング'),(6,1,6,'ミーチング'),(7,2,1,'コムピュータ'),(8,2,2,'コムピューター'),(9,2,3,'コンプータ'),(10,2,4,'コンピュータ'),(11,2,5,'コムピューター'),(12,3,1,'おもふく'),(13,3,2,'じゅうふく'),(14,3,3,'ちょうふく'),(15,4,1,'昆虫は６本足である。'),(16,4,2,'爬虫類は全て４本足である。'),(17,4,3,'哺乳類は全て２本足である。'),(18,4,4,'鳥類は４本足である。'),(19,4,5,'男性は３本足である。'),(20,5,1,'ミーティング'),(21,5,2,'メーティング'),(22,5,3,'ミッティング'),(23,5,4,'メティング'),(24,5,5,'ミティング'),(25,5,6,'ミーチング'),(26,6,1,'コムピュータ'),(27,6,2,'コムピューター'),(28,6,3,'コンプータ'),(29,6,4,'コンピュータ'),(30,6,5,'コムピューター'),(31,7,1,'おもふく'),(32,7,2,'じゅうふく'),(33,7,3,'ちょうふく'),(34,8,1,'昆虫は６本足である。'),(35,8,2,'爬虫類は全て４本足である。'),(36,8,3,'哺乳類は全て２本足である。'),(37,8,4,'鳥類は４本足である。'),(38,8,5,'男性は３本足である。'),(39,9,1,'外で野球やかくれんぼなど'),(40,9,2,'外で昆虫採集など'),(41,9,3,'家でお絵かき、おままごとなど'),(42,9,4,'友達と一緒にいろんなことを'),(43,10,1,'超アウトドア'),(44,10,2,'どちらかというとアウトドア'),(45,10,3,'どちらかというとインドア'),(46,10,4,'超インドア'),(47,11,1,'世界で活躍するスポーツ選手など'),(48,11,2,'自分の実力で大金を稼ぎだす経営者'),(49,11,3,'知的で頭のいい文化人'),(50,11,4,'やさしくて誰からも好かれている人'),(51,12,1,'棄権する'),(52,12,2,'とりあえず休む'),(53,12,3,'自分を騙し騙し走りつづける'),(54,12,4,'気合だけで最後まで走りぬく'),(55,13,1,'１か月間、金がない'),(56,13,2,'１か月間、野宿する'),(57,13,3,'１か月間、誰とも喋らない'),(58,13,4,'１か月間、ごはんにおかずがない'),(59,14,1,'お金'),(60,14,2,'時間'),(61,14,3,'愛'),(62,14,4,'目的'),(63,15,1,'とりあえず連絡を待つ'),(64,15,2,'とりあえず他の親戚に様子を聞く'),(65,15,3,'とりあえず駆けつける'),(66,15,4,'何もしない'),(67,16,1,'遠まわしに断わる'),(68,16,2,'はっきり断わる'),(69,16,3,'とりあえずつきあってみる'),(70,16,4,'友達から始めようと言う'),(71,17,1,'才能'),(72,17,2,'体力'),(73,17,3,'自分の道'),(74,17,4,'何も望んじゃいない'),(75,18,1,'畳の上で家族に見守れて大往生'),(76,18,2,'思いがけない不慮の事故'),(77,18,3,'晩年自殺'),(78,18,4,'世界破壊で地上の大半の人と共に死ぬ');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
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
INSERT INTO `configs` VALUES (1,'session_timeout',3600,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'auto_backup',36000,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'login_fail',3,'回','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'lock_time',10,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'lesson_cost',20000,'VND','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'test_time',7,'seconds','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'share_rate',50,'%','0000-00-00 00:00:00','0000-00-00 00:00:00');
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
  `Alias` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (9,75,'NTD01-1.mp4','','/uploads/jugyou/File-75-1-4015906.mp4',1,'mp4','2014-04-24 17:24:26','2014-04-24 17:24:26',0,0),(10,76,'NTD07-1.pdf','','/uploads/jugyou/File-76-1-13637.pdf',1,'pdf','2014-04-24 17:25:23','2014-04-24 17:25:23',0,0),(11,76,'NTD04-1.jpg','','/uploads/jugyou/File-76-2-4915.jpg',1,'jpg','2014-04-24 17:25:23','2014-04-24 17:25:23',0,0),(12,76,'NTD08-1.tsv','','/uploads/tsv/Test-76-1-1273.tsv',2,'tsv','2014-04-24 17:25:23','2014-04-24 17:25:23',0,0),(13,77,'NTD02-1.mp3','','/uploads/jugyou/File-77-1-749696.mp3',1,'mp3','2014-04-24 17:25:54','2014-04-24 17:25:54',0,0),(14,77,'NTD03-1.wav','','/uploads/jugyou/File-77-2-267458.wav',1,'wav','2014-04-24 17:25:55','2014-04-24 17:25:55',0,0),(15,77,'NTD08-1.tsv','','/uploads/tsv/Test-77-1-1273.tsv',2,'tsv','2014-04-24 17:25:55','2014-04-24 17:25:55',0,0),(16,77,'NTD08-2.tsv','','/uploads/tsv/Test-77-2-2911.tsv',2,'tsv','2014-04-24 17:25:55','2014-04-24 17:25:55',0,0),(17,78,'NTD07-1.pdf',NULL,'/uploads/jugyou/File-78-1-13637.pdf',1,'pdf','2014-04-24 22:43:58','2014-04-24 22:43:58',0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips`
--

LOCK TABLES `ips` WRITE;
/*!40000 ALTER TABLE `ips` DISABLE KEYS */;
INSERT INTO `ips` VALUES (5,63,'127.0.0.1',NULL,'2014-04-18 09:40:50','2014-04-18 09:40:50'),(11,73,'88.88.88.88',NULL,'2014-04-22 03:57:28','2014-04-22 03:57:28'),(12,74,'127.0.0.1',NULL,'2014-04-22 04:02:15','2014-04-22 04:02:15');
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
  `Category` varchar(255) DEFAULT NULL,
  `Title` text,
  `Abstract` text,
  `Other` text,
  `LikeNumber` int(11) DEFAULT '0',
  `ViewNumber` int(11) NOT NULL DEFAULT '0',
  `UserId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  `IsBlocked` int(11) DEFAULT '0',
  `lessonscol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`LessonId`),
  KEY `Lesson -  User` (`UserId`),
  CONSTRAINT `Lesson -  User` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (75,'','dasgsadg','sdgsfg',NULL,0,0,76,'2014-04-24 17:16:24','2014-04-24 17:16:24',0,0,NULL),(76,'','dsgfsagd','sgasg',NULL,0,0,76,'2014-04-24 17:25:23','2014-04-24 17:25:23',0,0,NULL),(77,'','fnhsdh','sdgfsdfg',NULL,0,0,76,'2014-04-24 17:25:54','2014-04-24 17:25:54',0,0,NULL),(78,NULL,'sample','sample mota',NULL,0,0,82,'2014-04-24 22:43:58','2014-04-24 22:43:58',0,0,NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,1,'Meeting をカタカナで表記しなさい。','S(1)',10),(2,2,1,'computer をカタカナで表記しなさい。','S(4)',5),(3,3,1,'「重複」をひらがなで解答欄に表記しなさい。','S(3)',5),(4,4,1,'以下の説明で適切なものを選択しなさい。','S(1)',20),(5,1,2,'Meeting をカタカナで表記しなさい。','S(1)',10),(6,2,2,'computer をカタカナで表記しなさい。','S(4)',5),(7,3,2,'「重複」をひらがなで解答欄に表記しなさい。','S(3)',5),(8,4,2,'以下の説明で適切なものを選択しなさい。','S(1)',20),(9,1,3,'子供時代、あなたがよくしていた遊びは？','S(1)',4),(10,2,3,'あなたはインドア派？　アウトドア派？','S(4)',4),(11,3,3,'あなたが憧れるのはどんな人物？','S(1)',5),(12,4,3,'長距離走の途中、腹痛に見舞われました。どうする？','S(2)',8),(13,5,3,'次のうち、どれなら耐えられそう？','S(4)',10),(14,6,3,'あなたにとって大切なものは','S(1)',9),(15,7,3,'遠方の親戚が危篤に陥りました。さて、どうする？','S(2)',8),(16,8,3,'あまり好みのタイプではない相手から告白されました。どうする？','S(3)',4),(17,9,3,'あなたがいま、求めているものはなんでしょう？','S(2)',6),(18,10,3,'あなたの理想の死に方は？','S(1)',5);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (9,75,'sdfgsdfg','2014-04-24 17:24:27','2014-04-24 17:24:27'),(10,76,'sgasdgasdg','2014-04-24 17:25:23','2014-04-24 17:25:23'),(11,77,'dsfgsdfgs','2014-04-24 17:25:54','2014-04-24 17:25:54'),(12,78,'sample','2014-04-24 22:43:58','2014-04-24 22:43:58');
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES (1,76,'テスト問題サンプル','日本語テスト第３週',12,'2014-04-24 17:25:23','2014-04-24 17:25:23',0),(2,77,'テスト問題サンプル','日本語テスト第３週',15,'2014-04-24 17:25:55','2014-04-24 17:25:55',0),(3,77,'テスト問題サンプル・固定・０１・・・正常０１','PTFX01-N01',16,'2014-04-24 17:25:55','2014-04-24 17:25:55',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (63,'Admin00','8d5aae31937df87c344d0e77e42806c842132524','8d5aae31937df87c344d0e77e42806c842132524',3,NULL,NULL,'Default Question','12345678','Default Answer','12345678',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-04-21 11:10:24','2014-04-21 11:10:24',1,NULL,NULL,NULL),(76,'Teacher01','f2d45cc9062c78e8c468c90cd7c5860b5db8d9ba','f2d45cc9062c78e8c468c90cd7c5860b5db8d9ba',2,'Mac Hieu01','1991-08-13','4f463a55b2b97343709818b611c1ecac9492ac97','4f463a55b2b97343709818b611c1ecac9492ac97','a6fc2996628d2fb7c37bf9fa0666a2464bab0315','a6fc2996628d2fb7c37bf9fa0666a2464bab0315',1,'','','',NULL,'123.1.1.124',NULL,'2014-04-22 04:13:20','2014-04-24 14:43:25',1,NULL,'1234567890987654321123456789',''),(79,'Student01','e54b98817b7c69c9153fa917713304799c28130b','db30de4bf2e151790518301a0b2bc445a05fd171',1,'Tuan Anh','1996-04-22','','','','',NULL,'','','',NULL,NULL,NULL,'2014-04-22 04:17:59','2014-04-22 04:17:59',1,NULL,'','123456789987654321'),(82,'teacher','4b9251b8987d4d0da115f39e74ca671843a9dcbb','4b9251b8987d4d0da115f39e74ca671843a9dcbb',2,'teacher','1996-04-24','c1a64d34202c71ae4e2cac738c1b69d5381cfbad','c1a64d34202c71ae4e2cac738c1b69d5381cfbad','c1a64d34202c71ae4e2cac738c1b69d5381cfbad','c1a64d34202c71ae4e2cac738c1b69d5381cfbad',NULL,'','','',NULL,'123.1.1.124',NULL,'2014-04-24 22:39:51','2014-04-24 22:40:32',1,NULL,'1234567891234567891234567890','');
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

-- Dump completed on 2014-04-24 23:57:53
