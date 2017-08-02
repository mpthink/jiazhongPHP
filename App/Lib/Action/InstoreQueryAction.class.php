<?php

import("@.Action.Common");
class InstoreQueryAction extends AppAction{
    public function index() {
        import("@.ORG.Util.Page");
        $model=M("instore_sub");
        $s_keyword = $_GET['keyword'];
        if(strstr($s_keyword,'已勾')){
            $s_keyword = 1;
        }elseif(strstr($s_keyword,'未勾')){
            $s_keyword = 0;
        }elseif(strstr($s_keyword,'复核')){
            $s_keyword = 2;
        }elseif(strstr($s_keyword,'未提')){
            $s_keyword = -1;
        }

        if($_GET["searchBy"]!=""){
            $map[$_GET["searchBy"]]=array("like","%{$s_keyword}%");
        }
        if($_GET["ism_danju_no"]!=""){
            $map["ism_danju_no"]=array("like","%{$_GET['ism_danju_no']}%");
            $this->assign("in_danju_no",$_GET['ism_danju_no']);
        }
        if($_GET["ism_sellerunit"]!=""){
            $map["ism_sellerunit"]=array("like","%{$_GET['ism_sellerunit']}%");
            $this->assign("in_sellerunit",$_GET['ism_sellerunit']);
        }
        if($_GET["ism_operator"]!=""){
            $map["ism_operator"]=array("like","%{$_GET['ism_operator']}%");
            $this->assign("in_operator",$_GET['ism_operator']);

        }

        if($_GET["ism_status"]!=""){
            $map["ism_status"]=$_GET['ism_status'];
            $this->assign("in_status",$_GET['ism_status']);

        }

        if($_GET["ism_writer"]!=""){
            $map["ism_writer"]=array("like","%{$_GET['ism_writer']}%");
            $this->assign("in_writer",$_GET['ism_writer']);
        }
        if($_GET["ism_date_start"]!=""&&$_GET["ism_date_end"]=="")
        {
            $map["ism_date"]=array("egt","{$_GET['ism_date_start']}".' 00:00:00');
            $this->assign("in_date_start",$_GET['ism_date_start']);
        }
        if($_GET["ism_date_start"]==""&&$_GET["ism_date_end"]!="")
        {
            $map["ism_date"]=array("elt","{$_GET['ism_date_end']}".' 59:59:59');
            $this->assign("in_date_end",$_GET['ism_date_end']);
        }
        if($_GET["ism_date_start"]!=""&&$_GET["ism_date_end"]!=""){
            $map["ism_date"]=array(array("egt","{$_GET['ism_date_start']}".' 00:00:00'),array("elt","{$_GET['ism_date_end']}".' 59:59:59'));
            $this->assign("in_date_start",$_GET['ism_date_start']);
            $this->assign("in_date_end",$_GET['ism_date_end']);
        }
		//add for searching by danju date
		if($_GET["ism_danju_start"]!=""&&$_GET["ism_danju_end"]=="")
        {
            $map["ism_danju_date"]=array("egt","{$_GET['ism_danju_start']}".' 00:00:00');
            $this->assign("danju_date_start",$_GET['ism_danju_start']);
        }
        if($_GET["ism_danju_start"]==""&&$_GET["ism_danju_end"]!="")
        {
            $map["ism_danju_date"]=array("elt","{$_GET['ism_danju_end']}".' 59:59:59');
            $this->assign("danju_date_end",$_GET['ism_danju_end']);
        }
        if($_GET["ism_danju_start"]!=""&&$_GET["ism_danju_end"]!=""){
            $map["ism_danju_date"]=array(array("egt","{$_GET['ism_danju_start']}".' 00:00:00'),array("elt","{$_GET['ism_danju_end']}".' 59:59:59'));
            $this->assign("danju_date_start",$_GET['ism_danju_start']);
            $this->assign("danju_date_end",$_GET['ism_danju_end']);
        }
		
		
        if($_GET["iss_prodname"]!=""){
            $prodname = urldecode($_GET['iss_prodname']);
            $map["iss_prodname"]=array("like","%{$prodname}%");
            $this->assign("in_prodname",$prodname);
        }
        if($_GET["iss_store"]!=""){
            $map["c.sto_name"]=array("like","%{$_GET['iss_store']}%");
            $this->assign("in_store",$_GET['iss_store']);
        }
	
		//添加这个条件是因为分仓后，分仓的数据要在详细列表里面显示，在iss表里面不显示出来
		$map['iss_id_p']=array("elt",0);
		
        $list=$model->alias('a')->join("twms_instore_main as b on ism_id=iss_mainid")->join('twms_store as c on sto_id=iss_store')->where($map)->
            field('ism_id')->select();
        $count=count($list);
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->alias('a')->join("twms_instore_main as b on ism_id=iss_mainid")->join('twms_store as c on sto_id=iss_store')->
            join('twms_product as d on iss_prod=prod_id')->where($map)->
            field("a.*,b.*,d.*")->
            order("ism_status asc,ism_id desc")->limit($Page->firstRow.','.$Page->listRows)->select();

        //var_dump($model->getLastSql());
        $list_count=$model->alias('a')->join("twms_instore_main as b on ism_id=iss_mainid")->join('twms_store as c on sto_id=iss_store')->
            join('twms_product as d on iss_prod=prod_id')->where($map)->
            field("sum(iss_count) as count,sum(iss_plancount) as plancount")->find();
        //var_dump($list_count['count']);
        $this->assign("real_count",$list_count['count']);
        $this->assign("plan_count",$list_count['plancount']);
        $this->assign("searchBy",$_GET['searchBy']);
        $this->assign("keyword",$_GET['keyword']);
        $this->assign("list",$list);
        $this->display();
    }
	

