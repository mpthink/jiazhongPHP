DROP TABLE IF EXISTS `twms_shipment_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_shipment_main` (
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