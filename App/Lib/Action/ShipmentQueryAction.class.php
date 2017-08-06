<?php

ini_set('display_errors',1);            //错误信息  
ini_set('display_startup_errors',1);    //php启动错误信息  
error_reporting(-1);                    //打印出所有的 错误信息  
ini_set('error_log', dirname(__FILE__).'/error_log.txt'); //将出错信息输出到一个文本文件

import("@.Action.Common");
class ShipmentQueryAction extends AppAction{
    public function index() {
        import("@.ORG.Util.Page");
        $main_model=M("shipment_main");
        $s_keyword = $_GET['keyword'];

        if($_GET["searchBy"]!=""){
            $map[$_GET["searchBy"]]=array("like","%{$s_keyword}%");
        }
		
		if($_GET["ship_customer22"]!=""){
            $map["ship_customer"]=$_GET['ship_customer22'];
            $this->assign("main_ship_customer",$_GET['ship_customer22']);
        }
		
		//填表日期
        if($_GET["ship_input_start"]!=""&&$_GET["ship_input_end"]=="")
        {
            $map["ship_input_date"]=array("egt","{$_GET['ship_input_start']}".' 00:00:00');
            $this->assign("main_ship_input_start",$_GET['ship_input_start']);
        }
        if($_GET["ship_input_start"]==""&&$_GET["ship_input_end"]!="")
        {
            $map["ship_input_date"]=array("elt","{$_GET['ship_input_end']}".' 59:59:59');
            $this->assign("main_ship_input_end",$_GET['ship_input_end']);
        }
        if($_GET["ship_input_start"]!=""&&$_GET["ship_input_end"]!=""){
            $map["ship_input_date"]=array(array("egt","{$_GET['ship_input_start']}".' 00:00:00'),array("elt","{$_GET['ship_input_end']}".' 59:59:59'));
            $this->assign("main_ship_input_start",$_GET['ship_input_start']);
            $this->assign("main_ship_input_end",$_GET['ship_input_end']);
        }
		//送货日期
		if($_GET["ship_deliver_start"]!=""&&$_GET["ship_deliver_end"]=="")
        {
            $map["ship_deliver_date"]=array("egt","{$_GET['ship_deliver_start']}".' 00:00:00');
            $this->assign("main_ship_deliver_start",$_GET['ship_deliver_start']);
        }
        if($_GET["ship_deliver_start"]==""&&$_GET["ship_deliver_end"]!="")
        {
            $map["ship_deliver_date"]=array("elt","{$_GET['ship_deliver_end']}".' 59:59:59');
            $this->assign("main_ship_deliver_end",$_GET['ship_deliver_end']);
        }
        if($_GET["ship_deliver_start"]!=""&&$_GET["ship_deliver_end"]!=""){
            $map["ship_deliver_date"]=array(array("egt","{$_GET['ship_deliver_start']}".' 00:00:00'),array("elt","{$_GET['ship_deliver_end']}".' 59:59:59'));
            $this->assign("main_ship_deliver_start",$_GET['ship_deliver_start']);
            $this->assign("main_ship_deliver_end",$_GET['ship_deliver_end']);
        }
		//回柜日期
		if($_GET["ship_back_start"]!=""&&$_GET["ship_back_end"]=="")
        {
            $map["ship_deliver_back_date"]=array("egt","{$_GET['ship_back_start']}".' 00:00:00');
            $this->assign("main_ship_back_start",$_GET['ship_back_start']);
        }
        if($_GET["ship_back_start"]==""&&$_GET["ship_back_end"]!="")
        {
            $map["ship_deliver_back_date"]=array("elt","{$_GET['ship_back_end']}".' 59:59:59');
            $this->assign("main_ship_back_end",$_GET['ship_back_end']);
        }
        if($_GET["ship_back_start"]!=""&&$_GET["ship_back_end"]!=""){
            $map["ship_deliver_back_date"]=array(array("egt","{$_GET['ship_back_start']}".' 00:00:00'),array("elt","{$_GET['ship_back_end']}".' 59:59:59'));
            $this->assign("main_ship_back_start",$_GET['ship_back_start']);
            $this->assign("main_ship_back_end",$_GET['ship_back_end']);
        }
		
		
        $list=$main_model->where($map)->field('ship_id')->select();
        $count=count($list);
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $shiplist=$main_model->where($map)->order("ship_status asc,ship_id desc")->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign("searchBy",$_GET['searchBy']);
        $this->assign("keyword",$_GET['keyword']);
        $this->assign("list",$shiplist);
        $this->display();
    }
	
