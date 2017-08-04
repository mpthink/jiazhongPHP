<?php

class ShipmentBookAction extends AppAction{
    public function index() {
        $this->assign('ism_sn','IN-'.date('Ymd-His-').rand(100,999));
        $this->display();
    }
    public function doAdd(){

        $model_main=M("instore_main");

        $map["ism_danju_no"] = $_POST['ism_danju_no'];
        $one=$model_main->where($map)->find();
        if($one){
            echo "<script>alert('客户单据号已存在，请确认后重新填写!');window.history.back();</script>";
            die;
        }
		
		if(count($_POST["row_count"])==0){
			echo "<script>alert('产品型号列表为空，请添加!');window.history.back();</script>";
            die;
		}
		
		$model_store=M('store');
        $list_store_temp=$model_store->where('sto_default=1')->find();
		$default_sto_id = $list_store_temp['sto_id'];

		for($i=0;$i<count($_POST["row_count"]);$i++){
			$prodname=$_POST["iss_prodname"][$i];
			$data_sub["iss_count"]=$_POST["iss_count"][$i];
            $data_sub["iss_plancount"]=$_POST["iss_plancount"][$i];
			
			if($data_sub['iss_count'] > $data_sub['iss_plancount']){
                echo "<script>alert('$prodname :    实收数量不能大于应收数量!');window.history.back();</script>";
                die;
            }
		}

        $model_main->create();
        $main_id=$model_main->add();
        $model_sub=M("instore_sub");
        for($i=0;$i<count($_POST["row_count"]);$i++){
            $data_sub["iss_mainid"]=$main_id;
            $data_sub["iss_quality"]=$_POST["iss_quality"][$i]; //new add
            $data_sub["iss_make_date"]=$_POST["iss_make_date"][$i]; //new add
            $data_sub["iss_prod"]=$_POST["iss_prod"][$i];
            $data_sub["iss_prodname"]=$_POST["iss_prodname"][$i];
            //$data_sub["iss_price"]=$_POST["iss_price"][$i];
            $data_sub["iss_count"]=$_POST["iss_count"][$i];
            $data_sub["iss_plancount"]=$_POST["iss_plancount"][$i];

            if($data_sub["iss_count"]==''){
                $data_sub["iss_count"] = $data_sub["iss_plancount"];
            }

            $data_sub["iss_total"]=$_POST["iss_total"][$i];
            $data_sub["iss_store"]=$_POST["iss_store"][$i];
			if($data_sub["iss_store"]==""){
				$data_sub["iss_store"]= $default_sto_id;
			}
			
            $data_sub["iss_cate"]=$_POST["iss_cate"][$i];
			
			$data_sub["iss_insert_order"]=$i;
            $model_sub->add($data_sub);
            //$data_main["ism_total"]+=$_POST["iss_total"][$i];
        }
        $data_main["ism_status"]=-1;
        $model_main->where(array("ism_id"=>$main_id))->save($data_main);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("入库单据创建成功");
        $this->redirect("InstoreQuery/index");
    }
    public function checkName(){
        $model=M("product");
        $map["prod_name"]=$_GET["name"];
        $one=$model->where($map)->find();
        if($one==null){
            echo "no_exist";
        }else{
            echo "exist";
        }
    }
    public function getProduct(){
        $model=M("product");
        if($_GET['term']){
            $prod_name=trim($_GET['term']);
            $where["a.prod_name"]=array("like","%$prod_name%");
            $where["a.prod_code"]=array("like","%$prod_name%");
            $where['_logic'] = 'OR';
        }
        if($_GET['seller']=='请输入关键字或空格'||$_GET['seller']==''){
            $map=$where;
        }else{
            $map['_complex'] = $where;
            $map["prod_guest"] = trim($_GET['seller']);
        }

        $list=$model->alias("a")->join("twms_prod_cate as b on a.prod_cate=b.pdca_id")->where($map)->order('pdca_name,prod_name')->select();
        foreach($list as $row){
            $result[]=array(
                'label'=>$row['prod_name'],
                'category'=>$row['pdca_name'],
                'value'=>$row['prod_name'],
                'prod_id'=>$row['prod_id'],
                'prod_name'=>$row['prod_name'],
                'prod_price'=>$row['prod_price'],
                'prod_unit'=>$row['prod_unit'],
				'prod_life'=>$row['prod_life'],
                'prod_cate'=>$row['prod_cate'],
                'prod_code'=>$row['prod_code'],
                'pdca_name'=>$row['pdca_name']
            );
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
        $map['gust_sn'] = array('like', '%'.$q.'%');
        $map['_logic'] = 'OR';
        $list = $model->where($map)->field('gust_name,gust_sn')->select();
        foreach ( $list as $row){

            echo $row['gust_name']."\n";
        }
    }

    public function autoSelect22(){
        $model=M("guest");

        if($_GET['term']){
            $gust_name=trim($_GET['term']);
            $map["gust_name"]=array("like","%$gust_name%");
            $map["gust_sn"]=array("like","%$gust_name%");
            $map['_logic'] = 'OR';
        }
        $list = $model->where($map)->field('gust_name,gust_sn')->select();
        foreach($list as $row){
            $result[]=array(
                'label'=>$row['gust_name'],
                'category'=>$row['gust_sn'],
                'value'=>$row['gust_name']
            );
        }
        echo json_encode($result);
    }

    public function bindCarry(){
        $model=M("prod_carry");

        if($_GET['term']){
            $pdcarry_name=trim($_GET['term']);
            $map["pdcarry_name"]=array("like","%pdcarry_name%");
        }
        $list = $model->where($map)->select();
        foreach($list as $row){
            $result[]=array(
                'label'=>$row['pdcarry_name'],
                'value'=>$row['pdcarry_name']
            );
        }
        echo json_encode($result);
    }


}
?>