	//获取仓库信息
	public function geStoreBigClass(){
		$model=M('store');
        $list=$model->where('sto_parrent_id=0')->order('sto_name asc')->select();
		
		$str = "<option value='0'>请选择仓库</option>";  
		foreach($list as $key=>$row){
			 $str .= "<option value='".$row['sto_id']."'>".$row['sto_name']."</option>";
		}
		echo $str;
	}
	//获取库位信息
	public function geStoreSmallClass(){
		$model=M('store');
		$big_class_id=$_GET["bigclass"];
		$str = "<option value='0'>请选择库位</option>";
		if($big_class_id!=""){
			$model->where(array("sto_parrent_id"=>$big_class_id))->find();	
			$list=$model->where(array("sto_parrent_id"=>$big_class_id))->order('sto_kuwei_name asc')->select();
			foreach($list as $key=>$row){
				$str .= "<option value='".$row['sto_id']."'>".$row['sto_kuwei_name']."</option>";
			}
		}
		echo $str;
	}

	
    public function delete(){
        $model_main=M("instore_main");
        $map["ism_id"]=$_GET['id'];
        $model_main->where($map)->delete();
        $model_sub=M("instore_sub");
        $model_sub->where(array("iss_mainid"=>$_GET['id']))->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("订单删除");
        $this->redirect("index");
    }
	
