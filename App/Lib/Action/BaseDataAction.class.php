<?php

import("@.ORG.Util.Page");
class BaseDataAction extends AppAction{
    public function index() {
        $model=M("product");
        if($_GET["prod_cate"]){
            $map["a.prod_cate"]=$_GET["prod_cate"];
        }

        $_GET['keyword'] =  urldecode($_GET['keyword']);
        if($_GET["searchBy"]!="")$map[$_GET["searchBy"]]=array("like","%{$_GET['keyword']}%");

        $count = $model->alias("a")->
            join("twms_prod_cate as b on a.prod_cate=b.pdca_id")->where($map)->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->alias("a")->
            join("twms_prod_cate as b on a.prod_cate=b.pdca_id")->order("prod_id desc")->
            limit($Page->firstRow.','.$Page->listRows)->where($map)->select();
        $model=M("prod_cate");
        $list_cate=$model->order("pdca_id desc")->select();
        $this->assign("list_cate",$list_cate);
        $this->assign("list",$list);
        $this->assign("searchBy",$_GET['searchBy']);
        $this->assign("keyword",$_GET['keyword']);
        $this->assign("action","index");
        $this->display();
    }
    public function cate() {
        $model=M("prod_cate");
        $count = $model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order("pdca_id desc")->select();
        $this->assign("list",$list);
        $this->assign("action","cate");
        $this->display();
    }

    public function quality() {
        $model=M("prod_quality");
        $count = $model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order("pdqu_id desc")->select();
        $this->assign("list",$list);
        $this->assign("action","quality");
        $this->display();
    }

    public function store() {
        $model=M("store");
        $count = $model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order("sto_name,sto_kuwei_name")->select();
		//传递 list_store,作为添加库位的选择
        $list_store=$model->where('sto_parrent_id=0')->order('sto_name')->select();
		
        $this->assign("list",$list);
		$this->assign("list_store",$list_store);
        $this->assign("action","store");
        $this->display();
    }
    public function guest() {
        $model=M("guest");
        $count = $model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order("gust_id desc")->select();
        $this->assign("list",$list);
        $this->assign("action","guest");
        //add for guest cate
        $model2=M("guest_cate");
        $cateList = $model2->select();
        $this->assign("cateList",$cateList);

        $this->display();
    }

