<?php

class InstallAction extends Action{
    public function index() {
        $this->assign("step",'0');
        $this->display();
    }
    public function step1() {
        $this->assign("step",'1');
        $this->display('index');
    }
    public function step2() {
        if(!$conn=mysql_connect($_POST['db_host'],$_POST['db_username'],$_POST['db_password'])){
            $this->error('鏁版嵁搴撳笎鍙锋垨瀵嗙爜涓嶆纭�');
            die;
        }
        if(mysql_select_db($_POST['db_name'])==false &&$_POST['autoCreateDb']==null){
            $this->error('姝ゆ暟鎹簱鍚嶄笉瀛樺湪');
            die;
        }
        session_start();
        $_SESSION['db_name']=trim($_POST['db_name']);
        $_SESSION['db_username']=trim($_POST['db_username']);
        $_SESSION['db_password']=trim($_POST['db_password']);
        $_SESSION['db_host']=trim($_POST['db_host']);
        $_SESSION['db_port']=trim($_POST['db_port']);
        $file_array[0]="<?php return array('URL_MODEL'=>3";
        $file_array[1]="'DB_TYPE'=>'mysql'";
        $file_array[2]="'DB_HOST'=>'{$_SESSION['db_host']}'";
        $file_array[3]="'DB_NAME'=>'{$_SESSION['db_name']}'";
        $file_array[4]="'DB_USER'=>'{$_SESSION['db_username']}'";
        $file_array[5]="'DB_PWD'=>'{$_SESSION['db_password']}'";
        $file_array[6]="'DB_PORT'=>'{$_SESSION['db_port']}'";
        $file_array[7]="'DB_PREFIX'=>'twms_'";
        $file_array[8]="'DB_FIELDS_CACHE' =>false";
        $file_array[9]="'PAGE_SIZE'=>15";
        $file_array[10]="'INDEX_NOTICE_PAGE_SIZE'=>8);?>";
        $file_string=implode(',',$file_array);
        $file=fopen(APP_PATH.'/Conf/config.php','w+');
        fwrite($file,$file_string);
        fclose($file);
        $sqlArray=explode(';',$this->getSql($_POST['db_name']));
        foreach($sqlArray as $one){
            mysql_query($one);
        }
        $this->assign("step",'2');
        $this->display('index');
    }
    public function step3() {
        $data['user_name']=trim($_POST['user_name']);
        $data['user_password']=trim($_POST['user_password']);
        $data['user_realname']=trim($_POST['user_realname']);
        $data['user_type']=1;
        mysql_connect($_SESSION['db_host'],$_SESSION['db_username'],$_SESSION['db_password']);
        mysql_select_db($_SESSION['db_name']);
        mysql_query('set names utf8');
        $prefix=C('DB_PREFIX');
        $sql="select * from ".$prefix."user where user_name='".$data['user_name']."'";
        $rs=mysql_query($sql);
        $list=mysql_fetch_array($rs);
        if($list==null){
            $sql="delete from ".$prefix."user where user_name='".$data['user_name']."'";
            mysql_query($sql);
            $sql="insert into ".$prefix."user (user_name,user_password,user_realname,user_type) values ('".$data['user_name']."',md5('".$data['user_password']."'),'".$data['user_realname']."',1)";
        }else{
            $sql="update ".$prefix."user set user_password=md5('".$data['user_password']."'),user_realname='".$data['user_realname']."' where user_name='".$data['user_name']."'";
        }
        mysql_query($sql);
        $this->assign("step",'3');
        $this->display('index');
    }
    public function step4() {
        unlink(APP_PATH.'/Lib/Action/InstallAction.class.php');
        $this->redirect('Index/index');
    }
    private function getSql($db_name){
        $sql="		set names utf8;
		create database if not exists $db_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		use $db_name;
		SET FOREIGN_KEY_CHECKS=0;

		-- ----------------------------
		-- Table structure for `twms_backup`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_backup`;
		CREATE TABLE `twms_backup` (
		  `back_id` int(11) NOT NULL AUTO_INCREMENT,
		  `back_name` varchar(50) DEFAULT NULL,
		  `back_path` varchar(100) DEFAULT NULL,
		  `back_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`back_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_backup
		-- ----------------------------
		
		-- ----------------------------
		-- Table structure for `twms_guest`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_guest`;
		CREATE TABLE `twms_guest` (
		  `gust_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `gust_name` varchar(15) DEFAULT NULL,
		  `gust_comfullname` varchar(50) DEFAULT NULL,
		  `gust_address` varchar(50) DEFAULT NULL,
		  `gust_phone` varchar(20) DEFAULT NULL,
		  PRIMARY KEY (`gust_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_guest
		-- ----------------------------
		INSERT INTO `twms_guest` VALUES ('1', '骞垮崕闆嗗洟', '骞垮崕闆嗗洟', '骞垮窞', '020-59872901');
		INSERT INTO `twms_guest` VALUES ('2', '娣卞寲闆嗗洟', '娣卞寲闆嗗洟', '娣卞湷', '0755-28763981');
		INSERT INTO `twms_guest` VALUES ('3', '鐝犳捣鍗庡潳', '鐝犳捣鍗庡潳', '鐝犳捣', '0756-88098011');
		
		-- ----------------------------
		-- Table structure for `twms_instore_main`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_instore_main`;
		CREATE TABLE `twms_instore_main` (
		  `ism_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `ism_sn` varchar(30) DEFAULT NULL,
		  `ism_operator` varchar(15) DEFAULT NULL,
		  `ism_writer` varchar(15) DEFAULT NULL,
		  `ism_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  `ism_phone` varchar(20) DEFAULT NULL,
		  `ism_contactor` varchar(15) DEFAULT NULL,
		  `ism_sellerunit` varchar(30) DEFAULT NULL,
		  `ism_total` float(10,0) DEFAULT NULL,
		  PRIMARY KEY (`ism_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
		
		-- ----------------------------
		-- Records of twms_instore_main
		-- ----------------------------
		INSERT INTO `twms_instore_main` VALUES ('22', 'IN-20120411-194539-992', '鍏ヨ揣缁忓姙浜�', '绠＄悊鍛�', '2012-04-11 19:45:50', '鑱旂郴鐢佃瘽', null, '鍗栨柟鍗曚綅', '32900');
		INSERT INTO `twms_instore_main` VALUES ('21', 'IN-20120411-194521-560', '鍏ヨ揣缁忓姙浜�', '绠＄悊鍛�', '2012-04-11 19:45:36', '鑱旂郴鐢佃瘽', null, '鍗栨柟鍗曚綅', '12000');
		INSERT INTO `twms_instore_main` VALUES ('20', 'IN-20120411-194502-551', '鍏ヨ揣缁忓姙浜�', '绠＄悊鍛�', '2012-04-11 19:45:18', '鑱旂郴鐢佃瘽', null, '鍗栨柟鍗曚綅', '10750');
		INSERT INTO `twms_instore_main` VALUES ('23', 'IN-20120511-194848-178', '鍏ヨ揣缁忓姙浜�', '绠＄悊鍛�', '2012-05-11 19:49:04', '鑱旂郴鐢佃瘽', null, '鍗栨柟鍗曚綅', '16000');
		
		-- ----------------------------
		-- Table structure for `twms_instore_sub`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_instore_sub`;
		CREATE TABLE `twms_instore_sub` (
		  `iss_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `iss_mainid` int(11) DEFAULT NULL,
		  `iss_prod` int(11) DEFAULT NULL,
		  `iss_prodname` varchar(50) DEFAULT NULL,
		  `iss_cate` int(11) DEFAULT NULL,
		  `iss_price` float(11,0) DEFAULT NULL,
		  `iss_count` float(11,0) DEFAULT NULL,
		  `iss_total` float(11,0) DEFAULT NULL,
		  `iss_store` int(11) DEFAULT NULL,
		  `iss_remark` varchar(300) DEFAULT NULL,
		  `iss_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`iss_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_instore_sub
		-- ----------------------------
		INSERT INTO `twms_instore_sub` VALUES ('53', '20', '11', 'HTC G11', '1', '2150', '4', '8600', '3', '', '2012-04-11 19:47:11');
		INSERT INTO `twms_instore_sub` VALUES ('54', '21', '16', 'HTC G14', '1', '2400', '4', '9600', '3', '', '2012-04-11 19:47:24');
		INSERT INTO `twms_instore_sub` VALUES ('56', '22', '9', 'iphone4s', '1', '4700', '5', '23500', '3', '', '2012-05-11 19:51:30');
		INSERT INTO `twms_instore_sub` VALUES ('57', '23', '1', '涓夋槦001', '1', '2000', '8', '16000', '3', '', '2012-05-11 19:49:04');
		
		-- ----------------------------
		-- Table structure for `twms_log`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_log`;
		CREATE TABLE `twms_log` (
		  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `log_operator_name` varchar(20) DEFAULT NULL,
		  `log_operator_realname` varchar(20) DEFAULT NULL,
		  `log_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `log_action` varchar(30) DEFAULT NULL,
		  `log_ip` varchar(20) DEFAULT NULL,
		  PRIMARY KEY (`log_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=432 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_log
		-- ----------------------------
		INSERT INTO `twms_log` VALUES ('430', 'admin', '绠＄悊鍛�', '2012-05-12 12:16:45', '鐢ㄦ埛鐧诲綍', '127.0.0.1');
		INSERT INTO `twms_log` VALUES ('431', 'admin', '绠＄悊鍛�', '2012-04-13 04:39:58', '鐢ㄦ埛鐧诲綍', '127.0.0.1');
		INSERT INTO `twms_log` VALUES ('429', 'admin', '绠＄悊鍛�', '2012-05-12 06:52:02', '鐢ㄦ埛鐧诲綍', '127.0.0.1');
		INSERT INTO `twms_log` VALUES ('427', 'admin', '绠＄悊鍛�', '2012-05-11 22:11:41', '鐢ㄦ埛鐧诲綍', '127.0.0.1');
		INSERT INTO `twms_log` VALUES ('428', 'admin', '绠＄悊鍛�', '2012-05-11 22:11:55', '鐢ㄦ埛鐧诲綍', '127.0.0.1');
		INSERT INTO `twms_log` VALUES ('426', 'user', '鏉庡洓', '2012-05-11 22:09:06', '鐢ㄦ埛鐧诲綍', '127.0.0.1');
		
		-- ----------------------------
		-- Table structure for `twms_notice`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_notice`;
		CREATE TABLE `twms_notice` (
		  `ntc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `ntc_title` varchar(200) DEFAULT NULL,
		  `ntc_content` varchar(1000) DEFAULT NULL,
		  `ntc_author` varchar(15) DEFAULT NULL,
		  `ntc_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`ntc_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_notice
		-- ----------------------------
		INSERT INTO `twms_notice` VALUES ('1', '4瀵稿睆+鏈€寮哄弻鏍�1.5GHz 灏忕背鎵嬫満鐜板満閫熻瘎', '4瀵稿睆+鏈€寮哄弻鏍�1.5GHz 灏忕背鎵嬫満鐜板満閫熻瘎', '鐜嬩簲', '2011-08-20 15:24:06');
		INSERT INTO `twms_notice` VALUES ('2', 'Altek T8680涓嶈冻900', '渚ф粦QWERTY鏅鸿兘 HTC S610d鐙鐪熸満鍥捐祻渚ф粦QWERTY鏅鸿兘 HTC S610d鐙鐪熸満鍥捐祻渚ф粦QWERTY鏅鸿兘 HTC S610d鐙鐪熸満鍥捐祻2222', '鐜嬩簲', '2012-04-06 07:24:24');
		INSERT INTO `twms_notice` VALUES ('3', '浠婃棩鏂拌繘骞虫澘鐢佃剳1000鍙�', '浠婃棩鏂拌繘骞虫澘鐢佃剳1000鍙�', '鏉庡洓', '2011-11-16 06:12:51');
		INSERT INTO `twms_notice` VALUES ('4', '18鏃ヨ储鍔＄粨绠�', '18鏃ヨ储鍔＄粨绠�', '鏉庡洓', '2012-04-05 00:47:30');
		INSERT INTO `twms_notice` VALUES ('8', '鑱旀兂鏅鸿兘鐢佃4鏈�10鏃ラ鍞� 瀹氫环6499鍏�', '鎹倝锛岃仈鎯崇數瑙嗛鎵逛笂甯傚垎涓�42瀵镐骇鍝並71鍜�55瀵镐骇鍝並91涓や釜鍨嬪彿銆傚叾涓璌71灏嗗湪鑱旀兂瀹樻柟缃戜笂鍟嗗煄銆佽仈鎯虫窐瀹濇棗鑸板簵銆佷含涓滐紝鑻忓畞鏄撹喘绛夌綉绔欏惎鍔ㄩ鍞紝鍞环涓�6499鍏冿紝鑱旀兂鏆傛椂鏈叕甯�55瀵镐骇鍝並91鐨勫敭浠峰強棰勫敭鏃堕棿銆傝仈鎯矺71鏅鸿兘鐢佃閲囩敤楂橀€歋napdragon鍙屾牳1.5GHz澶勭悊鍣ㄣ€丄ndroid 4.0绯荤粺銆�500涓囧儚绱犳憚鍍忓ご銆�42鑻卞1080P鍏ㄩ珮娓�3D LED鏄剧ず灞忥紝鍐呯疆鑱旀兂搴旂敤鍟嗗簵銆佽棰戠偣鎾璙OD锛屾敮鎸佽闊虫搷鎺с€乄IFI缃戠粶銆佷綋鎰熷強澶у瀷娓告垙銆�', '绠＄悊鍛�', '2012-04-08 07:16:39');
		INSERT INTO `twms_notice` VALUES ('10', '2999鍏冭秴鍊兼姠璐� LG娑叉櫠TV浠锋牸鍒涙柊浣�', '铏界劧娌℃湁鍔犲叆杩囧鐨勬樉绀烘妧鏈紝浣嗘槸LG 42LK460-CC娑叉櫠鐢佃骞舵病鏈夊洜姝ゅけ鍘诲競鍦虹珵浜夊姏锛岄€氳繃鍏ㄩ珮娓匢PS纭睆鐨勫姞鍏ワ紝LG 42LK460-CC娑叉櫠鐢佃鏈夋晥鎻愬崌浜嗙敾闈㈢殑鍔ㄦ€佹樉绀烘晥鏋滐紝甯潃鐢ㄦ埛鎽嗚劚浜嗗姩鎬佹畫褰辩殑鍥版壈銆�    鍙﹀锛孡G 42LK460-CC娑叉櫠鐢佃杩樺浜у搧鑷韩鐨勫ū涔愬姛鑳借繘琛屼簡鏀瑰杽鍜屾彁鍗囷紝鐗瑰埆鏄祦濯掍綋鎾斁鍔熻兘鐨勫姞鍏ユ洿鏄负鐢ㄦ埛鎻愪緵浜嗕富娴佽棰戞枃浠剁殑鎾斁锛岃€岃繖涔熸槸鍦ㄤ互寰€鐨凩G浜у搧涓笉澶氳鐨勩€�', '绠＄悊鍛�', '2012-04-08 07:18:44');
		INSERT INTO `twms_notice` VALUES ('11', '浠庢父鎴忔€吔鍒版瀬鑷磋交钖� 鐪媂PS鐨勫墠涓栦粖鐢�', '鍦ㄦ垜浠殑鍗拌薄涓紝寰堝皯鏈夐偅涔堜竴涓瑪璁版湰绯诲垪锛岃兘鍦ㄥ浜у搧瀹氫綅鏁版杩涜鈥滀咕鍧ゅぇ鎸Щ鈥濅箣鍚庯紝杩樿兘鎸佺画鑾峰緱娑堣垂鑰呯殑鍏虫敞鍜岄潚鐫愩€備粠鍏勾鍓嶇殑娓告垙鍒╁櫒銆佸埌浠婂ぉ鐨勬瀬鑷磋交钖勶紝XPS 绯诲垪鐨勮法搴︿箣澶т护浜洪毦浠ユ兂璞°€備絾缁嗙粏鍝佸懗涔嬪悗鎴戜滑鍙戠幇锛岃繖涔熸槸椤哄簲娼祦涔嬪彉銆傘€€銆€鎴村皵鍦ㄥぇ闄嗘寮忓彂鍞殑绗竴娆� XPS 绗旇鏈紝鍚嶄负 XPS M1710 绯诲垪锛屽畠鎷ユ湁 17 鑻卞鍏ㄩ珮娓呮樉绀哄睆銆丯APA 骞冲彴銆�7950GTX 鏄惧崱锛屽敭浠蜂笁涓囦簲锛屽綋骞撮《绾ч厤缃殑鏈虹殗锛岀幇鍦ㄧ湅鐫€绠€鐩村急鐖嗕簡銆傘€€銆€鎴戜滑涔嬫墍浠ヨ繖涔堢湅閲� M1710 鐨勬€ц兘锛屽彧鍥犱负瀹冩槸 XPS锛屽緢闀夸竴娈垫椂闂撮噷锛孹PS 灏辨槸楂樻€ц兘 PC 鐨勪唬琛紝涔熸槸鎴村皵鍦ㄩ珮绔彂鐑� PC 棰嗗煙鐨勫舰璞′唬瑷€锛屽畠缁欑敤鎴风殑鍗拌薄閫氬父鏄繖鏍风殑锛氶噹铔笖鑲岃倝鎰熷崄瓒崇殑澶栬銆侀噹鍏借埇鐨勬€ц兘銆佷笉璁℃垚鏈殑鐢ㄦ枡浠ュ強璁╀汉鏈涜€屽嵈姝ョ殑鍞环锛岃€岀幇鍦ㄧ殑 XPS 缁忓巻浜嗚嫢骞叉婕斿彉锛屽凡缁忓畬鍏ㄤ笉鍚屼簡銆�', '绠＄悊鍛�', '2012-04-08 07:21:25');
		INSERT INTO `twms_notice` VALUES ('12', '64G Win7骞虫澘涓嶅埌3K 绁炶垷椋炲ぉA10棣栨祴', '灏界鏃朵笅瓒呮瀬鏈鍙楄拷鎹э紝鍙湪浠ュ钩鏉跨數鑴戙€佹櫤鑳芥墜鏈轰负涓荤殑绉诲姩甯傚満锛岃嫳鐗瑰皵鐩墠杩樻病鏈変粈涔堝お濂界殑琛ㄧ幇锛岄噰鐢╓indows绯荤粺鐨勫钩鏉夸篃鍗佸垎绋€缂猴紝涓嶈繃杩欏苟涓嶈兘璇存槑Wintel澶卞幓浜嗗競鍦轰环鍊笺€傚疄闄呬笂锛岃繖涓垜浠渶鐔熸倝銆佹渶涔犳儻鐨勯樀钀ュ湪骞虫澘鐢佃剳涓婃湁鐫€骞块様鐨勫彂灞曠┖闂达紝鎴戞兂杩欏氨鏄鑸熼澶〢10璇炵敓鐨勭紭鐢便€�    涓囦簨闇€瑕佷袱闈㈡潵鐪嬶紝灏界鐩墠Wintel骞虫澘铏界劧涓嶅锛屼絾鍚屾牱鏈夌潃鑷韩鐨勪竴浜涗紭鍔裤€傝濡傚€熷姪鑻辩壒灏旂Щ鍔ㄥ鐞嗗櫒锛屽钩鏉跨數鑴戠殑鏁翠綋鎬ц兘灏嗘彁鍗囦竴涓。娆★紱鍏舵锛屽井杞疻indows鎿嶄綔绯荤粺娣卞叆浜哄績锛屼笖瑕嗙洊浜嗗ぇ鑼冨洿鐨勫ū涔愩€佸晢鏀裤€佽涓氬簲鐢紝瀵逛簬鐢ㄦ埛鑰岃█涓婃墜鎵€闇€鐨勬垚鏈緝浣庯紝鏇撮噸瑕佺殑鏄疻indows鍚屾牱鏈夌潃娴烽噺鐨勫簲鐢ㄧ▼搴忥紝涓斿凡琚垜浠墍鐔熸倝銆�    Wintel鏋舵瀯閲嶈繑骞虫澘涓栫晫锛岀浉淇indows 7鍙槸涓€涓繃娓★紝涓嶄箙鍚庣殑Windows 8鎵嶆槸鍏抽敭銆傜鑸熺數鑴戣懀浜嬮暱鍚存捣鍐涘湪鏂板搧鍙戝竷浼氭寚鍑猴紝鈥淲indows 8骞虫澘鐢佃剳灏嗕細鎴愪负鏈潵骞虫澘鐨勪富娴佲€濄€傚綋鐒讹紝濡傛灉鏈夋潯浠剁殑璇濓紝鍙互鍦ㄩ澶〢10涓婂畨瑁匴indows 8娑堣垂鑰呴瑙堢増锛岀浉淇′綋楠屼細鏇村ソ锛岃繖涔熸槸鎴戜滑鎺ヤ笅鏉ヨ鍋氱殑浜嬫儏銆�', '绠＄悊鍛�', '2012-04-08 07:31:29');
		INSERT INTO `twms_notice` VALUES ('13', '鎽勫奖鐖卞ソ鑰呯洓瀹� 浣宠兘涔濇鍗曞弽閫夎喘鎺ㄨ崘', '鍦ㄥ崟鍙嶇浉鏈洪鍩燂紝浣宠兘鎷ユ湁姣嬪缃枒鐨勫疄鍔涳紝鍓嶄笉涔呬匠鑳藉彂甯冩渶鏂板崟鍙�5D3銆傜幇鍦ㄥ競鍦轰笂鍏辨湁9娆句節娆惧崟鍙嶅湪鍞紝闃靛鍙皳绌哄墠寮哄ぇ銆備篃璁告偍杩戞湡姝ｆ湁璐拱浣宠兘鍗曞弽鐨勮鍒掞紝涓嬮潰绗旇€呭氨缁欏ぇ瀹惰缁嗕粙缁嶄竴涓嬭繖鍑犳鏈哄瀷銆傞珮鎬т环姣斿叆闂ㄥ崟鍙嶏細浣宠兘550D銆€銆€铏界劧鐩墠浣宠兘鍏ラ棬绾у崟鍙嶇殑鏈€鏂板瀷鍙锋槸EOS 600D锛屼笉杩囦笂浠ｆ満鍨�550D鍦ㄦ€ц兘閰嶇疆涓婁篃骞惰惤浼嶃€傚畠鎷ユ湁1800涓囧儚绱犵殑鎴愬儚鑳藉姏锛屼篃鍏峰1080P鐨勯珮娓呰棰戝綍鍒跺姛鑳斤紝骞惰澶囦簡3鑻卞楂樼簿搴︽恫鏅舵樉绀哄睆銆傜洰鍓嶏紝浣宠兘550D鎼厤EF-S 18-55mm F3.5-5.6 IS闃叉姈闀滃ご鐨勫鏈烘渶鏂颁环鏍间粎涓�4220鍏冿紝鎷ユ湁鏋侀珮鐨勬€т环姣斻€�', '绠＄悊鍛�', '2012-04-08 07:32:51');
		INSERT INTO `twms_notice` VALUES ('14', '绾犵粨鎺㈣ 鐢卞甯︽彁閫熸槧灏凷SD瀵垮懡璁�', '浠庡幓骞翠腑鏃紑濮嬶紝鍥藉唴鐨勫ぇ灏忓煄甯傞檰缁紑濮嬬潃瀹跺涵缃戠粶鎻愰€熴€備互鍖椾含涓轰緥锛岃繎2涓湀鐨勬椂闂磋仈閫欰DSL宸插皢鍘熸湁鐨�2M4M鍏嶈垂鍗囩骇涓�10M鍏夐拵锛屽師鏈夌殑10M鍒欏崌绾т负20M锛屾剰鍛崇潃涓€閮�1080P楂樻竻鐢靛奖鍙渶瑕佷笉鍒�2灏忔椂鐨勬椂闂翠究鍙互涓嬭浇瀹屾瘯锛屽姝ゅぇ鐨勪笅杞藉啓鍏ュ啀娆″皢鎴戜滑涓嶆効閲嶅鎻愯捣鐨勫浐鎬佺‖鐩樺鍛介棶棰樻惉浜嗗嚭鏉ャ€�    涓嬭浇绌剁珶浼や笉浼ょ‖鐩樼殑鏁呬簨娴佷紶鑷充粖宸茬粡鏈夊彛闅捐京浜嗭紝鎴戜滑鏆備笖灏卞綋瀹冧笉浼ゅ惂銆傚彲褰撴瘡涓汉閮藉皢鎷ユ湁2MB', '绠＄悊鍛�', '2012-04-08 07:33:19');
		
		-- ----------------------------
		-- Table structure for `twms_outstore_main`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_outstore_main`;
		CREATE TABLE `twms_outstore_main` (
		  `osm_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `osm_sn` varchar(30) DEFAULT NULL,
		  `osm_buyerunit` varchar(40) DEFAULT NULL,
		  `osm_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  `osm_operator` varchar(20) DEFAULT NULL,
		  `osm_phone` varchar(30) DEFAULT NULL,
		  `osm_writer` varchar(15) DEFAULT NULL,
		  `osm_total` float DEFAULT NULL,
		  `osm_inmainid` int(11) DEFAULT NULL COMMENT '寮曠敤鐨勫叆浠撲富琛╥d',
		  PRIMARY KEY (`osm_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_outstore_main
		-- ----------------------------
		INSERT INTO `twms_outstore_main` VALUES ('18', 'OU-20120511-195123-732', '涔版柟鍗曚綅', '2012-05-11 19:51:30', '鍑鸿揣缁忓姙浜�', '鑱旂郴鐢佃瘽', '绠＄悊鍛�', '4700', '0');
		INSERT INTO `twms_outstore_main` VALUES ('17', 'OU-20120411-194726-907', '涔版柟鍗曚綅', '2012-04-11 19:47:36', '鍑鸿揣缁忓姙浜�', '鑱旂郴鐢佃瘽', '绠＄悊鍛�', '4700', '0');
		INSERT INTO `twms_outstore_main` VALUES ('16', 'OU-20120411-194712-419', '涔版柟鍗曚綅', '2012-04-11 19:47:24', '鍑鸿揣缁忓姙浜�', '鑱旂郴鐢佃瘽', '绠＄悊鍛�', '2400', '0');
		INSERT INTO `twms_outstore_main` VALUES ('15', 'OU-20120411-194658-572', '涔版柟鍗曚綅', '2012-04-11 19:47:11', '鍑鸿揣缁忓姙浜�', '鑱旂郴鐢佃瘽', '绠＄悊鍛�', '2150', '0');
		
		-- ----------------------------
		-- Table structure for `twms_outstore_sub`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_outstore_sub`;
		CREATE TABLE `twms_outstore_sub` (
		  `oss_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `oss_prod` int(11) DEFAULT NULL,
		  `oss_prodname` varchar(50) DEFAULT NULL,
		  `oss_cate` int(11) DEFAULT NULL,
		  `oss_count` int(11) DEFAULT NULL,
		  `oss_price` float(10,0) DEFAULT NULL,
		  `oss_total` float(10,0) DEFAULT NULL,
		  `oss_store` int(11) DEFAULT NULL,
		  `oss_remark` varchar(300) DEFAULT NULL,
		  `oss_mainid` int(11) DEFAULT NULL,
		  `oss_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `oss_insubid` int(11) DEFAULT NULL COMMENT '寮曠敤鐨勫叆浠撳瓙琛╥d',
		  PRIMARY KEY (`oss_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
		
		-- ----------------------------
		-- Records of twms_outstore_sub
		-- ----------------------------
		INSERT INTO `twms_outstore_sub` VALUES ('19', '9', 'iphone4s', '1', '1', '4700', '4700', '3', '', '18', '2012-05-11 19:51:30', '56');
		INSERT INTO `twms_outstore_sub` VALUES ('18', '9', 'iphone4s', '1', '1', '4700', '4700', '3', '', '17', '2012-04-11 19:47:36', '56');
		INSERT INTO `twms_outstore_sub` VALUES ('17', '16', 'HTC G14', '1', '1', '2400', '2400', '3', '', '16', '2012-04-11 19:47:24', '54');
		INSERT INTO `twms_outstore_sub` VALUES ('16', '11', 'HTC G11', '1', '1', '2150', '2150', '3', '', '15', '2012-04-11 19:47:11', '53');
		
		-- ----------------------------
		-- Table structure for `twms_product`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_product`;
		CREATE TABLE `twms_product` (
		  `prod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `prod_name` varchar(30) DEFAULT NULL,
		  `prod_price` int(11) DEFAULT NULL,
		  `prod_count` int(11) DEFAULT NULL,
		  `prod_cate` int(11) DEFAULT NULL,
		  PRIMARY KEY (`prod_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_product
		-- ----------------------------
		INSERT INTO `twms_product` VALUES ('1', '涓夋槦001', '2000', '0', '1');
		INSERT INTO `twms_product` VALUES ('2', '瀹忕001', '3500', '0', '2');
		INSERT INTO `twms_product` VALUES ('3', '绁炶垷鐏甸泤', '1999', '0', '3');
		INSERT INTO `twms_product` VALUES ('4', '瀹忕002', '3500', '0', '2');
		INSERT INTO `twms_product` VALUES ('5', '涓夋槦002', '3000', '0', '1');
		INSERT INTO `twms_product` VALUES ('6', 'TEN2', '1500', '1000', '5');
		INSERT INTO `twms_product` VALUES ('7', '灏忕背', '1999', null, '1');
		INSERT INTO `twms_product` VALUES ('8', '榄呮棌MX', '2600', null, '1');
		INSERT INTO `twms_product` VALUES ('9', 'iphone4s', '4700', null, '1');
		INSERT INTO `twms_product` VALUES ('11', 'HTC G11', '2150', null, '1');
		INSERT INTO `twms_product` VALUES ('12', '涓夋槦GALAXY', '4680', null, '1');
		INSERT INTO `twms_product` VALUES ('13', '钃濋瓟w19', '999', null, '5');
		INSERT INTO `twms_product` VALUES ('14', '鐩涘ぇ鎵嬫満', '1199', null, '1');
		INSERT INTO `twms_product` VALUES ('15', '璇哄熀浜歂9', '2700', null, '1');
		INSERT INTO `twms_product` VALUES ('16', 'HTC G14', '2400', null, '1');
		
		-- ----------------------------
		-- Table structure for `twms_prod_cate`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_prod_cate`;
		CREATE TABLE `twms_prod_cate` (
		  `pdca_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `pdca_name` varchar(30) DEFAULT NULL,
		  PRIMARY KEY (`pdca_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_prod_cate
		-- ----------------------------
		INSERT INTO `twms_prod_cate` VALUES ('1', '鎵嬫満');
		INSERT INTO `twms_prod_cate` VALUES ('2', '绗旇鏈�');
		INSERT INTO `twms_prod_cate` VALUES ('3', '骞虫澘鐢佃剳');
		INSERT INTO `twms_prod_cate` VALUES ('5', 'MID');
		
		-- ----------------------------
		-- Table structure for `twms_store`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_store`;
		CREATE TABLE `twms_store` (
		  `sto_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `sto_name` varchar(20) DEFAULT NULL,
		  `sto_address` varchar(50) DEFAULT NULL,
		  `sto_storer` varchar(15) DEFAULT NULL,
		  `sto_phone` varchar(20) DEFAULT NULL,
		  PRIMARY KEY (`sto_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_store
		-- ----------------------------
		INSERT INTO `twms_store` VALUES ('3', '骞垮窞浠撳簱', '骞垮窞', '寮犱笁', '020-98769851');
		INSERT INTO `twms_store` VALUES ('4', '娣卞湷浠撳簱', '娣卞湷', '鏉庡洓', '0755-8729571');
		INSERT INTO `twms_store` VALUES ('7', '涓滆帪浠撳簱', '涓滆帪', '鐜嬩簲', '0767-9999999');
		
		-- ----------------------------
		-- Table structure for `twms_user`
		-- ----------------------------
		DROP TABLE IF EXISTS `twms_user`;
		CREATE TABLE `twms_user` (
		  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `user_name` varchar(20) DEFAULT NULL,
		  `user_realname` varchar(20) DEFAULT NULL,
		  `user_password` varchar(32) DEFAULT NULL,
		  `user_lastlogindate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  `user_lastloginip` varchar(20) DEFAULT NULL,
		  `user_type` int(5) DEFAULT NULL,
		  PRIMARY KEY (`user_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
		
		-- ----------------------------
		-- Records of twms_user
		-- ----------------------------
		INSERT INTO `twms_user` VALUES ('13', 'admin', '绠＄悊鍛�', '21232f297a57a5a743894a0e4a801fc3', '2012-04-13 04:39:58', '127.0.0.1', '1');
		INSERT INTO `twms_user` VALUES ('15', 'user', '鏉庡洓', 'ee11cbb19052e40b07aac0ca060c23ee', '2012-05-11 22:09:06', '127.0.0.1', '2');
			";
        return $sql;
    }
}
?>