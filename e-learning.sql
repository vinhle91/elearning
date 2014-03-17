-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2014 at 03:09 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `e-learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `AnswerId` int(11) NOT NULL AUTO_INCREMENT,
  `QuesId` int(11) NOT NULL,
  `AnswerNumber` int(11) NOT NULL,
  `AnswerContent` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`AnswerId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=158 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`AnswerId`, `QuesId`, `AnswerNumber`, `AnswerContent`) VALUES
(157, 129, 5, '男性は３本足である。'),
(156, 129, 4, '鳥類は４本足である。'),
(155, 129, 3, '哺乳類は全て２本足である。'),
(154, 129, 2, '爬虫類は全て４本足である。'),
(153, 129, 1, '昆虫は６本足である。'),
(152, 128, 3, 'ちょうふく'),
(151, 128, 2, 'じゅうふく'),
(150, 128, 1, 'おもふく'),
(149, 127, 5, 'コムピューター'),
(148, 127, 4, 'コンピュータ'),
(147, 127, 3, 'コンプータ'),
(146, 127, 2, 'コムピューター'),
(145, 127, 1, 'コムピュータ'),
(144, 126, 6, 'ミーチング'),
(143, 126, 5, 'ミティング'),
(142, 126, 4, 'メティング'),
(141, 126, 3, 'ミッティング'),
(140, 126, 2, 'メーティング'),
(139, 126, 1, 'ミーティング');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `CatId` int(11) NOT NULL AUTO_INCREMENT,
  `CatName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CatId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CatId`, `CatName`, `created`, `modified`, `IsDeleted`) VALUES
(1, '数学', '2014-03-10 03:48:12', '2014-03-10 03:48:15', 0),
(2, '物理', '2014-03-10 00:00:00', '2014-03-10 00:00:00', 0),
(3, '化学', '2014-03-10 03:51:04', '2014-03-10 03:51:06', 0),
(4, '文学', '2014-03-10 03:51:08', '2014-03-10 03:51:11', 0),
(5, '地理', '2014-03-10 03:51:42', '2014-03-10 03:51:44', 0),
(6, '歴史', '2014-03-10 03:51:46', '2014-03-10 03:51:49', 0),
(7, ' 医学', '2014-03-10 03:52:21', '2014-03-10 03:52:24', 0),
(8, '外国語', '2014-03-10 03:52:26', '2014-03-10 03:52:29', 0),
(9, '経済と社会', '2014-03-10 03:52:46', '2014-03-10 03:52:49', 0),
(10, 'コンピュータサイエンス', '2014-03-10 03:53:07', '2014-03-10 03:53:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `CommentId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `Content` text NOT NULL,
  `created` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentId`, `UserId`, `LessonId`, `Content`, `created`, `IsDeleted`, `modified`) VALUES
(1, 20, 1, 'sDFZghjkl;?', '2014-03-17 14:48:02', 0, '2014-03-17 14:48:02'),
(2, 20, 1, 'DSFhgcjk', '2014-03-17 14:48:09', 0, '2014-03-17 14:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `ConfigId` int(11) NOT NULL AUTO_INCREMENT,
  `ConfigName` varchar(45) DEFAULT NULL,
  `ConfigValue` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`ConfigId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`ConfigId`, `ConfigName`, `ConfigValue`, `created`, `modified`) VALUES
