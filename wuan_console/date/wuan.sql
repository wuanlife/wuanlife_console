# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: wuan
# ------------------------------------------------------
# Server version 5.5.38

#
# Source for table adminlist
#

DROP TABLE IF EXISTS `adminlist`;
CREATE TABLE `adminlist` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(255) DEFAULT NULL,
  `adminpwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Dumping data for table adminlist
#

LOCK TABLES `adminlist` WRITE;
/*!40000 ALTER TABLE `adminlist` DISABLE KEYS */;
INSERT INTO `adminlist` VALUES (1,'admin','admin');
INSERT INTO `adminlist` VALUES (2,'admin1','admin1');
/*!40000 ALTER TABLE `adminlist` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table news
#

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `text1` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

#
# Dumping data for table news
#

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'2','3','第一行试试');
INSERT INTO `news` VALUES (17,'2','2','diertiao');
INSERT INTO `news` VALUES (18,'weizhi','weizhi','weozhi');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table userlist
#

DROP TABLE IF EXISTS `userlist`;
CREATE TABLE `userlist` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

#
# Dumping data for table userlist
#

LOCK TABLES `userlist` WRITE;
/*!40000 ALTER TABLE `userlist` DISABLE KEYS */;
INSERT INTO `userlist` VALUES (1,'Hello');
INSERT INTO `userlist` VALUES (2,'测试中文');
INSERT INTO `userlist` VALUES (7,'12344');
INSERT INTO `userlist` VALUES (13,'sdf');
INSERT INTO `userlist` VALUES (14,'14');
INSERT INTO `userlist` VALUES (15,'15');
INSERT INTO `userlist` VALUES (19,'ss');
INSERT INTO `userlist` VALUES (20,'admin3');
INSERT INTO `userlist` VALUES (22,'1q');
/*!40000 ALTER TABLE `userlist` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
