-- MySQL dump 10.13  Distrib 5.5.48, for Linux (x86_64)
--
-- Host: localhost    Database: yunos
-- ------------------------------------------------------
-- Server version	5.5.48-log

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
-- Table structure for table `yunos_account`
--

DROP TABLE IF EXISTS `yunos_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yunos_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) DEFAULT '' COMMENT '账号',
  `passwd` varchar(32) DEFAULT '' COMMENT '密码',
  `salt` char(5) DEFAULT '' COMMENT '加盐',
  `role` int(11) unsigned DEFAULT '0' COMMENT '角色',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `role_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yunos_account`
--

LOCK TABLES `yunos_account` WRITE;
/*!40000 ALTER TABLE `yunos_account` DISABLE KEYS */;
INSERT INTO `yunos_account` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','',1,1492427086,1492845821,'系统管理员'),(2,'test','e10adc3949ba59abbe56e057f20f883e','',3,1492845846,1492845846,'经理');
/*!40000 ALTER TABLE `yunos_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yunos_category`
--

DROP TABLE IF EXISTS `yunos_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yunos_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '' COMMENT '栏目名称',
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT '父栏目id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yunos_category`
--

LOCK TABLES `yunos_category` WRITE;
/*!40000 ALTER TABLE `yunos_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `yunos_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yunos_privilege`
--

DROP TABLE IF EXISTS `yunos_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yunos_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '' COMMENT '权限名称',
  `module_name` varchar(50) DEFAULT '' COMMENT '模块名称',
  `controller_name` varchar(50) DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(50) DEFAULT '' COMMENT '方法名称',
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT '父id',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yunos_privilege`
--

LOCK TABLES `yunos_privilege` WRITE;
/*!40000 ALTER TABLE `yunos_privilege` DISABLE KEYS */;
INSERT INTO `yunos_privilege` VALUES (1,'管理员模块','null','null','null',0,1492425460,1492425460),(2,'权限列表 ','index','privilege','index',1,1492425524,1492425524),(4,'添加权限','index','privilege','add,addview',2,1492425900,1493004468),(9,'添加角色','index','role','add,addview',8,1492845371,1493004482),(6,'修改权限','index','privilege','save,saveview',2,1492425959,1493004474),(7,'删除权限','index','privilege','del',2,1492425992,1492425992),(8,'角色列表','index','role','index',1,1492426044,1492426044),(10,'修改角色','index','role','save,saveview',8,1492845432,1493004489),(11,'删除角色','index','role','del',8,1492845503,1492845576),(12,'帐号列表','index','account','index',1,1492845535,1492845535),(13,'添加帐号','index','account','add,addview',12,1492845612,1493004496),(14,'修改帐号','index','account','save,saveview',12,1492845655,1493004502),(15,'删除帐号','index','account','del',12,1492845684,1492845684);
/*!40000 ALTER TABLE `yunos_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yunos_role`
--

DROP TABLE IF EXISTS `yunos_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yunos_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `privilege_list` varchar(200) DEFAULT ',' COMMENT '权限列表',
  `name` varchar(50) DEFAULT '' COMMENT '角色名称',
  `sort` smallint(6) unsigned DEFAULT '0' COMMENT '排序',
  `is_on` bit(1) DEFAULT b'0' COMMENT '是否启用',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `privilege_text` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yunos_role`
--

LOCK TABLES `yunos_role` WRITE;
/*!40000 ALTER TABLE `yunos_role` DISABLE KEYS */;
INSERT INTO `yunos_role` VALUES (1,'*','系统管理员',0,'\0',1492587124,1492587124,'系统管理员'),(3,'1,2,4,8,10','经理',0,'\0',1492845735,1492845735,'管理员模块,权限列表 ,添加权限,角色列表,修改角色');
/*!40000 ALTER TABLE `yunos_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'yunos'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-24 11:34:41