(1, 'SessionTimeout', '36000', '2014-03-11 16:52:27', '2014-03-11 16:52:29'),
(2, 'CourseFee', '20000', '2014-03-17 00:00:00', '2014-03-17 00:00:00'),
(3, 'FailNumber', '3', '2014-03-17 00:00:00', '2014-03-17 00:00:00'),
(4, 'SharingRate', '40', '2014-03-17 00:00:00', '2014-03-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
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
  PRIMARY KEY (`FileId`),
  KEY `files - users` (`LessonId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`FileId`, `LessonId`, `FileName`, `Alias`, `FileLink`, `FileType`, `Extension`, `created`, `modified`, `IsDeleted`) VALUES
(1, 1, '', '', '/uploads/jugyou/snort-manual.pdf', 1, 'pdf', '2014-03-17 10:06:04', '2014-03-17 10:06:04', 0),
(2, 1, '', '', '/uploads/tsv/demo.tsv', 2, 'tsv', '2014-03-17 10:06:04', '2014-03-17 10:06:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

CREATE TABLE IF NOT EXISTS `ips` (
  `IpId` int(11) NOT NULL AUTO_INCREMENT,
  `IpAddress` varchar(45) DEFAULT NULL,
  `LastUsed` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`IpId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ips`
--

INSERT INTO `ips` (`IpId`, `IpAddress`, `LastUsed`, `created`, `modified`) VALUES
(1, '42.113.254.65', '2014-03-08 15:42:53', '2014-03-08 15:42:53', '2014-03-08 15:42:53');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE IF NOT EXISTS `lessons` (
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
  KEY `Lesson -  User` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`LessonId`, `Category`, `Title`, `Abstract`, `Other`, `LikeNumber`, `ViewNumber`, `UserId`, `created`, `modified`, `IsDeleted`) VALUES
(1, '4', 'Lesson 123123', 'đắd fszgxs dfdsfg sdfgasdfsdxcag áavxcbsds d ffbsd sdffbdfbsf sdfb dsfbdf sb xvc bxvcb fgsdf dhdf fsdgsd v sdb sdfgs d sdfgsd', NULL, 0, 4, 19, '2014-03-17 10:06:04', '2014-03-17 10:06:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `QuesId` int(11) NOT NULL AUTO_INCREMENT,
  `QuesNumber` int(11) NOT NULL,
  `TestId` int(11) NOT NULL,
  `QuesContent` text CHARACTER SET utf8 NOT NULL,
  `QuesAnswer` varchar(20) NOT NULL,
  `Point` int(11) NOT NULL,
  PRIMARY KEY (`QuesId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuesId`, `QuesNumber`, `TestId`, `QuesContent`, `QuesAnswer`, `Point`) VALUES
(129, 4, 28, '以下の説明で適切だと思われるものを選択しなさい。', 'S(1)', 20),
(128, 3, 28, '「重複」をひらがなで解答欄に表記しなさい。', 'S(3)', 5),
(127, 2, 28, 'computer をカタカナで表記しなさい。', 'S(4)', 5),
(126, 1, 28, 'Meeting をカタカナで表記しなさい。', 'S(1)', 10);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `ReportId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `Content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ReportId`,`UserId`,`LessonId`),
  KEY `reports - users` (`UserId`),
  KEY `reports - lessons` (`LessonId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reports`
--


-- --------------------------------------------------------

--
-- Table structure for table `student_blocks`
--

CREATE TABLE IF NOT EXISTS `student_blocks` (
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`UserId`,`LessonId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_blocks`
--


-- --------------------------------------------------------

--
-- Table structure for table `student_histories`
--

CREATE TABLE IF NOT EXISTS `student_histories` (
  `UserId` int(11) NOT NULL,
  `LessonId` int(11) NOT NULL,
  `StartDate` datetime NOT NULL,
  `ExpiryDate` datetime NOT NULL,
  `CourseFee` int(11) NOT NULL,
  `IsLike` tinyint(1) NOT NULL,
  `Blocked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`,`LessonId`,`StartDate`),
  KEY `student_history - users` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_histories`
--

INSERT INTO `student_histories` (`UserId`, `LessonId`, `StartDate`, `ExpiryDate`, `CourseFee`, `IsLike`, `Blocked`) VALUES
(20, 1, '2014-03-17 12:56:23', '2014-03-24 12:56:23', 20000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_tests`
--

CREATE TABLE IF NOT EXISTS `student_tests` (
  `UserId` int(11) NOT NULL,
  `TestId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `Point` int(11) NOT NULL,
  `Answer` varchar(50) NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`,`TestId`,`created`),
  KEY `student_test - users` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_tests`
--


-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `TagId` int(11) NOT NULL AUTO_INCREMENT,
  `LessonId` int(11) NOT NULL,
  `TagContent` varchar(200) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`TagId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=213 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`TagId`, `LessonId`, `TagContent`, `created`, `modified`) VALUES
(212, 1, 'dsfgsfdg', '2014-03-17 10:06:04', '2014-03-17 10:06:04'),
(211, 1, 'sdfgsfdg', '2014-03-17 10:06:04', '2014-03-17 10:06:04'),
(210, 1, 'dsfgsdfg', '2014-03-17 10:06:04', '2014-03-17 10:06:04'),
(209, 1, 'sgsdfg', '2014-03-17 10:06:04', '2014-03-17 10:06:04'),
(208, 143, 'tag69', '2014-03-11 09:11:44', '2014-03-11 09:11:44'),
(207, 143, 'tag4', '2014-03-11 09:11:44', '2014-03-11 09:11:44'),
(206, 143, 'tag2', '2014-03-11 09:11:44', '2014-03-11 09:11:44'),
(205, 143, 'tag1', '2014-03-11 09:11:44', '2014-03-11 09:11:44'),
(204, 142, 'asdhfj', '2014-03-11 09:10:34', '2014-03-11 09:10:34'),
(203, 141, 'asdhfj', '2014-03-11 09:10:15', '2014-03-11 09:10:15'),
(202, 140, 'asdhfj', '2014-03-11 09:00:11', '2014-03-11 09:00:11'),
(201, 139, 'asdhfj', '2014-03-11 08:59:22', '2014-03-11 08:59:22'),
(200, 138, 'asdhfj', '2014-03-11 08:56:48', '2014-03-11 08:56:48'),
(199, 137, 'asdhfj', '2014-03-11 08:53:13', '2014-03-11 08:53:13'),
(198, 136, 'asdhfj', '2014-03-11 08:52:42', '2014-03-11 08:52:42'),
(197, 135, 'tag69', '2014-03-11 08:50:36', '2014-03-11 08:50:36'),
(196, 135, 'tag4', '2014-03-11 08:50:36', '2014-03-11 08:50:36'),
(195, 135, 'tag2', '2014-03-11 08:50:36', '2014-03-11 08:50:36'),
(194, 135, 'tag1', '2014-03-11 08:50:36', '2014-03-11 08:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `TestId` int(11) NOT NULL AUTO_INCREMENT,
  `LessonId` int(11) NOT NULL,
  `Title` text CHARACTER SET utf8 NOT NULL,
  `SubTitle` text CHARACTER SET utf8 NOT NULL,
  `FileId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TestId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`TestId`, `LessonId`, `Title`, `SubTitle`, `FileId`, `created`, `modified`, `IsDeleted`) VALUES
(28, 1, 'テスト問題サンプル', '日本語テスト第３週', 0, '2014-03-17 10:06:04', '2014-03-17 10:06:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Username`, `Password`, `InitialPassword`, `UserType`, `FullName`, `Birthday`, `VerifyCodeQuestion`, `InitialCodeQuestion`, `VerifyCodeAnswer`, `InitialCodeAnswer`, `Gender`, `Address`, `Phone`, `Email`, `ImageProfile`, `IsOnline`, `created`, `modified`, `Status`, `Violated`, `BankInfo`, `CreditCard`) VALUES
(1, 'luong', '0665489b7c9162c5906567501f37c3a6cc897d67', '12345678', 3, 'Khuc Anh Minh Luong', '1991-10-12', 'ban sinh nam bao nhieu', 'ban sinh nam bao nhieu', '1991', '1991', 1, NULL, NULL, NULL, NULL, NULL, '2014-03-03 03:03:31', NULL, 1, NULL, NULL, NULL),
(19, 'mrhieusd', 'cc06b37d9558e740c71aab2d6f9716f88def12c1', '', 2, 'Mac Hieu', '1991-08-13', 'what your name', '', 'i''m hieu', '', 1, '', '', 'mrhieusd@gmail.com', NULL, NULL, '0000-00-00 00:00:00', NULL, 1, NULL, '', ''),
(20, 'tanvn', 'cc06b37d9558e740c71aab2d6f9716f88def12c1', '', 1, 'Nhat Tan', '1991-06-08', 'what your name', '', 'i''m tan', '', 1, '', '', 'tanvn@gmail.com', NULL, NULL, '0000-00-00 00:00:00', NULL, 1, NULL, '', ''),
(21, 'anhnt', '0665489b7c9162c5906567501f37c3a6cc897d67', '0665489b7c9162c5906567501f37c3a6cc897d67', 1, 'Tuan Anh', '1996-03-05', 'what your name', 'what your name', 'i''m tuan anh', 'i''m tuan anh', 1, '', '', 'anhnt@gmail.com', NULL, NULL, '0000-00-00 00:00:00', NULL, 0, NULL, '', ''),
(22, 'vinhl', 'cc06b37d9558e740c71aab2d6f9716f88def12c1', 'cc06b37d9558e740c71aab2d6f9716f88def12c1', 2, 'Le Vinh', '1991-03-20', 'what is your name', 'what is your name', 'i''m vinh', 'i''m vinh', 1, '', '0989777655', 'vinhl@gmail.com', NULL, NULL, '2014-03-05 12:59:20', '2014-03-05 12:59:20', 0, NULL, '', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `UserId` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files - users` FOREIGN KEY (`LessonId`) REFERENCES `lessons` (`LessonId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `Lesson -  User` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports - lessons` FOREIGN KEY (`LessonId`) REFERENCES `lessons` (`LessonId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reports - users` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_histories`
--
ALTER TABLE `student_histories`
  ADD CONSTRAINT `student_history - users` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `student_tests`
--
ALTER TABLE `student_tests`
  ADD CONSTRAINT `student_test - users` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
