<?php

class OutstoreBookAction extends AppAction{
    public function index() {
		$model_deliver=M("prod_deliver");
        $list_deliver=$model_deliver->select();
		$this->assign("list_deliver",$list_deliver);
        $this->assign('osm_sn','OU-'.date('Ymd-His-').rand(100,999));
        $this->display();
    }
	
	public function getAvalibleCount($p_buyer,$p_prod,$p_store_id,$oss_make_date){
		$Model_count = new Model();
		
		$iss_date_sql = "";
		$oss_date_sql = "";
		if($oss_make_date != null){
			$iss_date_sql = " and a.iss_make_date='$oss_make_date'";
			$oss_date_sql = " and oss_make_date='$oss_make_date'";
		}
		
		$sql_incount_done = "SELECT sum(iss_count) as `incount`
                FROM twms_instore_sub a
                LEFT JOIN twms_instore_main as b on iss_mainid=ism_id
                 WHERE b.ism_status>0 and ism_sellerunit = '$p_buyer' and iss_prod='$p_prod' and a.iss_id_p>=0 and a.iss_store='$p_store_id'   $iss_date_sql";
		$sql_outcount_done = "SELECT SUM( oss_count ) AS `outcount_done`
                FROM twms_outstore_sub
                LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id
                WHERE d.osm_status >0 and osm_buyerunit = '$p_buyer' and oss_prod='$p_prod' and oss_store='$p_store_id' $oss_date_sql";
		
		
		$sql_outcount_doing = "SELECT SUM( oss_count ) AS `outcount_doing`
                FROM twms_outstore_sub
                LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id
                WHERE d.osm_status =0 and osm_buyerunit = '$p_buyer' and oss_prod='$p_prod' and oss_store='$p_store_id' $oss_date_sql";
				
		$incount_done_rs = $Model_count->query($sql_incount_done);
		$incount_done = $incount_done_rs[0]['incount'];
		if($incount_done==null){$incount_done=0;}
		
		$outcount_done_rs = $Model_count->query($sql_outcount_done);
		$outcount_done = $outcount_done_rs[0]['outcount_done'];
		if($outcount_done==null){$outcount_done=0;}
		
		$outcount_doing_rs = $Model_count->query($sql_outcount_doing);
		$outcount_doing = $outcount_doing_rs[0]['outcount_doing'];
		if($outcount_doing==null){$outcount_doing=0;}

		return $incount_done - $outcount_done -$outcount_doing;
	}
	
    public function doAdd(){
        $model_outmain=M("outstore_main");
        $model_outsub=M("outstore_sub");
        $model_inmain=M("instore_main");
        $model_insub=M("instore_sub");

        $map["osm_danju_no"] = $_POST['osm_danju_no'];
        $one=$model_outmain->where($map)->find();
        if($one){
            echo "<script>alert('客户单据号已存在，请确认后重新填写!');window.history.back();</script>";
            die;
        }

		if(count($_POST["row_count"])==0){
			echo "<script>alert('产品型号列表为空，请添加!');window.history.back();</script>";
            die;
		}
		
		$p_buyer=trim($_POST['osm_buyerunit']);
		for($i=0;$i<count($_POST["row_count"]);$i++){
			$oss_count=$_POST["oss_count"][$i];
            $oss_plancount=$_POST["oss_plancount"][$i];
			$oss_prodname=$_POST["oss_prodname"][$i];
			
			
			if($oss_count ==null){
				$oss_count =$oss_plancount;
			}
			if($oss_count > $oss_plancount){
                echo "<script>alert('$oss_prodname :    实发数量不能大于应发数量!');window.history.back();</script>";
                die;
            }
			$p_prod=$_POST["oss_prod"][$i];
			$p_store_id=$_POST["oss_store_id"][$i];
			$oss_make_date=$_POST["oss_make_date"][$i];
			
			$storage_count = $this->getAvalibleCount($p_buyer,$p_prod,$p_store_id,$oss_make_date);

			if($oss_count > $storage_count){
                echo "<script>alert('$oss_prodname :     实发数量不能大于可提库存数量!');window.history.back();</script>";
                die;
            }
		}
		
		
        $model_outmain->create();
        $main_id=$model_outmain->add();
        for($i=0;$i<count($_POST["row_count"]);$i++){
            //$data_sub["oss_insubid"]=$_POST["oss_insubid"][$i];
            $data_sub["oss_mainid"]=$main_id;
            $data_sub["oss_prodname"]=$_POST["oss_prodname"][$i];

            $data_sub["oss_quality"]=$_POST["oss_quality"][$i]; //new add
			
			$data_sub["oss_make_date"]=$_POST["oss_make_date"][$i]; //new add
			
            $data_sub["oss_prod"]=$_POST["oss_prod"][$i];
            $data_sub["oss_count"]=$_POST["oss_count"][$i];
            $data_sub["oss_plancount"]=$_POST["oss_plancount"][$i];
			
            if($data_sub["oss_count"]==''){
                $data_sub["oss_count"] = $data_sub["oss_plancount"];
            }

			$data_sub["oss_insert_order"]=$i;
            $data_sub["oss_store"]=$_POST["oss_store_id"][$i];
            $data_sub["oss_cate"]=$_POST["oss_cate"][$i];
            $model_outsub->add($data_sub);
        }
        $data_main["osm_status"]=-1;
        $model_outmain->where(array('osm_id'=>$main_id))->save($data_main);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("出库单创建成功");
        $this->redirect("OutstoreQuery/index");
    }
    public function checkName(){
        $model=M('product');
        $map['prod_name']=$_GET['name'];
        $one=$model->where($map)->find();
        if($one==null){
            echo 'no_exist';
        }else{
            echo 'exist';
        }
    }
	