	//this method is dropped
    public function approve(){
        $model_main=M("instore_main");
        $map["ism_id"]=$_GET['id'];
        $data['ism_status'] = 1;
        $data['ism_status_time'] = date('Y-m-d H:i:s');
        $data['ism_operator'] =$_SESSION['user']['user_realname'];

        $model_main->where($map)->save($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("勾单成功");
        $this->redirect("index");
    }

    public function doApprove(){
        $model_main=M("instore_main");
        $map_main["ism_id"]=$_POST['ism_id'];
        $data_main['ism_status'] = 1;
        $data_main['ism_status_time'] = date('Y-m-d H:i:s');
        $data_main['ism_operator'] =$_SESSION['user']['user_realname'];
		
        $data_main['ism_carry'] = $_POST['ism_carry'];
        if($data_main['ism_carry']==''){
           echo "<script>alert('请选择搬运组!');window.history.back();</script>";
           die;
        }
		
		
		//判断分仓数据是不是都选择了库位
		//判断分仓后的数据不能大于应收和实收
		for($i=0;$i<count($_POST["iss_id"]);$i++){
			//分仓前应收和实收的总和
			$temp_iss_plancount=$_POST['iss_plancount'][$i];
			$temp_iss_count=$_POST['iss_count'][$i];
			
            
			
			$temp_iss_id=$_POST["iss_id"][$i];
			$temp_iss_plancount_id="iss_plancount_".$temp_iss_id;
			$temp_iss_count_id="iss_count_".$temp_iss_id;
			$temp_iss_store_small_id="iss_store_small_".$temp_iss_id;
			
			//计算分仓之后的数据之和
			$fencang_plancount_sum=0;
			$fencang_count_sum=0;
			//实收不能大于应收
			if($temp_iss_count > $temp_iss_plancount){
                echo "<script>alert('实收数量不能大于应收数量!');window.history.back();</script>";
                die;
            }
			
			for($j=0;$j<count($_POST["$temp_iss_plancount_id"]);$j++){
				if($_POST["$temp_iss_store_small_id"][$j]==0){
					echo "<script>alert('分仓后库位不能为空！');window.history.back();</script>";
					die;
				}
				$temp_fencang_plancount=$_POST["$temp_iss_plancount_id"][$j];
				$temp_fencang_count=$_POST["$temp_iss_count_id"][$j];
				if($temp_fencang_count==0){
					$temp_fencang_count=$temp_fencang_plancount;
				}
				$fencang_plancount_sum=$fencang_plancount_sum+$temp_fencang_plancount;
				$fencang_count_sum=$fencang_count_sum+$temp_fencang_count;
			}
			if($fencang_plancount_sum>$temp_iss_plancount){
				echo "<script>alert('分仓后应收数量之和不能大于分仓前的应收数量！');window.history.back();</script>";
				die;
			}
			if($fencang_count_sum>$temp_iss_count){
				echo "<script>alert('分仓后实收数量之和不能大于分仓前的实收数量！');window.history.back();</script>";
				die;
			}
		}
		
		
        $model_sub=M("instore_sub");
        for($i=0;$i<count($_POST["iss_id"]);$i++){
			// 处理分仓数据
			$temp_iss_id=$_POST["iss_id"][$i];
			$temp_iss_plancount_id="iss_plancount_".$temp_iss_id;
			$temp_iss_count_id="iss_count_".$temp_iss_id;
			$temp_iss_store_big_id="iss_store_big_".$temp_iss_id;
			$temp_iss_store_small_id="iss_store_small_".$temp_iss_id;
			
			$map_iss['iss_id']=$temp_iss_id;
			$temp_iss_data=$model_sub->where($map_iss)->find();
			
			//初始值为0，只有分仓后才为-1
			$data_sub['iss_id_p']=0;
			if(count($_POST["$temp_iss_plancount_id"])>0){
				$data_sub['iss_id_p']=-1;
				//第一个for循环判断是否有分仓数据未选择库位的情况，其他分仓数据如果没有错误会入库
				for($j=0;$j<count($_POST["$temp_iss_plancount_id"]);$j++){
					if($_POST["$temp_iss_store_small_id"][$j]==0){
					echo "<script>alert('分仓后库位不能为空！');window.history.back();</script>";
					die;
					}
				}
				//存储分仓数据
				for($j=0;$j<count($_POST["$temp_iss_plancount_id"]);$j++){
					//从父iss表拷贝的数据
					
					$fencang_data['iss_mainid']=$temp_iss_data['iss_mainid'];
					$fencang_data['iss_prod']=$temp_iss_data['iss_prod'];
					$fencang_data['iss_prodname']=$temp_iss_data['iss_prodname'];
					$fencang_data['iss_cate']=$temp_iss_data['iss_cate'];
					$fencang_data['iss_price']=$temp_iss_data['iss_price'];
					$fencang_data['iss_quality']=$temp_iss_data['iss_quality'];
					$fencang_data['iss_make_date']=$temp_iss_data['iss_make_date'];
					
					//分仓的新数据从表单获取
					$fencang_data['iss_plancount']=$_POST["$temp_iss_plancount_id"][$j];
					$fencang_data['iss_count']=$_POST["$temp_iss_count_id"][$j];
					//如果实收count为空，值等于plancount
					if($fencang_data["iss_count"]==''){
						$fencang_data["iss_count"] = $fencang_data["iss_plancount"];
					}
					
					$fencang_data['iss_store']=$_POST["$temp_iss_store_small_id"][$j];
					
					//新数据
					$fencang_data['iss_id_p']=$temp_iss_data['iss_id'];
					
					$model_sub->add($fencang_data);
				}
			}			
			
			//iss表保存数据，只修改应收和实收数量
            $data_sub['iss_count']=$_POST['iss_count'][$i];
            $data_sub['iss_plancount']=$_POST['iss_plancount'][$i];
            $model_sub->where(array("iss_id"=>$temp_iss_id))->save($data_sub);
			
        }
		//完全ok后，ism主表保存单据状态
		$model_main->where($map_main)->save($data_main);

        import('@.ORG.Util.SysLog');
        SysLog::writeLog("入库勾单成功");
        $this->redirect("index");
    }

	//单据复核
    public function doReview(){
        $model_main=M("instore_main");
        $map["ism_id"]=$_GET['ism_id'];
        $data['ism_status'] = 2;
        $data['ism_reviwer_time'] = date('Y-m-d H:i:s');
        $data['ism_reviwer'] =$_SESSION['user']['user_realname'];
        $model_main->where($map)->save($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("入库单复核成功");
        $this->redirect("index");
    }
	
	//单据提交，状态从-1变为0
    public function doSubmitIN(){
        $model_main=M("instore_main");
        $map["ism_id"]=$_GET['ism_id'];
        $data['ism_status'] = 0;
        $data['ism_submit_time'] = date('Y-m-d H:i:s');
        $data['ism_submiter'] =$_SESSION['user']['user_realname'];
        $model_main->where($map)->save($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("入库单提交成功");
        $this->redirect("index");
    }

	//退单，状态从0变为-1
    public function doRollbackIN(){
        $model_main=M("instore_main");
        $map["ism_id"]=$_GET['ism_id'];
        $data['ism_status'] = -1;
        $data['ism_rollback_time'] = date('Y-m-d H:i:s');
        $data['ism_rollbacker'] =$_SESSION['user']['user_realname'];
        $model_main->where($map)->save($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("入库单退单成功");
        $this->redirect("index");
    }
	
	//分库恢复，状态从1变为0，并且删除分库数据，还原子仓单据iss_id_p的值为0
    public function doRollbackFengCang(){
        $model_main=M("instore_main");
		$ism_id=$_GET['ism_id'];
        $map_main["ism_id"]=$ism_id;
        $data_main['ism_status'] = 0;
        $data_main['ism_rollback_time'] = date('Y-m-d H:i:s');
        $data_main['ism_rollbacker'] =$_SESSION['user']['user_realname'];
        $model_main->where($map_main)->save($data_main);
		
		$model_sub=M("instore_sub");
		$map_sub["iss_mainid"] =$ism_id;
		$list_sub=$model_sub->where($map_sub)->select();
		foreach($list_sub as $row){
			if($row['iss_id_p']==-1){
				$temp_sub['iss_id_p'] = 0;
				$model_sub->where(array("iss_mainid"=>$ism_id))->save($temp_sub);
			}else if($row['iss_id_p']>0){
				$model_sub->where(array("iss_id"=>$row['iss_id']))->delete();
			}
		}
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("分库恢复成功");
        $this->redirect("index");
    }

	//查看单据view，应该按照产品型号排序
    public function view(){
        $model_main=M("instore_main");
        $main=$model_main->where(array("ism_id"=>$_GET['ism_id']))->find();
        $model_sub=M("instore_sub");

        $list_sub=$model_sub->join('twms_product on iss_prod=prod_id')->
            join('twms_store on sto_id=iss_store')->
            join('twms_prod_cate on pdca_id=iss_cate')->
            where(array("iss_mainid"=>$_GET['ism_id']))->order('iss_insert_order,iss_id')->select();
        $model_carry=M("prod_carry");
        $list_carry=$model_carry->select();
		
		$map_sub['iss_mainid'] = $_GET['ism_id'];
		$map_sub['iss_id_p'] = array('egt',0);
        $count_plan = $model_sub->where($map_sub)->sum('iss_plancount');
        $count_real = $model_sub->where($map_sub)->sum('iss_count');
		//计算总重量,单位转换为吨
		$weight_sum = 0;
		foreach($list_sub as $row){
			if($row['iss_id_p']<=0){
				$weight_sum = $weight_sum + $row['iss_count']*$row['prod_weight'];
			}
		}
		$weight_sum = $weight_sum/1000;
		
        $this->assign("main",$main);
        $this->assign("list_sub",$list_sub);
        $this->assign("list_carry",$list_carry);
        $this->assign("count_plan",$count_plan);
        $this->assign("count_real",$count_real);
		$this->assign("weight_sum",$weight_sum);
        $this->display();
    }
    public function toEdit(){
        $model_main=M("instore_main");
        $main=$model_main->where(array("ism_id"=>$_GET['ism_id']))->find();
        $model_sub=M('instore_sub');
        $list_sub=$model_sub->alias('a')->join('twms_product on iss_prod=prod_id')->
            join('twms_prod_cate on iss_cate=pdca_id')->where(array('iss_mainid'=>$_GET['ism_id']))->order('iss_insert_order')->select();
        $model_store=M('store');
        $list_store=$model_store->where('sto_parrent_id=0')->order('sto_name asc')->select();
		
        $this->assign('list_store',$list_store);
        //add for quality
        $model_quality=M('prod_quality');
        $list_quality=$model_quality->select();
        $this->assign('list_quality',$list_quality);
        $this->assign('main',$main);
        $this->assign('list_sub',$list_sub);
        $this->display();
    }
    public function doEdit(){
        $model_main=M("instore_main");

        $model_main->create();
        $model_sub=M("instore_sub");
        $model_sub->where(array('iss_mainid'=>$_POST['ism_id']))->delete();

        $map["ism_danju_no"] = $_POST['ism_danju_no'];
        $map["ism_id"] = array('neq',$_POST['ism_id']);
        $one=$model_main->where($map)->find();
        if($one){
            echo "<script>alert('客户单据号已存在，请确认后重新填写!');window.history.back();</script>";
            die;
        }
		
		if(count($_POST["iss_prodname"])==0){
			echo "<script>alert('产品型号列表为空，请添加!');window.history.back();</script>";
            die;
		}

		$model_store=M('store');
        $list_store_temp=$model_store->where('sto_default=1')->find();
		$default_sto_id = $list_store_temp['sto_id'];
		
        for($i=0;$i<count($_POST["iss_prodname"]);$i++){
            $data['iss_mainid']=$_POST['ism_id'];
            $data['iss_prodname']=$_POST['iss_prodname'][$i];
            $data['iss_prod']=$_POST['iss_prod'][$i];
            $data['iss_cate']=$_POST['iss_cate'][$i];
            $data['iss_price']=$_POST['iss_price'][$i];

            $data['iss_quality']=$_POST['iss_quality'][$i];
            $data['iss_make_date']=$_POST['iss_make_date'][$i];

            $data['iss_count']=$_POST['iss_count'][$i];
            $data['iss_plancount']=$_POST['iss_plancount'][$i];
            if($data["iss_count"]==''){
                $data["iss_count"] = $data["iss_plancount"];
            }

            if($data['iss_count'] > $data['iss_plancount']){
                echo "<script>alert('实收数量不能大于应收数量!');window.history.back();</script>";
                die;
            }
			
			 $data["iss_insert_order"]=$i;
			 
            $data['iss_total']=$_POST['iss_total'][$i];
			
            $data['iss_store']=$_POST['iss_store'][$i];
			if($data["iss_store"]==""){
				$data["iss_store"]= $default_sto_id;
			}
			
            $data['iss_remark']=$_POST['iss_remark'][$i];

            $model_main->ism_total+=$data['iss_total'];
            $model_sub->add($data);
        }
        $model_main->save();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑出库单据");
        $this->redirect("index");
    }

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

        $list_sub = $model_sub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->
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