    public function delete(){
        $model_main=M("shipment_main");
        $map["ship_id"]=$_GET['ship_id'];
        $model_main->where($map)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("单据删除");
        $this->redirect("index");
    }
	
	//单据复核
    public function doReview(){
        $model_main=M("shipment_main");
        $map["ship_id"]=$_GET['ship_id'];
        $data['ship_status'] = 1;
        $data['ship_reviwer_time'] = date('Y-m-d H:i:s');
        $data['ism_reviwer'] =$_SESSION['user']['user_realname'];
        $model_main->where($map)->save($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("单据审核成功");
        $this->redirect("view",array('ship_id'=>$_GET['ship_id']));
    }

	//查看单据view，应该按照产品型号排序
    public function view(){
        $model_main=M("shipment_main");
        $main=$model_main->join('twms_shipment_domain on ship_deliver_domain=domain_id')->where(array("ship_id"=>$_GET['ship_id']))->find();
        $this->assign("main",$main);
        $this->display();
    }
    public function toEdit(){
        $model_main=M("shipment_main");
        $main=$model_main->where(array("ship_id"=>$_GET['ship_id']))->find();
		
		$model_domain=M("shipment_domain");
		$list_domain=$model_domain->order('domain_name')->select();
		$this->assign('list_domain',$list_domain);
        $this->assign('main',$main);
        $this->display();
    }
    public function doEdit(){
        $model_main=M("shipment_main");
        $model_main->save($_POST);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑出库单据");
        $this->redirect("index");
    }

	//导入excel
	public function importISS(){
		import('@.ORG.Net.UploadFile');
		 $upload = new UploadFile();// 实例化上传类
		 $upload->maxSize=3145728;// 设置附件上传大小
		 $upload->exts=array('xls', 'xlsx');// 设置附件上传类型
		 $upload->savePath  = './Public/Uploads/'; // 设置附件上传（子）目录
		 // 上传文件
		 $upload->saveRule = 'time';// 采用时间戳命名
		 
		 $info=$upload->upload();
		 if(!$info) {// 上传错误提示错误信息
			$this->error("上传失败");
		}else{// 上传成功
			//$this->success('上传成功！');
			$fileinfo=$upload->getUploadFileInfo();
			$file = $fileinfo[0]["savepath"].$fileinfo[0]["savename"];
			vendor("PHPExcel.PHPExcel");
			vendor("PHPExcel.IOFactory");
			$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			if ($extension =='xlsx') {
				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			} else if ($extension =='xls') {
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
			}
			
			try{
				$PHPReader = $objReader->load($file,$encode='utf-8');
			}catch(Exception $e){}
			if(!isset($PHPReader)) return array("error"=>0,'message'=>'read error!');
			
			$sheet = $PHPReader->getSheet(0);
			$highestRow = $sheet->getHighestRow(); // 取得总行数
			$highestColumn = $sheet->getHighestColumn(); // 取得总列数
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			
			$excelData=array();
			for($row=1;$row<=$highestRow;$row++){
				for($col=0;$col<$highestColumnIndex;$col++){
					$cell = $sheet->getCellByColumnAndRow($col,$row)->getValue();
					if(is_object($cell)){
						$cell= $cell->__toString();
					}
					$excelData[$row][] = $cell;
				}
			}
			
			if(trim($excelData[1][0])=='序号'&&trim($excelData[1][1])=='装货日期'&&trim($excelData[1][2])=='单位名称'&&trim($excelData[1][3])=='车号'&&trim($excelData[1][4])=='柜号'&&trim($excelData[1][5])=='柜号'&&trim($excelData[1][6])=='填表日期'&&trim($excelData[1][7])=='收货地址'&&trim($excelData[1][8])=='联系电话'&&trim($excelData[1][9])=='到站日期'&&trim($excelData[1][10])=='送货日期'&&trim($excelData[1][11])=='送货车牌'&&trim($excelData[1][12])=='送货司机'&&trim($excelData[1][13])=='备注'){			
				$this->importToDB($excelData,$highestRow,$highestColumnIndex);
				$this->redirect("ShipmentQuery/index");
			}else{
				$this->error("excel内容问题，请严格按照模板文件整理excel");
			}
		}
	}
	
	public function importToDB($excelData,$highestRow,$highestColumnIndex){
		$model_main=M("shipment_main");
		$formatDate = new PHPExcel_Shared_Date();
		for($row=2;$row<=$highestRow;$row++){
			if($excelData[$row][1]!=NULL){
				$data["ship_load_date"]=date('Y-m-d H:i:s', $formatDate->ExcelToPHP($excelData[$row][1]));
			}else{
				$data["ship_load_date"]="";
			}
			if($excelData[$row][2]!=NULL){
				$data["ship_customer"]=$excelData[$row][2];
			}else{
				$data["ship_customer"]="";
			}
			if($excelData[$row][3]!=NULL){
				$data["ship_car_no"]=$excelData[$row][3];
			}else{
				$data["ship_car_no"]="";
			}
			if($excelData[$row][4]!=NULL){
				$data["ship_box_no1"]=$excelData[$row][4];
			}else{
				$data["ship_box_no1"]="";
			}
			
			
			if($excelData[$row][5]!=NULL){
				$data["ship_box_no2"]=$excelData[$row][5];
			}else{
				$data["ship_box_no2"]="";
			}
			if($excelData[$row][6]!=NULL){			
				$data["ship_input_date"]=date('Y-m-d H:i:s', $formatDate->ExcelToPHP($excelData[$row][6]));
			}else{
				$data["ship_input_date"]="";
			}
			if($excelData[$row][7]!=NULL){
				$data["ship_customer_address"]=$excelData[$row][7];
			}else{
				$data["ship_customer_address"]="";
			}
			if($excelData[$row][8]!=NULL){
				$data["ship_customer_info"]=$excelData[$row][8];
			}else{
				$data["ship_customer_info"]="";
			}
			
			if($excelData[$row][9]!=NULL){
				$data["ship_arrive_date"]=date('Y-m-d H:i:s', $formatDate->ExcelToPHP($excelData[$row][9]));
			}else{
				$data["ship_arrive_date"]="";
			}
			if($excelData[$row][10]!=NULL){
				$data["ship_deliver_date"]=date('Y-m-d H:i:s', $formatDate->ExcelToPHP($excelData[$row][10]));
			}else{
				$data["ship_deliver_date"]="";
			}
			if($excelData[$row][11]!=NULL){
				$data["ship_driver_car_no"]=$excelData[$row][11];
			}else{
				$data["ship_driver_car_no"]="";
			}
			if($excelData[$row][12]!=NULL){
				$data["ship_driver_to"]=$excelData[$row][12];
			}else{
				$data["ship_driver_to"]="";
			}
			if($excelData[$row][13]!=NULL){
				$data["ship_remark"]=$excelData[$row][13];
			}else{
				$data["ship_remark"]="";
			}
			
			$data["ship_sn"]='IN-'.date('Ymd-His-').rand(100,999);
			$model_main->add($data);
		}	
	}
	
	
	//导出excel
    public function exportISS(){

        $s_keyword = $_POST['keyword'];
		
        if($_POST["keyword"]!=""){
            $map[$_POST["searchBy"]]=array("like","%{$s_keyword}%");
        }
		
		if($_POST["main_ship_customer"]!=""){
            $map["ship_customer"]=$_POST["main_ship_customer"];
        }
		
		//填表日期
        if($_POST["main_ship_input_start"]!=""&&$_POST["main_ship_input_end"]=="")
        {
            $map["ship_input_date"]=array("egt","{$_POST['main_ship_input_start']}".' 00:00:00');
        }
        if($_POST["main_ship_input_start"]==""&&$_POST["main_ship_input_end"]!="")
        {
            $map["ship_input_date"]=array("elt","{$_POST['main_ship_input_end']}".' 59:59:59');
        }
        if($_POST["main_ship_input_start"]!=""&&$_POST["main_ship_input_end"]!=""){
            $map["ship_input_date"]=array(array("egt","{$_POST['main_ship_input_start']}".' 00:00:00'),array("elt","{$_POST['main_ship_input_end']}".' 59:59:59'));
        }
		//送货日期
		if($_POST["main_ship_deliver_start"]!=""&&$_POST["main_ship_deliver_end"]=="")
        {
            $map["ship_deliver_date"]=array("egt","{$_POST['main_ship_deliver_start']}".' 00:00:00');
        }
        if($_POST["main_ship_deliver_start"]==""&&$_POST["main_ship_deliver_end"]!="")
        {
            $map["ship_deliver_date"]=array("elt","{$_POST['main_ship_deliver_end']}".' 59:59:59');
        }
        if($_POST["main_ship_deliver_start"]!=""&&$_POST["main_ship_deliver_end"]!=""){
            $map["ship_deliver_date"]=array(array("egt","{$_POST['main_ship_deliver_start']}".' 00:00:00'),array("elt","{$_POST['main_ship_deliver_end']}".' 59:59:59'));
        }
		//回柜日期
		if($_POST["main_ship_back_start"]!=""&&$_POST["main_ship_back_end"]=="")
        {
            $map["ship_deliver_back_date"]=array("egt","{$_POST['main_ship_back_start']}".' 00:00:00');
        }
        if($_POST["main_ship_back_start"]==""&&$_POST["main_ship_back_end"]!="")
        {
            $map["ship_deliver_back_date"]=array("elt","{$_POST['main_ship_back_end']}".' 59:59:59');
        }
        if($_POST["main_ship_back_start"]!=""&&$_POST["main_ship_back_end"]!=""){
            $map["ship_deliver_back_date"]=array(array("egt","{$_POST['main_ship_back_start']}".' 00:00:00'),array("elt","{$_POST['main_ship_back_end']}".' 59:59:59'));
        }
		
        $xlsName  = "货物托运单";
        
		$xlsCell  = array(
			array('ship_customer','收货单位'),
			array('ship_final_address','最终目的地'),
			array('ship_input_date','填表日期'),
			array('ship_car_no','车号'),
			array('ship_box_no1','柜号1'),
			array('ship_box_no2','柜号2'),
			array('ship_customer_address','收货地址'),
			array('ship_customer_info','联系人/电话'),
			array('ship_deliver_date','送货日期'),
			array('ship_driver_to','送货司机'),
			array('ship_driver_car_no','送货车牌'),
			array('domain_name','送货区域'),
			array('domain_price','提成'),
			array('ship_driver_back','回柜司机'),
			array('ship_driver_back_car_no','回柜车牌'),
			array('ship_deliver_back_date','回柜日期'),
			array('ship_sn','流水编号'),
			array('ship_status','单据状态'),
			array('ship_remark','单据备注'),
			array('ship_inputer','制单员')
		);
        $filed = 'ship_customer,ship_final_address,DATE_FORMAT(ship_input_date,"%Y-%m-%d") ship_input_date,ship_car_no,ship_box_no1,ship_box_no2,ship_customer_address,ship_customer_info,DATE_FORMAT(ship_deliver_date,"%Y-%m-%d") ship_deliver_date,ship_driver_to,ship_driver_car_no,domain_name,domain_price,ship_driver_back,ship_driver_back_car_no,DATE_FORMAT(ship_deliver_back_date,"%Y-%m-%d") ship_deliver_back_date,ship_sn,CASE WHEN ship_status =0 THEN  "未审核" WHEN ship_status =1 THEN  "已审核" END ship_status,ship_remark,ship_inputer';

		$model_main=M("shipment_main");
        $main=$model_main->join('twms_shipment_domain on ship_deliver_domain=domain_id')->where($map)->Field($filed)->order('ship_id')->select();
		
        $common = new CommonAction();
        $common->exportExcel($xlsName,$xlsCell,$main);

    }

}
?>