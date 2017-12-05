-- MySQL dump 10.13  Distrib 5.7.20, for osx10.12 (x86_64)
--
-- Host: localhost    Database: shopping_mall
-- ------------------------------------------------------
-- Server version	5.7.20

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
-- Table structure for table `cat`
--

DROP TABLE IF EXISTS `cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat`
--

LOCK TABLES `cat` WRITE;
/*!40000 ALTER TABLE `cat` DISABLE KEYS */;
INSERT INTO `cat` VALUES (1,'手机',1),(4,'服装',1),(6,'家具',1),(7,'户外用品',1),(8,'家居',1),(10,'可乐',1),(11,'读书',1),(12,'删掉',1),(13,'是多少',1),(14,'湿哒哒',1),(15,'啥的',1),(16,'方法',1),(17,'公告',1);
/*!40000 ALTER TABLE `cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `cat_id` varchar(255) NOT NULL,
  `des` varchar(255) DEFAULT NULL,
  `count_s` int(11) DEFAULT NULL,
  `new` int(1) NOT NULL DEFAULT '0',
  `hot` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'小米手机','999','1','keyi',100,0,1),(2,'华为手机','1499','1','真的棒',100,0,0),(3,'迷你超短裙','199','1','真的棒',100,0,0),(4,'安全裤','99','1','真的棒',100,0,0),(5,'皮手套','188','1','暖暖的',99,0,0),(10,'拳套','2499','7','ok',120,0,1),(15,'金刚','22','1','读书',22,0,0),(16,'dsa','22','4','sd',22,0,0),(17,'啥的啥的','22','4','读书',22,0,0),(18,'撒地方','22','6','33',22,0,0),(19,'3大师傅','22','6','34',233,0,0),(20,'方法方法是','2324','6','撒地方',42,0,0),(21,'sdsd','24','4','ds',33,0,0);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `permission` varchar(64) DEFAULT 'user',
  `data` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'wangye','f938a0dd41abb1ba7b16eeb51bc53efb','admin',NULL),(2,'wanghan','ad8481edf9b752a721e372504fafa2e7','user',NULL),(4,'wangjia','1c2b80c64d745ed750690d5b6283d844','user',NULL),(5,'xiaohai','70cd17fb87e371cab4f0cd915f9c335e','user',NULL),(6,'wang','5441b94bc657a691900c22aaf12dfe82','user',NULL),(7,'wanqian','361b81797a117aecf94eed8c9dea4da3','user',NULL);
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

-- Dump completed on 2017-12-05 14:56:53
