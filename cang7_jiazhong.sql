-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cangjiazhong
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

DROP SCHEMA IF EXISTS `cangjiazhong`;
CREATE SCHEMA IF NOT EXISTS `cangjiazhong` DEFAULT CHARACTER SET UTF8;
USE `cangjiazhong`;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_guest`
--

LOCK TABLES `twms_guest` WRITE;
/*!40000 ALTER TABLE `twms_guest` DISABLE KEYS */;
INSERT INTO `twms_guest` VALUES (2,'四川新兴格力电器有限责任公司','XXGL','undefined','undefined','undefined',0,NULL,'成都市','13551178333'),(3,'xxxx2sdfs','xx','xx','xx','x',11,NULL,'xxx湖北省武汉市余家头小区，小破路，基围虾好好吃','xxxx');
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
INSERT INTO `twms_guest_cate` VALUES (5,'家电类客户',0),(7,'商场超市',0);
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_instore_main`
--

LOCK TABLES `twms_instore_main` WRITE;
/*!40000 ALTER TABLE `twms_instore_main` DISABLE KEYS */;
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
  `iss_quality` varchar(20) DEFAULT NULL,
  `iss_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `iss_insert_order` int(11) DEFAULT NULL,
  `iss_make_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iss_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_instore_sub`
--

LOCK TABLES `twms_instore_sub` WRITE;
/*!40000 ALTER TABLE `twms_instore_sub` DISABLE KEYS */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_log`
--

LOCK TABLES `twms_log` WRITE;
/*!40000 ALTER TABLE `twms_log` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_notice`
--

LOCK TABLES `twms_notice` WRITE;
/*!40000 ALTER TABLE `twms_notice` DISABLE KEYS */;
INSERT INTO `twms_notice` VALUES (15,'test','test','管理员','2017-08-04 13:49:26');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
  `oss_quality` varchar(20) DEFAULT NULL,
  `oss_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `oss_insubid` int(11) DEFAULT NULL COMMENT '引用的入仓子表id',
  `oss_insert_order` int(11) DEFAULT NULL,
  `oss_make_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`oss_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
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
  `prod_code` varchar(30) DEFAULT NULL,
  `prod_unit` varchar(10) DEFAULT NULL,
  `prod_guest` varchar(50) DEFAULT NULL,
  `prod_volume` float(11,3) DEFAULT NULL,
  `prod_weight` float(11,2) DEFAULT NULL,
  `prod_life` int(4) DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_product`
--