	//添加项后，点击空格选择产品，并根据所选型号自动填充其他字段
    public function getProduct(){
		
        $buyer=trim($_GET['buyer']);
        if($_GET['term']){
            $prod_name=trim($_GET['term']);
            $condition = "where (prod_name like '%$prod_name%' OR prod_code like '%$prod_name%') and a.ism_sellerunit = '$buyer'";
        }else{
            $condition = "where ism_sellerunit = '$buyer'";
        }
        $Model_count = new Model();
        $countsql = "select a.*,b.outcount_real,c.outcount_plan
                from
                (SELECT sum(iss_count) as `incount`,a.*,b.pdca_name,d.ism_sellerunit,c.*,e.*
                FROM twms_instore_sub a
                LEFT JOIN twms_prod_cate as b on a.iss_cate=b.pdca_id
                LEFT JOIN twms_product  as c on iss_prod=prod_id
                LEFT JOIN twms_instore_main as d on iss_mainid=ism_id
				LEFT JOIN twms_store as e on a.iss_store=e.sto_id
                 WHERE d.ism_status>0  and a.iss_id_p>=0
                 GROUP BY iss_prod,iss_store,iss_make_date
                )  as a
                left Join
                (SELECT oss_prod, oss_quality, SUM( oss_count ) AS `outcount_real`,oss_store,oss_make_date
                FROM twms_outstore_sub
                LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id
                WHERE d.osm_status >0
                GROUP BY oss_prod,oss_store,oss_make_date )  as b on  a.iss_prod =  b.oss_prod and a.iss_store=b.oss_store and a.iss_make_date=b.oss_make_date

				left Join
                (SELECT oss_prod, oss_quality, SUM( oss_count ) AS `outcount_plan`,oss_store,oss_make_date
                FROM twms_outstore_sub
                LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id
                WHERE d.osm_status =0
                GROUP BY oss_prod,oss_store,oss_make_date )  as c on  c.oss_prod = a.iss_prod and a.iss_store=c.oss_store and a.iss_make_date=c.oss_make_date
                {$condition}
				 order by pdca_name,prod_name asc";



        $list = $Model_count->query($countsql);
        foreach($list as $row){
            $countForUse = $row['incount'] - $row['outcount_real'] - $row['outcount_plan'];
            if($row['outcount_plan']==null) $row['outcount_plan'] =0;
			if($countForUse==0&&$row['outcount_plan']==0){}
			else{
				$result[]=array(
					'label'=>$row['prod_name'].'(可提数量:'.$countForUse.') (未提数量:'.$row['outcount_plan'].')(仓位:'.$row['sto_name'].'/'.$row['sto_kuwei_name'].')(产日:'.substr($row['iss_make_date'],0,10).')',
					'category'=>$row['pdca_name'],
					'value'=>$row['prod_name'],
					'prod_unit'=>$row['prod_unit'],
					'prod_code'=>$row['prod_code'],
					'prod_life'=>$row['prod_life'],
					'oss_make_date'=>substr($row['iss_make_date'],0,10),
					'iss_prod'=>$row['iss_prod'],
					'iss_id'=>$row['iss_id'],
					//为仓库增加两个字段，分别为库位id和仓库id
					'sto_id'=>$row['sto_id'],
					'sto_parrent_id'=>$row['sto_parrent_id'],
					'sto_name'=>$row['sto_name'],
					'sto_kuwei_name'=>$row['sto_kuwei_name'],
					'iss_cate'=>$row['iss_cate'],
					'pdca_name'=>$row['pdca_name']
				);
			}
        }
        echo json_encode($result);
    }
    public function getStore(){
        $model=M('store');
        $list=$model->where('sto_parrent_id=0')->order('sto_name asc')->select();
        echo json_encode($list);
    }

    public function getQuality(){
        $model=M('prod_quality');
        $list=$model->select();
        echo json_encode($list);
    }
    // add for auto select
    public function autoSelect(){
        $model=M("guest");
        $q = strtolower($_POST["queryString"]);
        $map['gust_name'] = array('like', '%'.$q.'%');
        $list = $model->where($map)->field('gust_name')->select();
        foreach ( $list as $row){

            echo $row['gust_name']."\n";
        }
    }


}
?>