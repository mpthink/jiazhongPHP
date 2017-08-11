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
  
  `ship_status` int(2) NOT NULL DEFAULT 0 COMMENT '单据状态,0:未审核，1：审核',
  
  `ship_remark` varchar(600) NOT NULL,
  `ship_inputer` varchar(15) DEFAULT NULL,
  `ship_input_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '填表日期',
  `ship_load_date` timestamp NULL COMMENT '装货日期',
  `ship_arrive_date` timestamp NULL DEFAULT NULL COMMENT '到站日期',
  `ship_reviwer` varchar(15) DEFAULT NULL,
  `ship_reviwer_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ship_id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


DROP TABLE IF EXISTS `twms_shipment_domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_shipment_domain` (
  `domain_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(30) DEFAULT NULL,
  `domain_price` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`domain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `twms_shipment_driver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twms_shipment_driver` (
  `driver_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(30) DEFAULT NULL,
  `driver_car_no` varchar(20) DEFAULT NULL,
  `driver_note` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`driver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;