LOCK TABLES `twms_product` WRITE;
/*!40000 ALTER TABLE `twms_product` DISABLE KEYS */;
INSERT INTO `twms_product` VALUES (7,'GMV-NH25PL/A',NULL,NULL,0,4,'25','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(8,'GMV-H160WL/A',NULL,NULL,0,4,'160','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(9,'GMV-H120WL/A	',NULL,NULL,0,4,'120','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(10,'GMV-NH50PL/A',NULL,NULL,0,4,'50','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(11,'GMV-Pd100W/NaFC-N1',NULL,NULL,0,4,'1001','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(12,'FP-85WAHS/G(左式)',NULL,NULL,0,4,'85','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(13,'FP-85WAHS/G(右式)',NULL,NULL,0,4,'85','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(14,'GMV-H112WL/A',NULL,NULL,0,4,'112','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(15,'GMV-NH36PL/A',NULL,NULL,0,4,'36','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(16,'热水机组附件CF21',NULL,NULL,0,4,'21','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(17,'模块机打包附件CF78',NULL,NULL,0,4,'78','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(18,'GMV-NH56PL/A',NULL,NULL,0,4,'56','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(19,'GMV-NH45PL/A',NULL,NULL,0,4,'45','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(20,'GMV-Pd70W/NaFC-N1',NULL,NULL,0,4,'701','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(21,'KFRS-20Z/B2S',NULL,NULL,0,4,'202','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(22,'GMV-615WM/B',NULL,NULL,0,4,'615','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(23,'GMV-H180WL/A',NULL,NULL,0,4,'180','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(24,'GMV-H140WL/A',NULL,NULL,0,4,'140','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(25,'G-5WD/B',NULL,NULL,0,4,'5','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(26,'G-5WDIY/B',NULL,NULL,0,4,'5','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(27,'LSQWRF130M/D',NULL,NULL,0,4,'130','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(28,'GMV-N560U/A',NULL,NULL,0,4,'560','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(29,'G-3WDX/E',NULL,NULL,0,4,'3','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(30,'GZK1816ZFUZ/B31（订单）',NULL,NULL,0,4,'181631','套','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(31,'FGR2.6/C',NULL,NULL,0,4,'2.6','套','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(32,'FGR3.5/C',NULL,NULL,0,4,'3.5','套','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(33,'LSQWRF80M/D',NULL,NULL,0,4,'80','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(34,'GMV-450WM/B',NULL,NULL,0,4,'450','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(35,'GMV-280WM/B',NULL,NULL,0,4,'280','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(36,'LSQWRF65M/D',NULL,NULL,0,4,'65','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(37,'FP-102WAH/G(左式）',NULL,NULL,0,4,'102','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(38,'FP-102WAH/G(右式）',NULL,NULL,0,4,'102','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(39,'FP-136WAH/G(左式）',NULL,NULL,0,4,'136','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(40,'FP-136WAH/G(右式）',NULL,NULL,0,4,'136','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(41,'FP-204WA/G(左式）',NULL,NULL,0,4,'204','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(42,'FP-204WA/G(右式）',NULL,NULL,0,4,'204','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(43,'触摸屏CM27-GZ12/A1（M）',NULL,NULL,0,4,'27121','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(44,'FGR12/D-N4',NULL,NULL,0,4,'124','套','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(45,'GMV-NX560P/A（X5.0）',NULL,NULL,0,4,'5605','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(46,'GZK1212ZUFY/A05（订单）',NULL,NULL,0,4,'121205','套','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(47,'GMV-785W/A',NULL,NULL,0,4,'785','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(48,'KFRS-60ZMRe/NaB2S',NULL,NULL,0,4,'602','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(49,'KFRS-30ZMRe/NaB2S',NULL,NULL,0,4,'302','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(50,'KFRS-30ZRe/NaB2S',NULL,NULL,0,4,'302','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(51,'配件',NULL,NULL,0,5,'PJ12345678910123456789','件','四川新兴格力电器有限责任公司',NULL,1.25,30),(52,'资料',NULL,NULL,0,5,'ZL','件','四川新兴格力电器有限责任公司',NULL,12.00,34),(53,'GMV-615W/A',NULL,NULL,0,4,'615','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(54,'FGR6.5/C',NULL,NULL,0,4,'6.5','套','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(55,'FGR7.5/C-N3',NULL,NULL,0,4,'753','套','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(56,'LSQWRF130M/NaD',NULL,NULL,0,4,'130','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(57,'GMV-NHD22PL/A',NULL,NULL,0,4,'22','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(58,'GMV-NHD32PL/A',NULL,NULL,0,4,'32','台','四川新兴格力电器有限责任公司',NULL,2.00,36),(59,'GMV-NHD28PL/A',NULL,NULL,0,4,'28','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(60,'GMV-NHD25PL/A',NULL,NULL,0,4,'25','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(61,'GMV-NHD45PL/A',NULL,NULL,0,4,'45','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(62,'GMV-H224WL/A',NULL,NULL,0,4,'224','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(63,'GMV-H280WL/A',NULL,NULL,0,4,'280','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(64,'GMV-H300W/B',NULL,NULL,0,4,'300','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(65,'GMV-H180WL/AS',NULL,NULL,0,4,'180','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(66,'FP-204WAH/G(右式）',NULL,NULL,0,4,'204','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL),(67,'GMV-H80WL/A',NULL,NULL,0,4,'80','台','四川新兴格力电器有限责任公司',NULL,NULL,NULL);
/*!40000 ALTER TABLE `twms_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_shipment_domain`
--

DROP TABLE IF EXISTS `twms_shipment_domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_shipment_domain` (
  `domain_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(30) DEFAULT NULL,
  `domain_price` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`domain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_shipment_domain`
--

LOCK TABLES `twms_shipment_domain` WRITE;
/*!40000 ALTER TABLE `twms_shipment_domain` DISABLE KEYS */;
INSERT INTO `twms_shipment_domain` VALUES (6,'武汉','90'),(7,'海南','100');
/*!40000 ALTER TABLE `twms_shipment_domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twms_shipment_main`
--

DROP TABLE IF EXISTS `twms_shipment_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_shipment_main` (
  `ship_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ship_sn` varchar(30) DEFAULT NULL COMMENT '流水编号',
  `ship_customer` varchar(40) DEFAULT NULL COMMENT '收货单位',
  `ship_final_address` varchar(80) DEFAULT NULL COMMENT '最终目的地',
  `ship_car_no` varchar(20) DEFAULT NULL COMMENT '车号',
  `ship_box_no1` varchar(20) DEFAULT NULL COMMENT '柜号1',
  `ship_box_no2` varchar(20) DEFAULT NULL COMMENT '柜号2',
  `ship_customer_address` varchar(80) DEFAULT NULL COMMENT '收货地址',
  `ship_customer_info` varchar(60) DEFAULT NULL COMMENT '收货联系人方式',
  `ship_deliver_date` timestamp NULL DEFAULT NULL COMMENT '送货日期',
  `ship_driver_to` varchar(20) DEFAULT NULL COMMENT '送货司机',
  `ship_driver_car_no` varchar(20) DEFAULT NULL COMMENT '送货车牌',
  `ship_deliver_domain` int(2) NOT NULL COMMENT '送货区域',
  `ship_driver_back` varchar(20) DEFAULT NULL COMMENT '回柜司机',
  `ship_driver_back_car_no` varchar(20) DEFAULT NULL COMMENT '回柜车牌',
  `ship_deliver_back_date` timestamp NULL DEFAULT NULL COMMENT '回柜日期',
  `ship_status` int(2) NOT NULL DEFAULT '0' COMMENT '单据状态,0:未审核，1：审核',
  `ship_remark` varchar(600) NOT NULL,
  `ship_inputer` varchar(15) DEFAULT NULL,
  `ship_input_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '填表日期',
  `ship_load_date` timestamp NULL DEFAULT NULL COMMENT '装货日期',
  `ship_arrive_date` timestamp NULL DEFAULT NULL COMMENT '到站日期',
  `ship_reviwer` varchar(15) DEFAULT NULL,
  `ship_reviwer_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ship_id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twms_shipment_main`
--

LOCK TABLES `twms_shipment_main` WRITE;
/*!40000 ALTER TABLE `twms_shipment_main` DISABLE KEYS */;
INSERT INTO `twms_shipment_main` VALUES (98,'IN-20170806-215428-133','昊通物流',NULL,'5229500','4668610','4508206','海口市港澳开发区兴海路19号嘉德物流仓库，张敏18976630343','刘杰文/18907580468','2017-08-06 00:00:00','','',0,NULL,NULL,NULL,0,'红牛,不超重',NULL,'2017-07-31 00:00:00','2017-07-30 00:00:00','2017-08-01 00:00:00',NULL,NULL),(99,'IN-20170806-215428-796','广州丰乔',NULL,'5273113','7572385','','海口秀英区派出所对面','汪茂/13824496469','2017-08-06 00:00:00','','',0,NULL,NULL,NULL,0,'',NULL,'2017-07-31 00:00:00','2017-07-30 00:00:00','2017-08-01 00:00:00',NULL,NULL),(100,'IN-20170806-215428-593','广州丰乔',NULL,'5237943','7229946','','海口秀英区派出所对面','汪茂/13824496469','0000-00-00 00:00:00','','',0,NULL,NULL,NULL,0,'',NULL,'2017-08-01 00:00:00','2017-07-31 00:00:00','2017-08-02 00:00:00',NULL,NULL),(101,'IN-20170806-215428-747','昊通物流',NULL,'5229612','4829844','3615339','海口市港澳开发区兴海路19号嘉德物流仓库，张敏18976630343','刘杰文/18907580468','0000-00-00 00:00:00','','',0,NULL,NULL,NULL,0,'红牛,不超重',NULL,'2017-08-01 00:00:00','2017-07-31 00:00:00','2017-08-02 00:00:00',NULL,NULL);
/*!40000 ALTER TABLE `twms_shipment_main` ENABLE KEYS */;
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
INSERT INTO `twms_user` VALUES (13,'admin','管理员','48309e7da0e9e329c879715f691dd252','2017-08-06 10:42:00','::1',1);
/*!40000 ALTER TABLE `twms_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-06 22:03:31
