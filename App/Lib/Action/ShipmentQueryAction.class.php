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
        if(strstr($s_keyword,'已勾')){
            $s_keyword = 1;
        }elseif(strstr($s_keyword,'未勾')){
            $s_keyword = 0;
        }elseif(strstr($s_keyword,'复核')){
            $s_keyword = 2;
        }elseif(strstr($s_keyword,'未提')){
            $s_keyword = -1;
        }
        if($_POST["keyword"]!=""){
            $map[$_POST["searchBy"]]=array("like","%{$s_keyword}%");
        }

        if($_POST["in_sellerunit"]!=""){
            $map["b.ism_sellerunit"]=array("like","%{$_POST['in_sellerunit']}%");
        }
        if($_POST["in_danju_no"]!=""){
            $map["b.ism_danju_no"]=array("like","%{$_POST['in_danju_no']}%");
        }
        if($_POST["in_prodname"]!=""){
            $map["a.iss_prodname"]=array("like","%{$_POST['in_prodname']}%");
        }

        if($_POST["in_status"]!=""){
            $map["b.ism_status"]=$_POST['in_status'];
        }
        if($_POST["in_store"]!=""){
            $map["c.sto_name"]=array("like","%{$_POST['in_store']}%");
        }
        if($_POST["in_date_start"]!=""&&$_POST["in_date_end"]=="")
        {
            $map["b.ism_date"]=array("egt","{$_POST["in_date_start"]}".' 00:00:00');
        }
        if($_POST["in_date_start"]==""&&$_POST["in_date_end"]!="")
        {
            $map["b.ism_date"]=array("elt","{$_POST["in_date_end"]}".' 59:59:59');
        }
        if($_POST["in_date_start"]!=""&&$_POST["in_date_end"]!=""){
            $map["b.ism_date"]=array(array("egt","{$_POST["in_date_start"]}".' 00:00:00'),array("elt","{$_POST["in_date_end"]}".' 59:59:59'));
        }
		
		//add for danju date
		if($_POST["danju_date_start"]!=""&&$_POST["danju_date_end"]=="")
        {
            $map["b.ism_danju_date"]=array("egt","{$_POST["danju_date_start"]}".' 00:00:00');
        }
        if($_POST["danju_date_start"]==""&&$_POST["danju_date_end"]!="")
        {
            $map["b.ism_danju_date"]=array("elt","{$_POST["danju_date_end"]}".' 59:59:59');
        }
        if($_POST["danju_date_start"]!=""&&$_POST["danju_date_end"]!=""){
            $map["b.ism_danju_date"]=array(array("egt","{$_POST["danju_date_start"]}".' 00:00:00'),array("elt","{$_POST["danju_date_end"]}".' 59:59:59'));
        }
		
		//var_dump($map);
		
		
        if($_POST["in_writer"]!=""){
            $map["b.ism_writer"]=array("like","%{$_POST['in_writer']}%");
        }
        if($_POST["in_operator"]!=""){
            $map["b.ism_operator"]=array("like","%{$_POST['in_operator']}%");
        }
		//因为分仓而增加，只有《=0的单据才输出， 分仓数据只在详细列表里面显示
		$map['iss_id_p']=array("elt",0);
		
        $xlsName  = "入库单";

        if(($_SESSION['user']['user_type']==1||$_SESSION['user']['user_type']==4)){
            $xlsCell  = array(
                array('ism_sellerunit','客户单位'),
                array('ism_danju_no','客户单据号'),
                array('ism_danju_date','客户单据日期'),
                array('iss_prodname','品名规格'),
				array('prod_code','货物编码'),
                array('pdca_name','货物类别'),
                array('prod_unit','计价单位'),
                array('iss_quality','质量类别'),
				array('prod_life','保质期(天)'),
				array('iss_make_date','生产日期'),
                array('iss_plancount','应收数量'),
                array('iss_count','实收数量'),
				array('iss_kuwei_status','分库状态'),
				array('sto_name','仓库'),
                array('prod_price','装卸成本单价'),
                array('prod_realprice','装卸收入单价'),
                array('prod_volume','单位立方量'),
				array('prod_weight','单件重量'),
                array('ism_carry','搬运组'),
                array('ism_date','制单日期'),
                array('ism_writer','制单员'),
                array('ism_status','单据状态'),
                array('ism_status_time','勾单日期'),
                array('ism_operator','勾单员'),
				array('ism_phone','车牌号'),
                array('ism_remark','单据备注')
            );
            $filed = 'ism_sellerunit,ism_danju_no,DATE_FORMAT(ism_danju_date,"%Y-%m-%d") ism_danju_date,iss_prodname,prod_code,pdca_name,prod_unit,iss_quality,prod_life,DATE_FORMAT(iss_make_date,"%Y-%m-%d") iss_make_date,iss_count,iss_plancount,case when iss_id_p=-1 then "已分库" end   iss_kuwei_status,sto_name,prod_price,prod_realprice,prod_volume,prod_weight,ism_carry,DATE_FORMAT(ism_date,"%Y-%m-%d") ism_date,ism_writer,CASE WHEN ism_status =0 THEN  "未勾单" WHEN ism_status =1 THEN  "已勾单" WHEN ism_status =2 THEN  "已复核" END ism_status,DATE_FORMAT(ism_status_time,"%Y-%m-%d") ism_status_time,ism_operator,ism_phone,ism_remark';
        }else{
            $xlsCell  = array(
                array('ism_sellerunit','客户单位'),
                array('ism_danju_no','客户单据号'),
                array('ism_danju_date','客户单据日期'),
                array('iss_prodname','品名规格'),
				array('prod_code','货物编码'),
                array('pdca_name','货物类别'),
                array('prod_unit','计价单位'),
                array('iss_quality','质量类别'),
				array('prod_life','保质期(天)'),
				array('iss_make_date','生产日期'),
                array('iss_plancount','应收数量'),
                array('iss_count','实收数量'),
				array('iss_kuwei_status','分库状态'),
				array('sto_name','仓库'),
                array('prod_volume','单位立方量'),
				array('prod_weight','单件重量'),
                array('ism_carry','搬运组'),
                array('ism_date','制单日期'),
                array('ism_writer','制单员'),
                array('ism_status','单据状态'),
                array('ism_status_time','勾单日期'),
                array('ism_operator','勾单员'),
				array('ism_phone','车牌号'),
                array('ism_remark','单据备注')
            );
            $filed = 'ism_sellerunit,ism_danju_no,DATE_FORMAT(ism_danju_date,"%Y-%m-%d") ism_danju_date,iss_prodname,prod_code,pdca_name,prod_unit,iss_quality,prod_life,DATE_FORMAT(iss_make_date,"%Y-%m-%d") iss_make_date,iss_count,iss_plancount,case when iss_id_p=-1 then "已分库" end   iss_kuwei_status,sto_name,prod_volume,prod_weight,ism_carry,DATE_FORMAT(ism_date,"%Y-%m-%d") ism_date,ism_writer,CASE WHEN ism_status =0 THEN  "未勾单" WHEN ism_status =1 THEN  "已勾单" WHEN ism_status =2 THEN  "已复核" END ism_status,DATE_FORMAT(ism_status_time,"%Y-%m-%d") ism_status_time,ism_operator,ism_phone,ism_remark';
        }

        $model_sub=M("instore_sub");

        $list_sub = $model_sub->alias('a')->join('twms_shipment_main b on a.iss_mainid	=b.ship_id')->
            join('twms_prod_cate c on a.iss_cate=c.pdca_id')->
            join('twms_product d on a.iss_prod	 = d.prod_id')->
			join('twms_store e on a.iss_store	 = e.sto_id')->
            where($map)->
            Field($filed)->
            order('ism_sellerunit,ism_danju_no')->
            select();
        //var_dump($model_sub->getLastSql());
        $common = new CommonAction();
        $common->exportExcel($xlsName,$xlsCell,$list_sub);

    }

}
?>