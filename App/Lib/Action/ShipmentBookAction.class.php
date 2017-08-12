<?php

class ShipmentBookAction extends AppAction{
    public function index() {
		$model_domain=M("shipment_domain");
		$list_domain=$model_domain->order('domain_name')->select();
		$this->assign('list_domain',$list_domain);
        $this->assign('ship_sn','IN-'.date('Ymd-His-').rand(100,999));
        $this->display();
    }
    public function doAdd(){

        $model_main=M("shipment_main");
		$model_main->add($_POST);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加托运单");
        $this->redirect("ShipmentQuery/index");
    }

    public function autoSelect22(){
        $model=M("guest");

        if($_GET['term']){
            $gust_name=trim($_GET['term']);
            $map["gust_name"]=array("like","%$gust_name%");
            $map["gust_sn"]=array("like","%$gust_name%");
            $map['_logic'] = 'OR';
        }
        $list = $model->where($map)->field('gust_name,gust_sn,gust_address,gust_phone')->select();
        foreach($list as $row){
            $result[]=array(
                'label'=>$row['gust_name'],
                'category'=>$row['gust_sn'],
                'value'=>$row['gust_name'],
				'gust_address'=>$row['gust_address'],
				'gust_phone'=>$row['gust_phone'],
            );
        }
        echo json_encode($result);
    }
	
	public function getDriver(){
        $model=M("shipment_driver");
        if($_GET['term']){
            $driver_name=trim($_GET['term']);
            $where["driver_name"]=array("like","%$driver_name%");
            $where["driver_car_no"]=array("like","%$driver_name%");
            $where['_logic'] = 'OR';
        }
		$list=$model->where($where)->order('driver_name')->select();
		foreach($list as $row){
            $result[]=array(
                'label'=>$row['driver_name'],
                'category'=>$row['driver_car_no'],
                'value'=>$row['driver_name'],
				'driver_name'=>$row['driver_name'],
				'driver_car_no'=>$row['driver_car_no'],
            );
        }
        echo json_encode($result);
	}
	
}
?>