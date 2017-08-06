-- MySQL dump 10.13  Distrib 5.7.15, for Win64 (x86_64)
--
-- Host: localhost    Database: cang7
-- ------------------------------------------------------
-- Server version	5.7.15-log

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

DROP SCHEMA IF EXISTS `cang7`;
CREATE SCHEMA IF NOT EXISTS `cang7` DEFAULT CHARACTER SET UTF8;
USE `cang7`;
--
-- Table structure for table `twms_backup`
--
DROP TABLE IF EXISTS `twms_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_backup` (
  `back_id` int(11) NOT NULL AUTO_INCREMENT,
  `back_name` varchar(50) DEFAULT NULL,
  `back_path` varchar(100) DEFAULT NULL,
  `back_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`back_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_backup`
--

LOCK TABLES `twms_backup` WRITE;
/*!40000 ALTER TABLE `twms_backup` DISABLE KEYS */;
/*!40000 ALTER TABLE `twms_backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_guest`
--

DROP TABLE IF EXISTS `twms_guest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_guest` (
  `gust_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gust_name` varchar(15) DEFAULT NULL,
  `gust_sn` varchar(15) NOT NULL,
  `gust_cate` varchar(20) NOT NULL,
  `way_pay` varchar(20) NOT NULL,
  `way_out` varchar(20) NOT NULL,
  `form_valid` int(10) NOT NULL,
  `gust_comfullname` varchar(50) DEFAULT NULL,
  `gust_address` varchar(50) DEFAULT NULL,
  `gust_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`gust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_guest`
--

LOCK TABLES `twms_guest` WRITE;
/*!40000 ALTER TABLE `twms_guest` DISABLE KEYS */;
INSERT INTO `twms_guest` VALUES (2,'四川新兴格力电器有限责任公司','XXGL','','','',5,NULL,NULL,NULL);
/*!40000 ALTER TABLE `twms_guest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_guest_cate`
--

DROP TABLE IF EXISTS `twms_guest_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_guest_cate` (
  `gust_cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gust_cate_name` varchar(15) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`gust_cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_guest_cate`
--

LOCK TABLES `twms_guest_cate` WRITE;
/*!40000 ALTER TABLE `twms_guest_cate` DISABLE KEYS */;
INSERT INTO `twms_guest_cate` VALUES (5,'家电类客户',0),(6,'第三方物流公司',0),(7,'商场超市',0),(8,'酒水类客户',0),(15,'test',NULL),(16,'建材类客户',NULL);
/*!40000 ALTER TABLE `twms_guest_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_instore_main`
--

DROP TABLE IF EXISTS `twms_instore_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_instore_main` (
  `ism_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ism_sn` varchar(30) DEFAULT NULL,
  `ism_operator` varchar(15) DEFAULT NULL,
  `ism_writer` varchar(15) DEFAULT NULL,
  `ism_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ism_phone` varchar(20) DEFAULT NULL,
  `ism_contactor` varchar(15) DEFAULT NULL,
  `ism_sellerunit` varchar(30) DEFAULT NULL,
  `ism_danju_no` varchar(20) NOT NULL,
  `ism_danju_date` timestamp NULL DEFAULT NULL,
  `ism_danju_del` int(2) NOT NULL,
  `ism_carry` varchar(20) NOT NULL,
  `ism_car_no` varchar(10) NOT NULL,
  `ism_status` int(2) NOT NULL,
  `ism_status_time` timestamp NULL DEFAULT NULL,
  `ism_total` float(10,0) DEFAULT NULL,
  `ism_remark` varchar(600) NOT NULL,
  `ism_reviwer` varchar(15) DEFAULT NULL,
  `ism_reviwer_time` timestamp NULL DEFAULT NULL,
  `ism_submiter` varchar(15) DEFAULT NULL,
  `ism_submit_time` timestamp NULL DEFAULT NULL,
  `ism_rollbacker` varchar(15) DEFAULT NULL,
  `ism_rollback_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ism_id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_instore_main`
--

LOCK TABLES `twms_instore_main` WRITE;
/*!40000 ALTER TABLE `twms_instore_main` DISABLE KEYS */;
INSERT INTO `twms_instore_main` VALUES (29,'IN-20161211-111157-812','杨延报','谢江维','2016-12-11 03:17:50','皖N85043',NULL,'四川新兴格力电器有限责任公司','SLS230160934','2016-11-29 16:00:00',0,'吴明书','',1,'2016-12-11 07:12:48',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:46',NULL,NULL),(30,'IN-20161211-111803-738','杨延报','谢江维','2016-12-11 03:18:49','皖N85043',NULL,'四川新兴格力电器有限责任公司','SLS230160797','2016-11-29 16:00:00',0,'吴明书','',1,'2016-12-11 07:13:36',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:44',NULL,NULL),(31,'IN-20161211-111855-830','杨延报','谢江维','2016-12-11 03:19:50','皖N85043',NULL,'四川新兴格力电器有限责任公司','SLS230160855','2016-11-29 16:00:00',0,'吴明书','',1,'2016-12-11 07:13:54',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:43',NULL,NULL),(32,'IN-20161211-111954-326','杨延报','谢江维','2016-12-11 03:20:47','皖N97801',NULL,'四川新兴格力电器有限责任公司','SLS230161013','2016-11-29 16:00:00',0,'吴明书','',1,'2016-12-11 07:14:16',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:41',NULL,NULL),(33,'IN-20161211-112049-741','杨延报','谢江维','2016-12-11 03:21:29','皖N89933',NULL,'四川新兴格力电器有限责任公司','SLS230161012','2016-11-29 16:00:00',0,'吴明书','',1,'2016-12-11 07:14:35',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:40',NULL,NULL),(34,'IN-20161211-113724-456','杨延报','谢江维','2016-12-11 03:38:31','皖KM2890',NULL,'四川新兴格力电器有限责任公司','SLS210459373','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:15:39',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:39',NULL,NULL),(35,'IN-20161211-113836-610','杨延报','谢江维','2016-12-11 03:39:14','皖KM2890',NULL,'四川新兴格力电器有限责任公司','SLS210457498','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:16:06',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:37',NULL,NULL),(36,'IN-20161211-113926-925','杨延报','谢江维','2016-12-11 03:40:13','皖KM2890',NULL,'四川新兴格力电器有限责任公司','SLS210459370','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:16:38',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:36',NULL,NULL),(37,'IN-20161211-114019-306','杨延报','谢江维','2016-12-11 03:40:58','皖KM2890',NULL,'四川新兴格力电器有限责任公司','SLS210454282','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:17:01',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:34',NULL,NULL),(38,'IN-20161211-114102-255','杨延报','谢江维','2016-12-11 03:41:34','皖KM2890',NULL,'四川新兴格力电器有限责任公司','SLS210459371','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:17:23',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:32',NULL,NULL),(39,'IN-20161211-114146-553','杨延报','谢江维','2016-12-11 03:42:28','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459375','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:17:43',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:31',NULL,NULL),(40,'IN-20161211-114238-168','杨延报','谢江维','2016-12-11 03:43:17','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459106','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:18:06',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:29',NULL,NULL),(41,'IN-20161211-114325-914','杨延报','谢江维','2016-12-11 03:44:04','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459369','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:18:25',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:28',NULL,NULL),(42,'IN-20161211-114408-627','杨延报','谢江维','2016-12-11 03:44:46','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459581','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:18:46',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:26',NULL,NULL),(43,'IN-20161211-114450-980','杨延报','谢江维','2016-12-11 03:45:29','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459374','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:19:10',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:24',NULL,NULL),(44,'IN-20161211-114534-142','杨延报','谢江维','2016-12-11 03:46:21','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459372','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:19:31',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:23',NULL,NULL),(45,'IN-20161211-114629-959','杨延报','谢江维','2016-12-11 03:47:11','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210457499','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:19:57',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:21',NULL,NULL),(46,'IN-20161211-114716-391','杨延报','谢江维','2016-12-11 03:47:55','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210457781','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:20:18',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:19',NULL,NULL),(47,'IN-20161211-114759-157','杨延报','谢江维','2016-12-11 03:48:36','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459582','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:20:36',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:18',NULL,NULL),(48,'IN-20161211-114840-427','杨延报','谢江维','2016-12-11 03:49:17','川R48953',NULL,'四川新兴格力电器有限责任公司','SLS210459584','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:20:55',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:16',NULL,NULL),(49,'IN-20161211-131552-373','杨延报','谢江维','2016-12-11 05:16:34','皖NA5980',NULL,'四川新兴格力电器有限责任公司','SLS230160856','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:37:19',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:14',NULL,NULL),(50,'IN-20161211-131639-957','杨延报','谢江维','2016-12-11 05:17:21','皖NA5980',NULL,'四川新兴格力电器有限责任公司','SLS230161011','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:36:58',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:12',NULL,NULL),(51,'IN-20161211-131814-837','杨延报','谢江维','2016-12-11 05:18:56','皖NA2500',NULL,'四川新兴格力电器有限责任公司','SLS230156694','2016-12-03 16:00:00',0,'吴明书','',1,'2016-12-11 07:36:38',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:11',NULL,NULL),(52,'IN-20161211-132049-928','杨延报','谢江维','2016-12-11 05:21:34','川S39336',NULL,'四川新兴格力电器有限责任公司','SLS210459513','2016-12-04 16:00:00',0,'吴明书','',1,'2016-12-11 07:36:15',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:09',NULL,NULL),(53,'IN-20161211-132138-265','杨延报','谢江维','2016-12-11 05:22:19','川S39336',NULL,'四川新兴格力电器有限责任公司','SLS210459514','2016-12-04 16:00:00',0,'吴明书','',1,'2016-12-11 07:38:25',0,'',NULL,NULL,'谢江维','2016-12-11 07:38:02','杨延报','2016-12-11 07:35:25'),(54,'IN-20161211-132223-880','杨延报','谢江维','2016-12-11 05:23:01','川S39336',NULL,'四川新兴格力电器有限责任公司','SLS210459704','2016-12-04 16:00:00',0,'其他','',1,'2016-12-11 07:34:25',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:05',NULL,NULL),(55,'IN-20161211-132347-650','杨延报','谢江维','2016-12-11 05:24:30','川S39336',NULL,'四川新兴格力电器有限责任公司','SLS210459376','2016-12-04 16:00:00',0,'其他','',1,'2016-12-11 07:34:05',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:03',NULL,NULL),(56,'IN-20161211-132439-618','杨延报','谢江维','2016-12-11 05:25:10','川S39336',NULL,'四川新兴格力电器有限责任公司','SLS210459586','2016-12-04 16:00:00',0,'吴明书','',1,'2016-12-11 07:33:40',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:25:01',NULL,NULL),(57,'IN-20161211-132550-206','杨延报','谢江维','2016-12-11 05:26:39','川S39336',NULL,'四川新兴格力电器有限责任公司','SLS210458792','2016-12-04 16:00:00',0,'吴明书','',1,'2016-12-11 07:33:20',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:59',NULL,NULL),(58,'IN-20161211-132644-458','杨延报','谢江维','2016-12-11 05:27:17','川S39336',NULL,'四川新兴格力电器有限责任公司','SLS210459143','2016-12-04 16:00:00',0,'吴明书','',1,'2016-12-11 07:32:56',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:58',NULL,NULL),(59,'IN-20161211-133409-926','杨延报','谢江维','2016-12-11 05:35:13','皖C92240',NULL,'四川新兴格力电器有限责任公司','Y60000302','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:29:42',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:56',NULL,NULL),(60,'IN-20161211-133524-517','杨延报','谢江维','2016-12-11 05:36:18','皖N99663',NULL,'四川新兴格力电器有限责任公司','SLS230162046','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:30:07',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:54',NULL,NULL),(61,'IN-20161211-133624-242','杨延报','谢江维','2016-12-11 05:37:02','皖N99663',NULL,'四川新兴格力电器有限责任公司','SLS230162047','2016-12-06 16:00:00',0,'其他','',1,'2016-12-11 07:30:39',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:53',NULL,NULL),(62,'IN-20161211-133709-348','杨延报','谢江维','2016-12-11 05:38:01','皖NF8167',NULL,'四川新兴格力电器有限责任公司','SLS230161430','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:31:05',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:50',NULL,NULL),(63,'IN-20161211-133808-100','杨延报','谢江维','2016-12-11 05:38:55','皖NF8167',NULL,'四川新兴格力电器有限责任公司','SLS230161330','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:31:25',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:48',NULL,NULL),(64,'IN-20161211-133858-538','杨延报','谢江维','2016-12-11 05:39:39','皖NF8167',NULL,'四川新兴格力电器有限责任公司','SLS230161680','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:31:55',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:31',NULL,NULL),(65,'IN-20161211-135544-400','杨延报','谢江维','2016-12-11 05:57:30','皖N92960',NULL,'四川新兴格力电器有限责任公司','Z30117475','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:22:11',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:29',NULL,NULL),(66,'IN-20161211-135736-207','杨延报','谢江维','2016-12-11 05:58:13','皖N92960',NULL,'四川新兴格力电器有限责任公司','SLS230159645','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:22:38',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:26',NULL,NULL),(67,'IN-20161211-135836-251','杨延报','谢江维','2016-12-11 05:59:41','皖N92960',NULL,'四川新兴格力电器有限责任公司','230154503','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:23:47',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:25',NULL,NULL),(68,'IN-20161211-135950-133','杨延报','谢江维','2016-12-11 06:00:21','皖N92960',NULL,'四川新兴格力电器有限责任公司','230155078','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:24:16',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:23',NULL,NULL),(69,'IN-20161211-140025-915','杨延报','谢江维','2016-12-11 06:01:21','皖N92960',NULL,'四川新兴格力电器有限责任公司','230154501','2016-12-06 16:00:00',0,'吴明书','',1,'2016-12-11 07:24:41',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:21',NULL,NULL),(70,'IN-20161211-140131-359','杨延报','谢江维','2016-12-11 06:02:21','川M22385',NULL,'四川新兴格力电器有限责任公司','SLS210460144','2016-12-06 16:00:00',0,'其他','',1,'2016-12-11 07:25:08',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:20',NULL,NULL),(71,'IN-20161211-140231-330','杨延报','谢江维','2016-12-11 06:04:16','川M22385',NULL,'四川新兴格力电器有限责任公司','SLS210458198','2016-12-06 16:00:00',0,'其他','',1,'2016-12-11 07:26:09',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:18',NULL,NULL),(72,'IN-20161211-140428-464','杨延报','谢江维','2016-12-11 06:05:42','川AT0995',NULL,'四川新兴格力电器有限责任公司','SLS210459993','2016-12-07 16:00:00',0,'其他','',1,'2016-12-11 07:27:05',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:17',NULL,NULL),(73,'IN-20161211-140654-989','杨延报','谢江维','2016-12-11 06:07:29','川AT0995',NULL,'四川新兴格力电器有限责任公司','SLS210459585','2016-12-07 16:00:00',0,'其他','',1,'2016-12-11 07:27:40',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:15',NULL,NULL),(74,'IN-20161211-141040-954','杨延报','谢江维','2016-12-11 06:11:43','川AT0995',NULL,'四川新兴格力电器有限责任公司','SLS210460382','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:28:01',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:13',NULL,NULL),(75,'IN-20161211-141149-716','杨延报','谢江维','2016-12-11 06:12:51','川AT0995',NULL,'四川新兴格力电器有限责任公司','SLS210459583','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:28:47',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:12',NULL,NULL),(76,'IN-20161211-141257-951','杨延报','谢江维','2016-12-11 06:13:34','川AT0995',NULL,'四川新兴格力电器有限责任公司','SLS210460145','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:29:08',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:14:09',NULL,NULL),(77,'IN-20161211-141808-442','杨延报','谢江维','2016-12-11 06:18:54','粤BE4629',NULL,'四川新兴格力电器有限责任公司','SLS220049716','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:11:32',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:47',NULL,NULL),(78,'IN-20161211-141859-573','杨延报','谢江维','2016-12-11 06:19:33','粤BE4629',NULL,'四川新兴格力电器有限责任公司','SLS220049016','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:11:52',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:45',NULL,NULL),(79,'IN-20161211-141947-204','杨延报','谢江维','2016-12-11 06:20:31','粤BE4629',NULL,'四川新兴格力电器有限责任公司','Z20088320','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:11:12',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:44',NULL,NULL),(80,'IN-20161211-142206-276','杨延报','谢江维','2016-12-11 06:22:51','皖KH5922',NULL,'四川新兴格力电器有限责任公司','SLS210460604','2016-12-08 16:00:00',0,'其他','',1,'2016-12-11 07:10:45',NULL,'',NULL,NULL,'谢江维','2016-12-11 06:24:42',NULL,NULL),(81,'IN-20161211-152507-586','杨延报','谢江维','2016-12-11 07:25:47','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210459702','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:43:45',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:38:36',NULL,NULL),(82,'IN-20161211-152731-905','杨延报','谢江维','2016-12-11 07:28:10','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210459842','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:43:30',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:38:35',NULL,NULL),(83,'IN-20161211-152934-126','杨延报','谢江维','2016-12-11 07:30:25','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210459841','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:43:08',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:38:33',NULL,NULL),(84,'IN-20161211-153032-638','杨延报','谢江维','2016-12-11 07:31:13','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210460138','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:42:19',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:38:31',NULL,NULL),(85,'IN-20161211-153124-522','杨延报','谢江维','2016-12-11 07:32:01','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210460142','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:42:02',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:38:30',NULL,NULL),(86,'IN-20161211-153224-481','杨延报','谢江维','2016-12-11 07:33:32','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210460139','2016-12-07 16:00:00',0,'吴明书','',1,'2016-12-11 07:41:34',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:38:28',NULL,NULL),(87,'IN-20161211-153337-969','杨延报','谢江维','2016-12-11 07:34:23','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210459703','2016-12-07 16:00:00',0,'吴明书','',-1,'2016-12-11 07:41:07',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:38:26','谢江维','2016-12-11 08:13:19'),(88,'IN-20161211-153435-705','杨延报','谢江维','2016-12-11 07:36:25','豫P2Z250',NULL,'四川新兴格力电器有限责任公司','SLS210460143','2016-12-07 16:00:00',0,'吴明书','',-1,'2016-12-11 07:39:20',NULL,'',NULL,NULL,'谢江维','2016-12-11 07:36:28','谢江维','2016-12-11 08:09:49');
/*!40000 ALTER TABLE `twms_instore_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_instore_sub`
--

DROP TABLE IF EXISTS `twms_instore_sub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_instore_sub` (
  `iss_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iss_mainid` int(11) DEFAULT NULL,
  `iss_id_p` int(2) NOT NULL COMMENT '分仓的父iss_id',
  `iss_prod` int(11) DEFAULT NULL,
  `iss_prodname` varchar(50) DEFAULT NULL,
  `iss_cate` int(11) DEFAULT NULL,
  `iss_price` float(11,2) DEFAULT NULL,
  `iss_count` int(11) DEFAULT NULL,
  `iss_plancount` int(11) DEFAULT NULL,
  `iss_total` float(11,2) DEFAULT NULL,
  `iss_store` int(11) DEFAULT NULL,
  `iss_remark` varchar(300) DEFAULT NULL,
  `iss_quality` varchar(20) NOT NULL,
  `iss_unit` varchar(10) NOT NULL,
  `iss_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `iss_insert_timestamp` bigint(20) NOT NULL,
  `iss_insert_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`iss_id`)
) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_instore_sub`
--

LOCK TABLES `twms_instore_sub` WRITE;
/*!40000 ALTER TABLE `twms_instore_sub` DISABLE KEYS */;
INSERT INTO `twms_instore_sub` VALUES (270,38,0,15,'GMV-NH36PL/A',4,NULL,500,500,0.00,36,NULL,'正品机','台','2016-12-11 03:41:34',14814276940236,NULL),(267,36,0,12,'FP-85WAHS/G(左式)',4,NULL,17,17,0.00,36,NULL,'正品机','台','2016-12-11 03:40:13',14814276133017,NULL),(268,36,0,13,'FP-85WAHS/G(右式)',4,NULL,16,16,0.00,36,NULL,'正品机','台','2016-12-11 03:40:13',14814276133023,NULL),(269,37,0,14,'GMV-H112WL/A',4,NULL,60,60,0.00,36,NULL,'正品机','台','2016-12-11 03:40:58',14814276586625,NULL),(265,34,0,10,'GMV-NH50PL/A',4,NULL,96,96,0.00,36,NULL,'正品机','台','2016-12-11 03:38:31',14814275119951,NULL),(266,35,0,11,'GMV-Pd100W/NaFC-N1',4,NULL,40,40,0.00,36,NULL,'正品机','台','2016-12-11 03:39:14',14814275549497,NULL),(264,33,0,9,'GMV-H120WL/A	',4,NULL,84,84,0.00,36,NULL,'正品机','台','2016-12-11 03:21:29',14814264899748,NULL),(263,32,0,9,'GMV-H120WL/A	',4,NULL,98,98,0.00,36,NULL,'正品机','台','2016-12-11 03:20:47',14814264471364,NULL),(260,29,0,7,'GMV-NH25PL/A',4,NULL,90,90,0.00,36,NULL,'正品机','台','2016-12-11 03:17:51',14814262709289,NULL),(261,30,0,8,'GMV-H160WL/A',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 03:18:49',14814263298193,NULL),(262,31,0,9,'GMV-H120WL/A	',4,NULL,68,68,0.00,36,NULL,'正品机','台','2016-12-11 03:19:50',14814263906823,NULL),(271,39,0,14,'GMV-H112WL/A',4,NULL,100,100,0.00,36,NULL,'正品机','台','2016-12-11 03:42:28',14814277485853,NULL),(272,40,0,11,'GMV-Pd100W/NaFC-N1',4,NULL,50,50,0.00,36,NULL,'正品机','台','2016-12-11 03:43:17',14814277973706,NULL),(273,41,0,16,'热水机组附件CF21',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 03:44:04',14814278440440,NULL),(274,42,0,17,'模块机打包附件CF78',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 03:44:46',14814278862072,NULL),(275,43,0,18,'GMV-NH56PL/A',4,NULL,134,134,0.00,36,NULL,'正品机','台','2016-12-11 03:45:29',14814279294883,NULL),(276,44,0,19,'GMV-NH45PL/A',4,NULL,200,200,0.00,36,NULL,'正品机','台','2016-12-11 03:46:21',14814279814807,NULL),(277,45,0,20,'GMV-Pd70W/NaFC-N1',4,NULL,37,37,0.00,36,NULL,'正品机','台','2016-12-11 03:47:11',14814280311238,NULL),(278,46,0,21,'KFRS-20Z/B2S',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 03:47:55',14814280750274,NULL),(279,47,0,22,'GMV-615WM/B',4,NULL,5,5,0.00,36,NULL,'正品机','台','2016-12-11 03:48:36',14814281167271,NULL),(280,48,0,22,'GMV-615WM/B',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 03:49:17',14814281577624,NULL),(281,49,0,23,'GMV-H180WL/A',4,NULL,50,50,0.00,36,NULL,'正品机','台','2016-12-11 05:16:34',14814333946709,NULL),(282,50,0,23,'GMV-H180WL/A',4,NULL,48,48,0.00,36,NULL,'正品机','台','2016-12-11 05:17:21',14814334419458,NULL),(283,51,0,14,'GMV-H112WL/A',4,NULL,43,43,0.00,36,NULL,'正品机','台','2016-12-11 05:18:56',14814335370044,NULL),(284,51,0,24,'GMV-H140WL/A',4,NULL,50,50,0.00,36,NULL,'正品机','台','2016-12-11 05:18:56',14814335370054,NULL),(285,52,0,25,'G-5WD/B',4,NULL,4,4,0.00,36,NULL,'正品机','台','2016-12-11 05:21:34',14814336944770,NULL),(342,53,0,26,'G-5WDIY/B',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 07:37:59',14814418791486,NULL),(287,54,0,27,'LSQWRF130M/D',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 05:23:01',14814337818695,NULL),(288,55,0,27,'LSQWRF130M/D',4,NULL,5,5,0.00,36,NULL,'正品机','台','2016-12-11 05:24:30',14814338706562,NULL),(289,56,0,28,'GMV-N560U/A',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 05:25:10',14814339109888,NULL),(290,57,0,29,'G-3WDX/E',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 05:26:39',14814339999002,NULL),(291,58,0,30,'GZK1816ZFUZ/B31（订单）',4,NULL,1,1,0.00,36,NULL,'正品机','套','2016-12-11 05:27:17',14814340376680,NULL),(292,59,0,31,'FGR2.6/C',4,NULL,190,190,0.00,36,NULL,'正品机','套','2016-12-11 05:35:13',14814345136058,NULL),(293,59,0,32,'FGR3.5/C',4,NULL,180,180,0.00,36,NULL,'正品机','套','2016-12-11 05:35:13',14814345136065,NULL),(294,60,0,33,'LSQWRF80M/D',4,NULL,5,5,0.00,36,NULL,'正品机','台','2016-12-11 05:36:18',14814345782179,NULL),(295,61,0,27,'LSQWRF130M/D',4,NULL,5,5,0.00,36,NULL,'正品机','台','2016-12-11 05:37:02',14814346224444,NULL),(296,62,0,34,'GMV-450WM/B',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 05:38:01',14814346810515,NULL),(297,62,0,35,'GMV-280WM/B',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 05:38:01',14814346810523,NULL),(298,63,0,22,'GMV-615WM/B',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 05:38:55',14814347357909,NULL),(299,64,0,36,'LSQWRF65M/D',4,NULL,10,10,0.00,36,NULL,'正品机','台','2016-12-11 05:39:39',14814347796193,NULL),(300,65,0,37,'FP-102WAH/G(左式）',4,NULL,100,100,0.00,36,NULL,'正品机','台','2016-12-11 05:57:30',14814358509264,NULL),(301,65,0,38,'FP-102WAH/G(右式）',4,NULL,100,100,0.00,36,NULL,'正品机','台','2016-12-11 05:57:30',14814358509271,NULL),(302,65,0,39,'FP-136WAH/G(左式）',4,NULL,100,100,0.00,36,NULL,'正品机','台','2016-12-11 05:57:30',14814358509277,NULL),(303,65,0,40,'FP-136WAH/G(右式）',4,NULL,100,100,0.00,36,NULL,'正品机','台','2016-12-11 05:57:30',14814358509282,NULL),(304,65,0,41,'FP-204WA/G(左式）',4,NULL,50,50,0.00,36,NULL,'正品机','台','2016-12-11 05:57:30',14814358509287,NULL),(305,65,0,42,'FP-204WA/G(右式）',4,NULL,95,95,0.00,36,NULL,'正品机','台','2016-12-11 05:57:30',14814358509292,NULL),(306,66,0,44,'FGR12/D-N4',4,NULL,64,64,0.00,36,NULL,'正品机','套','2016-12-11 05:58:13',14814358931513,NULL),(307,67,0,43,'触摸屏CM27-GZ12/A1（M）',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 05:59:41',14814359813193,NULL),(308,68,0,43,'触摸屏CM27-GZ12/A1（M）',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 06:00:21',14814360216328,NULL),(309,69,0,43,'触摸屏CM27-GZ12/A1（M）',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 06:01:21',14814360813428,NULL),(310,70,0,27,'LSQWRF130M/D',4,NULL,8,8,0.00,36,NULL,'正品机','台','2016-12-11 06:02:21',14814361411299,NULL),(311,71,0,45,'GMV-NX560P/A（X5.0）',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 06:04:16',14814362569477,NULL),(312,72,0,27,'LSQWRF130M/D',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 06:05:42',14814363423699,NULL),(313,72,0,51,'配件',5,NULL,6,6,0.00,36,NULL,'正品机','件','2016-12-11 06:05:42',14814363423710,NULL),(314,72,0,52,'资料',5,NULL,554,554,0.00,36,NULL,'正品机','件','2016-12-11 06:05:42',14814363423716,NULL),(315,73,0,46,'GZK1212ZUFY/A05（订单）',4,NULL,1,1,0.00,36,NULL,'正品机','套','2016-12-11 06:07:29',14814364499159,NULL),(316,74,0,47,'GMV-785W/A',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 06:11:43',14814367037429,NULL),(317,74,0,53,'GMV-615W/A',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 06:11:43',14814367037437,NULL),(318,75,0,48,'KFRS-60ZMRe/NaB2S',4,NULL,3,3,0.00,36,NULL,'正品机','台','2016-12-11 06:12:51',14814367716330,NULL),(319,75,0,49,'KFRS-30ZMRe/NaB2S',4,NULL,1,1,0.00,36,NULL,'正品机','台','2016-12-11 06:12:51',14814367716337,NULL),(320,75,0,50,'KFRS-30ZRe/NaB2S',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 06:12:51',14814367716342,NULL),(321,76,0,27,'LSQWRF130M/D',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 06:13:34',14814368145701,NULL),(322,77,0,54,'FGR6.5/C',4,NULL,30,30,0.00,36,NULL,'正品机','套','2016-12-11 06:18:54',14814371347897,NULL),(323,78,0,54,'FGR6.5/C',4,NULL,50,50,0.00,36,NULL,'正品机','套','2016-12-11 06:19:33',14814371736939,NULL),(324,79,0,55,'FGR7.5/C-N3',4,NULL,200,200,0.00,36,NULL,'正品机','套','2016-12-11 06:20:31',14814372312992,NULL),(325,80,0,56,'LSQWRF130M/NaD',4,NULL,8,8,0.00,36,NULL,'正品机','台','2016-12-11 06:22:51',14814373714606,NULL),(326,81,0,10,'GMV-NH50PL/A',4,NULL,104,104,0.00,36,NULL,'正品机','台','2016-12-11 07:25:47',14814411478539,NULL),(327,82,0,66,'FP-204WAH/G(右式）',4,NULL,100,100,0.00,36,NULL,'正品机','台','2016-12-11 07:28:10',14814412907493,NULL),(328,83,0,67,'GMV-H80WL/A',4,NULL,10,10,0.00,36,NULL,'正品机','台','2016-12-11 07:30:25',14814414258602,NULL),(329,83,0,23,'GMV-H180WL/A',4,NULL,50,50,0.00,36,NULL,'正品机','台','2016-12-11 07:30:25',14814414258611,NULL),(330,84,0,17,'模块机打包附件CF78',4,NULL,30,30,0.00,36,NULL,'正品机','台','2016-12-11 07:31:13',14814414733414,NULL),(331,85,0,65,'GMV-H180WL/AS',4,NULL,2,2,0.00,36,NULL,'正品机','台','2016-12-11 07:32:01',14814415217677,NULL),(332,86,0,62,'GMV-H224WL/A',4,NULL,10,10,0.00,36,NULL,'正品机','台','2016-12-11 07:33:32',14814416122273,NULL),(333,86,0,63,'GMV-H280WL/A',4,NULL,10,10,0.00,36,NULL,'正品机','台','2016-12-11 07:33:32',14814416122278,NULL),(334,86,0,64,'GMV-H300W/B',4,NULL,5,5,0.00,36,NULL,'正品机','台','2016-12-11 07:33:32',14814416122282,NULL),(335,86,0,65,'GMV-H180WL/AS',4,NULL,3,3,0.00,36,NULL,'正品机','台','2016-12-11 07:33:32',14814416122285,NULL),(336,87,0,18,'GMV-NH56PL/A',4,NULL,66,66,0.00,36,NULL,'正品机','台','2016-12-11 07:34:23',14814416633567,NULL),(337,88,0,57,'GMV-NHD22PL/A',4,NULL,50,50,0.00,36,NULL,'正品机','台','2016-12-11 07:36:25',14814417854075,NULL),(338,88,0,58,'GMV-NHD32PL/A',4,NULL,20,20,0.00,36,NULL,'正品机','台','2016-12-11 07:36:25',14814417854084,NULL),(339,88,0,59,'GMV-NHD28PL/A',4,NULL,40,40,0.00,36,NULL,'正品机','台','2016-12-11 07:36:25',14814417854090,NULL),(340,88,0,60,'GMV-NHD25PL/A',4,NULL,50,50,0.00,36,NULL,'正品机','台','2016-12-11 07:36:25',14814417854096,NULL),(341,88,0,61,'GMV-NHD45PL/A',4,NULL,7,7,0.00,36,NULL,'正品机','台','2016-12-11 07:36:25',14814417854101,NULL);
/*!40000 ALTER TABLE `twms_instore_sub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_log`
--

DROP TABLE IF EXISTS `twms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_log` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_operator_name` varchar(20) DEFAULT NULL,
  `log_operator_realname` varchar(20) DEFAULT NULL,
  `log_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_action` varchar(30) DEFAULT NULL,
  `log_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_log`
--

LOCK TABLES `twms_log` WRITE;
/*!40000 ALTER TABLE `twms_log` DISABLE KEYS */;
INSERT INTO `twms_log` VALUES (1,'admin','管理员','2016-12-11 09:27:56','订单删除','127.0.0.1');
/*!40000 ALTER TABLE `twms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_notice`
--

DROP TABLE IF EXISTS `twms_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_notice` (
  `ntc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ntc_title` varchar(200) DEFAULT NULL,
  `ntc_content` varchar(1000) DEFAULT NULL,
  `ntc_author` varchar(15) DEFAULT NULL,
  `ntc_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ntc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_notice`
--

LOCK TABLES `twms_notice` WRITE;
/*!40000 ALTER TABLE `twms_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `twms_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_outstore_main`
--

DROP TABLE IF EXISTS `twms_outstore_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_outstore_main` (
  `osm_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `osm_sn` varchar(30) DEFAULT NULL,
  `osm_buyerunit` varchar(40) DEFAULT NULL,
  `osm_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `osm_operator` varchar(20) DEFAULT NULL,
  `osm_phone` varchar(30) DEFAULT NULL,
  `osm_writer` varchar(15) DEFAULT NULL,
  `osm_total` float DEFAULT NULL,
  `osm_danju_no` varchar(20) NOT NULL,
  `osm_danju_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `osm_danju_del` int(2) NOT NULL,
  `osm_carry` varchar(20) NOT NULL,
  `osm_car_no` varchar(10) NOT NULL,
  `osm_status` int(2) NOT NULL,
  `osm_status_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `osm_inmainid` int(11) DEFAULT NULL COMMENT '引用的入仓主表id',
  `osm_remark` varchar(600) NOT NULL,
  `osm_reviwer` varchar(15) DEFAULT NULL,
  `osm_reviwer_time` timestamp NULL DEFAULT NULL,
  `osm_submiter` varchar(15) DEFAULT NULL,
  `osm_submit_time` timestamp NULL DEFAULT NULL,
  `osm_rollbacker` varchar(15) DEFAULT NULL,
  `osm_rollback_time` timestamp NULL DEFAULT NULL,
  `osm_deliver` int(2) DEFAULT NULL,
  PRIMARY KEY (`osm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_outstore_main`
--

LOCK TABLES `twms_outstore_main` WRITE;
/*!40000 ALTER TABLE `twms_outstore_main` DISABLE KEYS */;
/*!40000 ALTER TABLE `twms_outstore_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_outstore_sub`
--

DROP TABLE IF EXISTS `twms_outstore_sub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_outstore_sub` (
  `oss_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oss_prod` int(11) DEFAULT NULL,
  `oss_prodname` varchar(50) DEFAULT NULL,
  `oss_cate` int(11) DEFAULT NULL,
  `oss_count` int(11) DEFAULT NULL,
  `oss_plancount` int(11) DEFAULT NULL,
  `oss_price` float(11,2) DEFAULT NULL,
  `oss_total` float(11,2) DEFAULT NULL,
  `oss_store` int(11) DEFAULT NULL,
  `oss_remark` varchar(300) DEFAULT NULL,
  `oss_mainid` int(11) DEFAULT NULL,
  `oss_quality` varchar(20) NOT NULL,
  `oss_unit` varchar(10) NOT NULL,
  `oss_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `oss_insubid` int(11) DEFAULT NULL COMMENT '引用的入仓子表id',
  `oss_insert_order` int(11) NOT NULL,
  PRIMARY KEY (`oss_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_outstore_sub`
--

LOCK TABLES `twms_outstore_sub` WRITE;
/*!40000 ALTER TABLE `twms_outstore_sub` DISABLE KEYS */;
/*!40000 ALTER TABLE `twms_outstore_sub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_prod_carry`
--

DROP TABLE IF EXISTS `twms_prod_carry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_prod_carry` (
  `pdcarry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pdcarry_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pdcarry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_prod_carry`
--

LOCK TABLES `twms_prod_carry` WRITE;
/*!40000 ALTER TABLE `twms_prod_carry` DISABLE KEYS */;
INSERT INTO `twms_prod_carry` VALUES (13,'吴明书'),(12,'徐高建'),(15,'其他');
/*!40000 ALTER TABLE `twms_prod_carry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_prod_cate`
--

DROP TABLE IF EXISTS `twms_prod_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_prod_cate` (
  `pdca_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pdca_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pdca_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_prod_cate`
--

LOCK TABLES `twms_prod_cate` WRITE;
/*!40000 ALTER TABLE `twms_prod_cate` DISABLE KEYS */;
INSERT INTO `twms_prod_cate` VALUES (4,'空调'),(2,'热水器'),(3,'冰箱'),(5,'其他');
/*!40000 ALTER TABLE `twms_prod_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_prod_quality`
--

DROP TABLE IF EXISTS `twms_prod_quality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_prod_quality` (
  `pdqu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pdqu_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pdqu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_prod_quality`
--

LOCK TABLES `twms_prod_quality` WRITE;
/*!40000 ALTER TABLE `twms_prod_quality` DISABLE KEYS */;
INSERT INTO `twms_prod_quality` VALUES (1,'正品机'),(2,'残次机'),(3,'样机');
/*!40000 ALTER TABLE `twms_prod_quality` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_product`
--

DROP TABLE IF EXISTS `twms_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_product` (
  `prod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod_name` varchar(50) DEFAULT NULL,
  `prod_price` float(11,3) DEFAULT NULL,
  `prod_realprice` float(11,3) DEFAULT NULL,
  `prod_count` int(11) DEFAULT NULL,
  `prod_cate` int(11) DEFAULT NULL,
  `prod_code` varchar(10) NOT NULL,
  `prod_unit` varchar(10) NOT NULL,
  `prod_guest` varchar(50) NOT NULL,
  `prod_volume` float(11,3) DEFAULT NULL,
  `prod_weight` float(11,2) DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_product`
--

LOCK TABLES `twms_product` WRITE;
/*!40000 ALTER TABLE `twms_product` DISABLE KEYS */;
INSERT INTO `twms_product` VALUES (7,'GMV-NH25PL/A',NULL,NULL,0,4,'25','台','四川新兴格力电器有限责任公司',NULL,NULL),(8,'GMV-H160WL/A',NULL,NULL,0,4,'160','台','四川新兴格力电器有限责任公司',NULL,NULL),(9,'GMV-H120WL/A	',NULL,NULL,0,4,'120','台','四川新兴格力电器有限责任公司',NULL,NULL),(10,'GMV-NH50PL/A',NULL,NULL,0,4,'50','台','四川新兴格力电器有限责任公司',NULL,NULL),(11,'GMV-Pd100W/NaFC-N1',NULL,NULL,0,4,'1001','台','四川新兴格力电器有限责任公司',NULL,NULL),(12,'FP-85WAHS/G(左式)',NULL,NULL,0,4,'85','台','四川新兴格力电器有限责任公司',NULL,NULL),(13,'FP-85WAHS/G(右式)',NULL,NULL,0,4,'85','台','四川新兴格力电器有限责任公司',NULL,NULL),(14,'GMV-H112WL/A',NULL,NULL,0,4,'112','台','四川新兴格力电器有限责任公司',NULL,NULL),(15,'GMV-NH36PL/A',NULL,NULL,0,4,'36','台','四川新兴格力电器有限责任公司',NULL,NULL),(16,'热水机组附件CF21',NULL,NULL,0,4,'21','台','四川新兴格力电器有限责任公司',NULL,NULL),(17,'模块机打包附件CF78',NULL,NULL,0,4,'78','台','四川新兴格力电器有限责任公司',NULL,NULL),(18,'GMV-NH56PL/A',NULL,NULL,0,4,'56','台','四川新兴格力电器有限责任公司',NULL,NULL),(19,'GMV-NH45PL/A',NULL,NULL,0,4,'45','台','四川新兴格力电器有限责任公司',NULL,NULL),(20,'GMV-Pd70W/NaFC-N1',NULL,NULL,0,4,'701','台','四川新兴格力电器有限责任公司',NULL,NULL),(21,'KFRS-20Z/B2S',NULL,NULL,0,4,'202','台','四川新兴格力电器有限责任公司',NULL,NULL),(22,'GMV-615WM/B',NULL,NULL,0,4,'615','台','四川新兴格力电器有限责任公司',NULL,NULL),(23,'GMV-H180WL/A',NULL,NULL,0,4,'180','台','四川新兴格力电器有限责任公司',NULL,NULL),(24,'GMV-H140WL/A',NULL,NULL,0,4,'140','台','四川新兴格力电器有限责任公司',NULL,NULL),(25,'G-5WD/B',NULL,NULL,0,4,'5','台','四川新兴格力电器有限责任公司',NULL,NULL),(26,'G-5WDIY/B',NULL,NULL,0,4,'5','台','四川新兴格力电器有限责任公司',NULL,NULL),(27,'LSQWRF130M/D',NULL,NULL,0,4,'130','台','四川新兴格力电器有限责任公司',NULL,NULL),(28,'GMV-N560U/A',NULL,NULL,0,4,'560','台','四川新兴格力电器有限责任公司',NULL,NULL),(29,'G-3WDX/E',NULL,NULL,0,4,'3','台','四川新兴格力电器有限责任公司',NULL,NULL),(30,'GZK1816ZFUZ/B31（订单）',NULL,NULL,0,4,'181631','套','四川新兴格力电器有限责任公司',NULL,NULL),(31,'FGR2.6/C',NULL,NULL,0,4,'2.6','套','四川新兴格力电器有限责任公司',NULL,NULL),(32,'FGR3.5/C',NULL,NULL,0,4,'3.5','套','四川新兴格力电器有限责任公司',NULL,NULL),(33,'LSQWRF80M/D',NULL,NULL,0,4,'80','台','四川新兴格力电器有限责任公司',NULL,NULL),(34,'GMV-450WM/B',NULL,NULL,0,4,'450','台','四川新兴格力电器有限责任公司',NULL,NULL),(35,'GMV-280WM/B',NULL,NULL,0,4,'280','台','四川新兴格力电器有限责任公司',NULL,NULL),(36,'LSQWRF65M/D',NULL,NULL,0,4,'65','台','四川新兴格力电器有限责任公司',NULL,NULL),(37,'FP-102WAH/G(左式）',NULL,NULL,0,4,'102','台','四川新兴格力电器有限责任公司',NULL,NULL),(38,'FP-102WAH/G(右式）',NULL,NULL,0,4,'102','台','四川新兴格力电器有限责任公司',NULL,NULL),(39,'FP-136WAH/G(左式）',NULL,NULL,0,4,'136','台','四川新兴格力电器有限责任公司',NULL,NULL),(40,'FP-136WAH/G(右式）',NULL,NULL,0,4,'136','台','四川新兴格力电器有限责任公司',NULL,NULL),(41,'FP-204WA/G(左式）',NULL,NULL,0,4,'204','台','四川新兴格力电器有限责任公司',NULL,NULL),(42,'FP-204WA/G(右式）',NULL,NULL,0,4,'204','台','四川新兴格力电器有限责任公司',NULL,NULL),(43,'触摸屏CM27-GZ12/A1（M）',NULL,NULL,0,4,'27121','台','四川新兴格力电器有限责任公司',NULL,NULL),(44,'FGR12/D-N4',NULL,NULL,0,4,'124','套','四川新兴格力电器有限责任公司',NULL,NULL),(45,'GMV-NX560P/A（X5.0）',NULL,NULL,0,4,'5605','台','四川新兴格力电器有限责任公司',NULL,NULL),(46,'GZK1212ZUFY/A05（订单）',NULL,NULL,0,4,'121205','套','四川新兴格力电器有限责任公司',NULL,NULL),(47,'GMV-785W/A',NULL,NULL,0,4,'785','台','四川新兴格力电器有限责任公司',NULL,NULL),(48,'KFRS-60ZMRe/NaB2S',NULL,NULL,0,4,'602','台','四川新兴格力电器有限责任公司',NULL,NULL),(49,'KFRS-30ZMRe/NaB2S',NULL,NULL,0,4,'302','台','四川新兴格力电器有限责任公司',NULL,NULL),(50,'KFRS-30ZRe/NaB2S',NULL,NULL,0,4,'302','台','四川新兴格力电器有限责任公司',NULL,NULL),(51,'配件',NULL,NULL,0,5,'PJ','件','四川新兴格力电器有限责任公司',NULL,NULL),(52,'资料',NULL,NULL,0,5,'ZL','件','四川新兴格力电器有限责任公司',NULL,NULL),(53,'GMV-615W/A',NULL,NULL,0,4,'615','台','四川新兴格力电器有限责任公司',NULL,NULL),(54,'FGR6.5/C',NULL,NULL,0,4,'6.5','套','四川新兴格力电器有限责任公司',NULL,NULL),(55,'FGR7.5/C-N3',NULL,NULL,0,4,'753','套','四川新兴格力电器有限责任公司',NULL,NULL),(56,'LSQWRF130M/NaD',NULL,NULL,0,4,'130','台','四川新兴格力电器有限责任公司',NULL,NULL),(57,'GMV-NHD22PL/A',NULL,NULL,0,4,'22','台','四川新兴格力电器有限责任公司',NULL,NULL),(58,'GMV-NHD32PL/A',NULL,NULL,0,4,'32','台','四川新兴格力电器有限责任公司',NULL,NULL),(59,'GMV-NHD28PL/A',NULL,NULL,0,4,'28','台','四川新兴格力电器有限责任公司',NULL,NULL),(60,'GMV-NHD25PL/A',NULL,NULL,0,4,'25','台','四川新兴格力电器有限责任公司',NULL,NULL),(61,'GMV-NHD45PL/A',NULL,NULL,0,4,'45','台','四川新兴格力电器有限责任公司',NULL,NULL),(62,'GMV-H224WL/A',NULL,NULL,0,4,'224','台','四川新兴格力电器有限责任公司',NULL,NULL),(63,'GMV-H280WL/A',NULL,NULL,0,4,'280','台','四川新兴格力电器有限责任公司',NULL,NULL),(64,'GMV-H300W/B',NULL,NULL,0,4,'300','台','四川新兴格力电器有限责任公司',NULL,NULL),(65,'GMV-H180WL/AS',NULL,NULL,0,4,'180','台','四川新兴格力电器有限责任公司',NULL,NULL),(66,'FP-204WAH/G(右式）',NULL,NULL,0,4,'204','台','四川新兴格力电器有限责任公司',NULL,NULL),(67,'GMV-H80WL/A',NULL,NULL,0,4,'80','台','四川新兴格力电器有限责任公司',NULL,NULL);
/*!40000 ALTER TABLE `twms_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_store`
--

DROP TABLE IF EXISTS `twms_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_store` (
  `sto_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sto_name` varchar(20) DEFAULT NULL,
  `sto_kuwei_name` varchar(30) NOT NULL,
  `sto_parrent_id` int(8) NOT NULL,
  `sto_default` int(2) NOT NULL,
  `sto_address` varchar(50) DEFAULT NULL,
  `sto_storer` varchar(15) DEFAULT NULL,
  `sto_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`sto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_store`
--

LOCK TABLES `twms_store` WRITE;
/*!40000 ALTER TABLE `twms_store` DISABLE KEYS */;
INSERT INTO `twms_store` VALUES (40,'龙泉1号2','A01',36,0,NULL,NULL,NULL),(36,'龙泉1号2','',0,1,'双流2','user2','1312'),(37,'龙泉1号2','A02',36,0,NULL,NULL,NULL),(41,'龙泉1号2','A03',36,0,NULL,NULL,NULL),(42,'龙泉1号2','B01',36,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `twms_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_user`
--

DROP TABLE IF EXISTS `twms_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) DEFAULT NULL,
  `user_realname` varchar(20) DEFAULT NULL,
  `user_password` varchar(32) DEFAULT NULL,
  `user_lastlogindate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lastloginip` varchar(20) DEFAULT NULL,
  `user_type` int(5) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_user`
--

LOCK TABLES `twms_user` WRITE;
/*!40000 ALTER TABLE `twms_user` DISABLE KEYS */;
INSERT INTO `twms_user` VALUES (13,'admin','管理员','48309e7da0e9e329c879715f691dd252','2016-12-11 08:29:32','127.0.0.1',1);
/*!40000 ALTER TABLE `twms_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_prod_deliver`
--

DROP TABLE IF EXISTS `twms_prod_deliver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_prod_deliver` (
  `pddeliver_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pddeliver_name` varchar(30) DEFAULT NULL,
  `pddeliver_phone` varchar(30) DEFAULT NULL,
  `pddeliver_address` varchar(100) DEFAULT NULL,
  `pddeliver_note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pddeliver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_prod_deliver`
--

LOCK TABLES `twms_prod_deliver` WRITE;
/*!40000 ALTER TABLE `twms_prod_deliver` DISABLE KEYS */;
INSERT INTO `twms_prod_deliver` VALUES (17,'test','1234','2345','3456'),(18,'小东','13438960999','成都市天府新区华阳街道办','海尔冰箱华阳');
/*!40000 ALTER TABLE `twms_prod_deliver` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;



-- Dump completed on 2016-12-11 18:00:25
