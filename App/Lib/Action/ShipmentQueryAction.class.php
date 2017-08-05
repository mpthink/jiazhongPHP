<?php

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