    public function doAddGuest(){
        $model=M("guest");
        $model->add($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加客户");
        $this->redirect("guest");
    }

    public function doAddGuestCate(){
        $model=M("guest_cate");
        $model->add($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加客户类别");
        $this->redirect("guest");
    }

    public function deleteGuestCate() {
        $model=M("guest_cate");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除客户类别");
        $this->redirect("guest");
    }

    public function toEditGuest(){
        $model=M("guest");
        $one=$model->where($_GET)->find();
        $this->assign("one",$one);
        $this->display();
    }
    public function doEditGuest(){
        $model=M("guest");
        $model->save($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑客户信息");
        $this->redirect("guest");
    }
    public function deleteGuest() {
        $model=M("guest");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除客户");
        $this->redirect("guest");
    }
    public function doAddCate(){
        $model=M("prod_cate");
        $data["pdca_name"]=$_GET["pdca_name"];

        $map["pdca_name"] = $_GET['pdca_name'];
        $one=$model->where($map)->find();
        if($one){
            echo "<script>alert('产品类别已存在，请确认后重新填写!');window.history.back();</script>";
            die;
        }

        $model->add($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加产品类别");
        $this->redirect("cate");
    }

    public function doAddQuality(){
        $model=M("prod_quality");
        $data["pdqu_name"]=trim($_GET["pdqu_name"]);
        $model->add($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加产品质量类别");
        $this->redirect("quality");
    }

    public function toAddProduct(){
        $model=M("prod_cate");
        $list=$model->order("pdca_id desc")->select();
        $this->assign("list",$list);
        $this->display();
    }
    public function doAddProduct(){
        $model=M("product");
        $_GET['prod_name'] =  urldecode($_GET['prod_name']);

        $map["prod_guest"] = $_GET['prod_guest'];
        $map["prod_name"] = $_GET['prod_name'];
        $one=$model->where($map)->find();
        if($one){
            echo "<script>alert('货物品名规格在该客户单位已存在，请确认后重新填写!');window.history.back();</script>";
            die;
        }
        $model->add($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加产品". $_GET['prod_name']);
        $this->redirect("index");
    }
    public function doAddStore(){
        $model=M("store");
        $data["sto_name"]=trim($_GET["sto_name"]);
        $data["sto_address"]=trim($_GET["sto_address"]);
        $data["sto_storer"]=trim($_GET["sto_storer"]);
        $data["sto_phone"]=trim($_GET["sto_phone"]);
        $model->add($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加仓库");
        $this->redirect("store");
    }
    public function toEditStore(){
        $model=M("store");
        $one=$model->where(array("sto_id"=>$_GET['sto_id']))->find();
        $this->assign("one",$one);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑仓库");
        $this->display();
    }
	
	public function doEditStore(){
        $model=M("store");
		$sto_name=$_GET['sto_name'];
		$sto_id=$_GET['sto_id'];
        $model->save($_GET);
		$model2=new Model();
		$model2->execute("update twms_store set sto_name='$sto_name' where sto_parrent_id='$sto_id'");
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑仓库成功");
        $this->redirect("store");
    }
	
	//添加库位
	public function doAddStoreKuWei(){
        $model=M("store");
		$map['sto_id']=trim($_GET["sto_id"]);
		$list=$model->where($map)->find();
		$data["sto_name"]=$list["sto_name"];
        $data["sto_parrent_id"]=trim($_GET["sto_id"]);
        $data["sto_kuwei_name"]=trim($_GET["sto_kuwei_name"]);
        $model->add($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加库位");
        $this->redirect("store");
    }
	
	//编辑库位
	public function toEditStoreKuWei(){
        $model=M("store");
        $one=$model->where(array("sto_id"=>$_GET['sto_id']))->find();
        $this->assign("one",$one);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑库位");
        $this->display();
    }
	
	//编辑库位
	public function doEditStoreKuWei(){
        $model=M("store");
        $model->save($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑库位成功");
        $this->redirect("store");
    }
	
	//设置默认仓库
	public function doSetDefaultStore(){
		$Model = new Model();
		$sto_id=$_GET["sto_id"];
		if($sto_id!=""){
			$Model->execute("update twms_store set sto_default=0");
			$Model->execute("update twms_store set sto_default=1 where sto_id='$sto_id'");
		}
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("设置默认仓库");
        $this->redirect("store");
    }
	
	
	
	
    public function doEditCate(){
        $model=M("prod_cate");

        $map["pdca_name"] = $_GET['pdca_name'];
        $map["pdca_id"] = array('neq',$_GET['pdca_id']);
        $one=$model->where($map)->find();
        if($one){
            echo "<script>alert('产品类别已存在，请确认后重新填写!');window.history.back();</script>";
            die;
        }

        $model->save($_GET);
        $this->redirect("cate");
    }

    public function doEditQuality(){
        $model=M("prod_quality");
        $model->save($_GET);
        $this->redirect("quality");
    }


    public function deleteProduct() {
        $model=M("product");
        $model->where(array("prod_id"=>$_GET['prod_id']))->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除产品");
        $this->redirect("index");
    }
    public function deleteStore() {
        $model=M("store");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除仓库信息");
        $this->redirect("store");
    }
    public function deleteCate() {
        $model=M("prod_cate");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除产品分类");
        $this->redirect("cate");
    }

    public function deleteQuality() {
        $model=M("prod_quality");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除产品质量类别");
        $this->redirect("quality");
    }

    public function toEditProduct() {
        $model=M("product");
        $one=$model->where(array("prod_id"=>$_GET['prod_id']))->find();
        $this->assign("one",$one);
        $model=M("prod_cate");
        $list_cate=$model->order("pdca_id desc")->select();
        $this->assign("list_cate",$list_cate);
        $this->display();
    }
    public function getProdCateById() {
        $model=M("prod_cate");
        $one=$model->where(array("pdca_id"=>$_GET['pdca_id']))->find();
        echo json_encode($one);
    }

    public function getProdQualityById() {
        $model=M("prod_quality");
        $one=$model->where(array("pdqu_id"=>$_GET['pdqu_id']))->find();
        echo json_encode($one);
    }

    public function getProdById() {
        $model=M("product");
        $one=$model->where(array("prod_id"=>$_GET['prod_id']))->find();
        echo json_encode($one);
    }
	
	public function getStores(){
        $model=M('store');
        $list=$model->where('sto_parrent_id=0')->order('sto_name asc')->select();
        echo json_encode($list);
    }
	
    public function getStoreById() {
        $model=M("store");
        $one=$model->where(array("sto_id"=>$_GET['sto_id']))->find();
        echo json_encode($one);
    }
    public function getGuestById() {
        $model=M("guest");
        $one=$model->where(array("gust_id"=>$_GET['gust_id']))->find();
        echo json_encode($one);
    }
    public function toEditCate() {
        $model=M("prod_cate");
        $one=$model->where(array("pdca_id"=>$_GET['pdca_id']))->find();
        $this->assign("one",$one);
        $this->display();
    }

    public function toEditQuality() {
        $model=M("prod_quality");
        $one=$model->where(array("pdqu_id"=>$_GET['pdqu_id']))->find();
        $this->assign("one",$one);
        $this->display();
    }

    public function doEditProduct() {
        $model=M("product");
//        $data["prod_name"]=$_GET["prod_name"];
//        $data["prod_price"]=$_GET["prod_price"];
//        $data["prod_count"]=$_GET["prod_count"];
//        $data["prod_cate"]=$_GET["prod_cate"];
//        $model->where(array("prod_id"=>$_GET['prod_id']))->save($data);
        $_GET['prod_name'] =  urldecode($_GET['prod_name']);

        $map["prod_guest"] = $_GET['prod_guest'];
        $map["prod_name"] = $_GET['prod_name'];
        $map["prod_id"] = array('neq',$_GET['prod_id']);
        $one=$model->where($map)->find();
        if($one){
            echo "<script>alert('货物品名规格在该客户单位已存在，请确认后重新填写!');window.history.back();</script>";
            die;
        }

        $model->save($_GET);
        $model_update = new Model();
        $sql_iss = "update twms_instore_sub set iss_prodname = '".$_GET['prod_name']."'  , iss_cate = {$_GET['prod_cate']} where iss_prod = {$_GET['prod_id']} ";
        $sql_oss = "update twms_outstore_sub set oss_prodname = '".$_GET['prod_name']."' , oss_cate = {$_GET['prod_cate']} where oss_prod = {$_GET['prod_id']} ";
        $model_update->query($sql_iss);
        $model_update->query($sql_oss);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑产品成功".$_GET['prod_name']." ");
        $this->redirect("index");
    }

    public function carry() {
        $model=M("prod_carry");
        $count = $model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order("pdcarry_id desc")->select();
        $this->assign("list",$list);
        $this->assign("action","carry");
        $this->display();
    }

    public function doAddCarry(){
        $model=M("prod_carry");
        $data["pdcarry_name"]=$_GET["pdcarry_name"];
        $model->add($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加搬运组成功");
        $this->redirect("carry");
    }

    public function toEditCarry() {
        $model=M("prod_carry");
        $one=$model->where(array("pdcarry_id"=>$_GET['pdcarry_id']))->find();
        $this->assign("one",$one);
        $this->display();
    }

    public function doEditCarry(){
        $model=M("prod_carry");
        $model->save($_GET);
        $this->redirect("carry");
    }


    public function deleteCarry() {
        $model=M("prod_carry");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除搬运组成功");
        $this->redirect("carry");
    }

    public function getProdCarryById() {
        $model=M("prod_carry");
        $one=$model->where(array("pdcarry_id"=>$_GET['pdcarry_id']))->find();
        echo json_encode($one);
    }
	
	
	//收货人操作
	public function deliver() {
        $model=M("prod_deliver");
        $count = $model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order("pddeliver_id desc")->select();
        $this->assign("list",$list);
        $this->assign("action","deliver");
        $this->display();
    }

    public function doAddDeliver(){
        $model=M("prod_deliver");
        $model->add($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加收货人成功");
        $this->redirect("deliver");
    }

    public function toEditDeliver() {
        $model=M("prod_deliver");
        $one=$model->where(array("pddeliver_id"=>$_GET['pddeliver_id']))->find();
        $this->assign("one",$one);
        $this->display();
    }

    public function doEditDeliver(){
        $model=M("prod_deliver");
        $model->save($_GET);
        $this->redirect("deliver");
    }


    public function deleteDeliver() {
        $model=M("prod_deliver");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除收货人成功");
        $this->redirect("deliver");
    }

    public function getProdDeliverById() {
        $model=M("prod_deliver");
        $one=$model->where(array("pddeliver_id"=>$_GET['pddeliver_id']))->find();
        echo json_encode($one);
    }
}
?>