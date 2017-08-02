<?php
import("@.Action.Common");
class StoreCountAction extends AppAction{
    public function index(){
        import("@.ORG.Util.Page");
        $model=M("instore_sub");
        $list = $model->alias("a")->join("twms_prod_cate as b on a.iss_cate=b.pdca_id")->
            join('twms_product as c on iss_prod=prod_id')->
            join('twms_instore_main as d on iss_mainid=ism_id')->
            where("d.ism_status>0 and a.iss_id_p>=0")->group("iss_prod,iss_quality,iss_store,iss_make_date")->field('iss_prod,iss_quality,iss_store,iss_make_date')->select();
        $count=count($list);
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);

        $Model_count = new Model();
        $firstRow = $Page->firstRow;
        $listRows = $Page->listRows;
        $countsql = "select a.*,b.outcount,(a.incount - ifnull(b.outcount,0)) as allcount
                from
                (SELECT sum(iss_count) as `incount`,a.iss_prod,a.iss_quality,a.iss_store,a.iss_make_date,b.*,d.ism_sellerunit,c.*,e.*
                FROM twms_instore_sub a
                LEFT JOIN twms_prod_cate as b on a.iss_cate=b.pdca_id
                LEFT JOIN twms_product  as c on iss_prod=prod_id
                LEFT JOIN twms_instore_main as d on iss_mainid=ism_id
				LEFT JOIN twms_store as e on a.iss_store=e.sto_id
                 WHERE d.ism_status>0 and a.iss_id_p>=0
                 GROUP BY iss_prod,iss_quality,iss_store,iss_make_date
                )  as a
                left Join
                (SELECT oss_prod, oss_quality, SUM( oss_count ) AS `outcount`,oss_store,oss_make_date
                FROM twms_outstore_sub
                LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id
                WHERE d.osm_status >0
                GROUP BY oss_prod, oss_quality,oss_store,oss_make_date )  as b on  a.iss_prod =  b.oss_prod  and a.iss_quality  = b.oss_quality and a.iss_store=b.oss_store and a.iss_make_date=b.oss_make_date order by allcount desc limit {$firstRow},{$listRows} ";
        $list = $Model_count->query($countsql);
        $incount_sql = "select sum(iss_count) as incount from twms_instore_sub a  LEFT JOIN twms_instore_main as d on iss_mainid=ism_id WHERE d.ism_status>0 and a.iss_id_p>=0";
        $list_incount = $Model_count->query($incount_sql);
        $outcount_sql = "select sum(oss_count) as outcount from twms_outstore_sub LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id WHERE d.osm_status >0";
        $list_outcount = $Model_count->query($outcount_sql);
        //var_dump($list_incount[0]['incount']);
        $count = $list_incount[0]['incount'] - $list_outcount[0]['outcount'];
        $this->assign("count",$count);
        $this->assign("list",$list);
        $this->display();
    }

    public function search(){
        import("@.ORG.Util.Page");

        $query =" ";
		$query_osm =" "; 
        $map["ism_status"] =array('gt',0);
        if($_GET["ism_sellerunit"]!=""){
            $map["ism_sellerunit"]=array("like","%{$_GET['ism_sellerunit']}%");
            $this->assign("in_sellerunit",$_GET['ism_sellerunit']);
            $query1 = "ism_sellerunit like '%{$_GET['ism_sellerunit']}%' ";
			$query_osm_1 = "osm_buyerunit like '%{$_GET['ism_sellerunit']}%' ";
            $query = $query ." and " .$query1;
			$query_osm = $query_osm ." and " .$query_osm_1;
        }

        if($_GET["ism_date_start"]!=""&&$_GET["ism_date_end"]==""){
            $map["ism_date"]=array("egt","{$_GET['ism_date_start']}".' 00:00:00');
            $this->assign("in_date_start",$_GET['ism_date_start']);
            $query2 = "ism_date > '{$_GET['ism_date_start']} 00:00:00'";
			$query_osm_2 = "osm_date > '{$_GET['ism_date_start']} 00:00:00'";
            $query = $query ." and " .$query2;
			$query_osm = $query_osm ." and " .$query_osm_2;
        }
        if($_GET["ism_date_start"]==""&&$_GET["ism_date_end"]!=""){
            $map["ism_date"]=array("elt","{$_GET['ism_date_end']}".' 59:59:59');
            $this->assign("in_date_end",$_GET['ism_date_end']);
            $query3 = "ism_date < '{$_GET['ism_date_end']} 59:59:59'";
			$query_osm_3 = "osm_date < '{$_GET['ism_date_end']} 59:59:59'";
            $query = $query ." and " .$query3;
			$query_osm = $query_osm ." and " .$query_osm_3;
        }

        if($_GET["ism_date_start"]!=""&&$_GET["ism_date_end"]!=""){
            $map["ism_date"]=array(array("egt","{$_GET['ism_date_start']}".' 00:00:00'),array("elt","{$_GET['ism_date_end']}".' 59:59:59'));
            $this->assign("in_date_start",$_GET['ism_date_start']);
            $this->assign("in_date_end",$_GET['ism_date_end']);

            $query4 = "ism_date > '{$_GET['ism_date_start']} 00:00:00' and ism_date < '{$_GET['ism_date_end']} 59:59:59'";
			$query_osm_4 = "osm_date > '{$_GET['ism_date_start']} 00:00:00' and osm_date < '{$_GET['ism_date_end']} 59:59:59'";
            $query = $query ." and " .$query4;
			$query_osm = $query_osm ." and " .$query_osm_4;

        }
        if($_GET["iss_prodname"]!=""){
            $_GET['iss_prodname'] =  urldecode($_GET['iss_prodname']);
            $map["iss_prodname"]=array("like","%{$_GET['iss_prodname']}%");
            $this->assign("in_prodname",$_GET['iss_prodname']);
            $query5 = "iss_prodname like '%{$_GET['iss_prodname']}%'";
			$query_osm_5 = "oss_prodname like '%{$_GET['iss_prodname']}%'";
            $query = $query ." and " .$query5;
			$query_osm = $query_osm ." and " .$query_osm_5;

        }
        if($_GET["iss_quality"]!=""){
            $map["iss_quality"]=array("like","%{$_GET['iss_quality']}%");
            $this->assign("in_quality",$_GET['iss_quality']);
            $query6 = "iss_quality like '%{$_GET['iss_quality']}%'";
			$query_osm_6 = "oss_quality like '%{$_GET['iss_quality']}%'";
            $query = $query ." and " .$query6;
			$query_osm = $query_osm ." and " .$query_osm_6;
        }

        if($_GET["iss_store"]!=""){
            $map["c.sto_name"]=array("like","%{$_GET['iss_store']}%");
            $this->assign("in_store",$_GET['iss_store']);
            $query7 = "sto_name like '%{$_GET['iss_store']}%'";

            $query = $query ." and " .$query7;
        }

        if($_GET["ism_status_time"]!=""){
            $map["ism_status_time"]=array("elt","{$_GET['ism_status_time']}".' 59:59:59');
            $this->assign("in_status_time",$_GET['ism_status_time']);
            $query8 = "ism_status_time < '{$_GET['ism_status_time']} 59:59:59'";
			$query_osm_8 = "osm_status_time < '{$_GET['ism_status_time']} 59:59:59'";
            $query = $query ." and " .$query8;
			$query_osm = $query_osm ." and " .$query_osm_8;
        }
		//库位问题新加，不统计分仓数据
		$map["iss_id_p"]=array("egt",0);
		

        $model=M("instore_sub");
        $list = $model->alias("a")->join("twms_instore_main as b on a.iss_mainid=b.ism_id")->join("twms_prod_cate as c on a.iss_cate=c.pdca_id")->
            join('twms_product d on a.iss_prod=d.prod_id')->where($map)->group("iss_prod,iss_quality,iss_store")->field('iss_prod,iss_quality,iss_store')->select();
        //$test = $model->getLastSql();
        //var_dump($model->getLastSql());
        $count=count($list);
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);

        $Model_count = new Model();
        $firstRow = $Page->firstRow;
        $listRows = $Page->listRows;
        $countsql = "select a.*,b.outcount,(a.incount - ifnull(b.outcount,0)) as allcount
                from
                (SELECT sum(iss_count) as `incount`,a.* ,b.pdca_name,d.*,c.*,e.*
                FROM twms_instore_sub a
                LEFT JOIN twms_prod_cate as b on a.iss_cate=b.pdca_id
                LEFT JOIN twms_product  as c on iss_prod=prod_id
                LEFT JOIN twms_instore_main as d on iss_mainid=ism_id
				LEFT JOIN twms_store as e on a.iss_store=e.sto_id
                 WHERE d.ism_status>0  {$query} and a.iss_id_p>=0
                 GROUP BY iss_prod,iss_quality,iss_store,iss_make_date
                )  as a
                left Join
                (SELECT oss_prod, oss_quality, SUM( oss_count ) AS `outcount`,oss_store,oss_make_date
                FROM twms_outstore_sub
                LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id
                WHERE d.osm_status >0  {$query_osm}
                GROUP BY oss_prod, oss_quality,oss_store,oss_make_date )  as b on  a.iss_prod =  b.oss_prod  and a.iss_quality  = b.oss_quality and a.iss_store=b.oss_store and a.iss_make_date=b.oss_make_date  order by allcount desc limit {$firstRow},{$listRows} ";
        $list = $Model_count->query($countsql);
        //var_dump($countsql);
        $incount_sql = "select sum(iss_count) as incount from twms_instore_sub a   LEFT JOIN twms_instore_main as d on iss_mainid=ism_id WHERE d.ism_status>0 and a.iss_id_p>=0 {$query}";
        //var_dump($incount_sql);
        $list_incount = $Model_count->query($incount_sql);
        $outcount_sql = "select sum(oss_count) as outcount from twms_outstore_sub LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id WHERE d.osm_status >0 {$query_osm}";
        $list_outcount = $Model_count->query($outcount_sql);
        $count = $list_incount[0]['incount'] - $list_outcount[0]['outcount'];
        $this->assign("count",$count);
        $this->assign("list",$list);
        $this->display('index');
    }



    public function filter(){
        import("@.ORG.Util.Page");
        $test = $_GET['iss_prod'];
        $test2 =  $_GET['iss_cate'];
        $test3 =  $_GET['iss_quality'];
        if($test!=''){
            $condition = "iss_prod = ".$test;
        }
        if($test2!=''){
            $condition = "iss_cate = ".$test2;
        }
        if($test3!=''){
            $condition = "iss_quality = '".$test3."'";
        }
        $Model = new Model();
        $sql1 = "SELECT iss_prod,iss_quality FROM (select * from twms_instore_sub where $condition ) a LEFT JOIN twms_prod_cate as b on a.iss_cate=b.pdca_id LEFT JOIN twms_product on iss_prod=prod_id GROUP BY iss_prod,iss_quality";
        $list1 = $Model->query($sql1);

        $count=count($list1);
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        if($_GET['order']==''){
            $order='iss_id asc';
        }else{
            $order='iss_id '.$_GET['order'];
        }
        $this->assign("order",$_GET['order']);
        $sql2 = "SELECT a.*,b.pdca_name,prod_name,sum(iss_count) as `count`,sum(iss_total) as `total` FROM (select * from twms_instore_sub where $condition ) a LEFT JOIN twms_prod_cate as b on a.iss_cate=b.pdca_id LEFT JOIN twms_product on iss_prod=prod_id GROUP BY iss_prod,iss_quality ORDER BY iss_id asc";
        $list2=$Model->query($sql2);
        $this->assign("list2",$list2);
        //$this->assign("temp1",$sql1);
        //$this->assign("temp2",$sql2);
        $this->display();
    }

    public function exportStore(){

        $query =" ";
		$query_osm =" "; 
        if($_POST["in_sellerunit"]!=""){
           $query = $query." and "."ism_sellerunit like '%{$_POST["in_sellerunit"]}%'";
		   $query_osm = $query_osm." and "."osm_buyerunit like '%{$_POST["in_sellerunit"]}%'";
        }
        if($_POST["in_prodname"]!=""){
           // $map["a.iss_prodname"]=array("like","%{$_POST['in_prodname']}%");
            $query = $query." and "."iss_prodname like '%{$_POST["in_prodname"]}%'";
			$query_osm = $query_osm." and "."oss_prodname like '%{$_POST["in_prodname"]}%'";
        }
        if($_POST["in_store"]!=""){
           // $map["c.sto_name"]=array("like","%{$_POST['in_store']}%");
            $query = $query." and "."sto_name like '%{$_POST["in_store"]}%'";
			
        }
        if($_POST["in_date_start"]!=""&&$_POST["in_date_end"]=="")
        {
           // $map["b.ism_date"]=array("egt","{$_POST["in_date_start"]}".' 00:00:00');

            $query = $query." and "."ism_date > '{$_POST["in_date_start"]} 00:00:00'";
			$query_osm = $query_osm." and "."osm_date > '{$_POST["in_date_start"]} 00:00:00'";

        }
        if($_POST["in_date_start"]==""&&$_POST["in_date_end"]!="")
        {
            //$map["b.ism_date"]=array("elt","{$_POST["in_date_end"]}".' 59:59:59');
            $query = $query." and "."ism_date < '{$_POST["in_date_end"]} 59:59:59'";
			$query_osm = $query_osm." and "."osm_date < '{$_POST["in_date_end"]} 59:59:59'";
        }

        if($_POST["in_status_time"]!="")
        {
            //$map["b.ism_date"]=array("elt","{$_POST["in_date_end"]}".' 59:59:59');
            $query = $query." and "."ism_status_time < '{$_POST["in_status_time"]} 59:59:59'";
            $query_osm = $query_osm." and "."osm_status_time < '{$_POST["in_status_time"]} 59:59:59'";
        }

        if($_POST["in_date_start"]!=""&&$_POST["in_date_end"]!=""){
            //$map["b.ism_date"]=array(array("egt","{$_POST["in_date_start"]}".' 00:00:00'),array("elt","{$_POST["in_date_end"]}".' 59:59:59'));
            $query = $query." and "."ism_date > '{$_POST["in_date_start"]} 00:00:00' and ism_date < '{$_POST["in_date_end"]} 59:59:59'";
			$query_osm = $query_osm." and "."osm_date > '{$_POST["in_date_start"]} 00:00:00' and osm_date < '{$_POST["in_date_end"]} 59:59:59'";

        }
        if($_POST["in_quality"]!=""){
            $query = $query." and "."iss_quality like '%{$_POST["in_quality"]}%'";
			$query_osm = $query_osm." and "."oss_quality like '%{$_POST["in_quality"]}%'";
        }
        $xlsName  = "库存统计";

        if(($_SESSION['user']['user_type']==1||$_SESSION['user']['user_type']==4)){
            $xlsCell  = array(
                array('ism_sellerunit','客户单位'),
                array('iss_prodname','品名规格'),
				array('prod_code','编码'),
                array('pdca_name','货物类别'),
                array('iss_quality','质量类别'),
				array('iss_make_date','生产日期'),
                array('allcount','库存数量'),
				array('prod_weight','单件重量'),
				array('store_name','仓库/库位'),
                array('prod_unit','计价单位'),
                array('prod_price','装卸成本单价'),
                array('prod_realprice','装卸收入单价')
            );
            $filed = 'ism_sellerunit,iss_prodname,prod_code,pdca_name,iss_quality,iss_make_date,(incount - ifnull(outcount,0)) as allcount,prod_weight,concat(sto_name,"/",sto_kuwei_name) as store_name,prod_unit,prod_price,prod_realprice';
        }else{
            $xlsCell  = array(
                array('ism_sellerunit','客户单位'),
                array('iss_prodname','品名规格'),
				array('prod_code','编码'),
                array('pdca_name','货物类别'),
                array('iss_quality','质量类别'),
				array('iss_make_date','生产日期'),
                array('allcount','库存数量'),
				array('prod_weight','单件重量'),
				array('store_name','仓库/库位'),
                array('prod_unit','计价单位')
            );
            $filed = 'ism_sellerunit,iss_prodname,prod_code,pdca_name,iss_quality,iss_make_date,(incount - ifnull(outcount,0)) as allcount,prod_weight,concat(sto_name,"/",sto_kuwei_name) as store_name,prod_unit';
        }

        $Model_count = new Model();
        $countsql = "select {$filed}
                from
                (SELECT sum(iss_count) as `incount`,a.* ,b.pdca_name,d.*,c.*,e.*
                FROM twms_instore_sub a
                LEFT JOIN twms_prod_cate as b on a.iss_cate=b.pdca_id
                LEFT JOIN twms_product  as c on iss_prod=prod_id
                LEFT JOIN twms_instore_main as d on iss_mainid=ism_id
				LEFT JOIN twms_store as e on a.iss_store=e.sto_id
                 WHERE d.ism_status>0 and a.iss_id_p>=0 {$query} 
                 GROUP BY iss_prod,iss_quality,iss_store,iss_make_date
                )  as a
                left Join
                (SELECT oss_prod, oss_quality, SUM( oss_count ) AS `outcount`,oss_store,oss_make_date
                FROM twms_outstore_sub
                LEFT JOIN twms_outstore_main AS d ON oss_mainid = osm_id
                WHERE d.osm_status >0 {$query_osm}
                GROUP BY oss_prod, oss_quality,oss_store,oss_make_date )  as b on  a.iss_prod =  b.oss_prod  and a.iss_quality  = b.oss_quality and a.iss_store  = b.oss_store and a.iss_make_date=b.oss_make_date order by allcount desc";
        $list = $Model_count->query($countsql);
        //var_dump($countsql);
        $common = new CommonAction();
        $common->exportExcel($xlsName,$xlsCell,$list);

    }






    private function echoExecl($records)
    {
        error_reporting(E_ALL);
        Vendor('Execl.PHPExcel');
        Vendor('Execl.PHPExcel.IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->setActiveSheetIndex(0);
        $arrStyle_title = array(
            'font'=>array(
                'bold'=>true,
                'size'=>18,
                'color'=>array('argb'=>'FF000000'),
            ),
            'alignment'=>array(
                'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $arrStyle_column = array(
            'font'=>array(
                'bold'=>true,
                'size'=>12,
                'color'=>array('argb'=>'FFFFFFFF'),
            ),
            'alignment'=>array(
                'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders'=>array(
                'top'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN,
                ),
                'bottom'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'fill'=>array(
                'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                'color'=>array('argb'=>'FF969696'),
            )
        );
        $arrStyle_right = array(
            'borders'=>array(
                'right'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN,
                )
            )
        );
        $arrStyle_content_column = array(
            'alignment'=>array(
                'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->setCellValue('A1','库存统计');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($arrStyle_title);
        $objPHPExcel->getActiveSheet()
            ->setCellValue('A2','产品')
            ->setCellValue('B2','单价')
            ->setCellValue('C2','数量')
            ->setCellValue('D2','总价')
            ->setCellValue('E2','仓库');
        $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($arrStyle_column);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(array('borders'=>array('left'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN))));
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($arrStyle_right);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        foreach($records as $key=>$list ){
            $A = $list['iss_name'];
            $B = $list['iss_price'];
            $C = $list['count'];
            $D = $list['total'];
            $E = $list['iss_store'];
            $n=$key+3;
            $objPHPExcel->getActiveSheet()->getStyle('A'.$n)->applyFromArray($arrStyle_content_column);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$n)->applyFromArray($arrStyle_content_column);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$n)->applyFromArray($arrStyle_content_column);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$n)->applyFromArray($arrStyle_content_column);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$n)->applyFromArray($arrStyle_content_column);
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.$n,$A)
                ->setCellValue('B'.$n,$B)
                ->setCellValue('C'.$n,$C)
                ->setCellValue('D'.$n,$D)
                ->setCellValue('E'.$n,$E);
        }
        $objPHPExcel->getActiveSheet()->setTitle('库存统计');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="OA_total.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
	//移库，创建出库和入库
	public function moveStore(){
		$prod_id = $_GET['prod_id'];
		$prod_name = $_GET['prod_name'];
		$pdca_id = $_GET['pdca_id'];
		$prod_quality = $_GET['prod_quality'];
		$prod_unit = $_GET['prod_unit'];
		$iss_make_date = $_GET['iss_make_date'];
		$prod_allcount = $_GET['prod_allcount'];
		$source_store_id = $_GET['source_store_id'];
		$target_store_id = $_GET['target_store_id'];
		//echo "<script>alert('$source_store_id 测试 $target_store_id ');window.history.back();</script>";
        //    die;
		
		$sellerunit = $_GET['sellerunit'];
		//创建出库单据  outstore_main
		$model_outstore_main=M("outstore_main");
		$outstore_main['osm_sn'] = 'OUT-'.date('Ymd-His-').rand(100,999);
		$outstore_main['osm_operator'] = $_SESSION['user']['user_realname'];
		$outstore_main['osm_writer'] = $outstore_main['osm_operator'];
		$outstore_main['osm_submiter'] = $outstore_main['osm_operator'];
		$outstore_main['osm_date'] = date('Y-m-d H:i:s');
		$outstore_main['osm_submit_time'] = $outstore_main['osm_date'];
		$outstore_main['osm_danju_date'] = $outstore_main['osm_date'];
		$outstore_main['osm_status_time'] = $outstore_main['osm_date'];
		$outstore_main['osm_buyerunit'] = $sellerunit;
		$outstore_main['osm_danju_no'] = '移库-'.date('Ymd');	
		$outstore_main['osm_carry'] = '其他';
		$outstore_main['osm_status'] = 1;
		$outstore_main_id=$model_outstore_main->add($outstore_main);
		//创建出库单据 outstore_sub
		$model_outstore_sub=M("outstore_sub");
		$outstore_sub['oss_mainid'] = $outstore_main_id;
		$outstore_sub['oss_prod'] = $prod_id;
		$outstore_sub['oss_prodname'] = $prod_name;
		$outstore_sub['oss_cate'] = $pdca_id;
		$outstore_sub['oss_count'] = $prod_allcount;
		$outstore_sub['oss_plancount'] = $prod_allcount;
		$outstore_sub['oss_store'] = $source_store_id;
		$outstore_sub['oss_quality'] = $prod_quality;
		$outstore_sub['oss_unit'] = $prod_unit;

		if($iss_make_date != "invalid"){
			$outstore_sub["oss_make_date"] = date('Y-m-d',strtotime($iss_make_date));
		}
		
		$model_outstore_sub->add($outstore_sub);
		//创建入库单据 instore_main
		$model_instore_main=M("instore_main");
		$instore_main['ism_sn'] = 'IN-'.date('Ymd-His-').rand(100,999);
		$instore_main['ism_operator'] = $_SESSION['user']['user_realname'];
		$instore_main['ism_writer'] = $instore_main['ism_operator'];
		$instore_main['ism_submiter'] = $instore_main['ism_operator'];
		$instore_main['ism_date'] = date('Y-m-d H:i:s');
		$instore_main['ism_submit_time'] = $instore_main['ism_date'];
		$instore_main['ism_danju_date'] = $instore_main['ism_date'];
		$instore_main['ism_status_time'] = $instore_main['ism_date'];
		$instore_main['ism_sellerunit'] = $sellerunit;
		$instore_main['ism_danju_no'] = '移库-'.date('Ymd');	
		$instore_main['ism_carry'] = '其他';
		$instore_main['ism_status'] = 1;
		$instore_main_id=$model_instore_main->add($instore_main);
		//创建入库单据 instore_sub
		$model_instore_sub=M("instore_sub");
		$instore_sub['iss_mainid'] = $instore_main_id;
		$instore_sub['iss_prod'] = $prod_id;
		$instore_sub['iss_prodname'] = $prod_name;
		$instore_sub['iss_cate'] = $pdca_id;
		$instore_sub['iss_count'] = $prod_allcount;
		$instore_sub['iss_plancount'] = $prod_allcount;
		$instore_sub['iss_store'] = $target_store_id;
		$instore_sub['iss_quality'] = $prod_quality;
		$instore_sub['iss_unit'] = $prod_unit;
		if($iss_make_date != "invalid"){
			$instore_sub["iss_make_date"] = date('Y-m-d',strtotime($iss_make_date));
		}
		$model_instore_sub->add($instore_sub);
		$this->redirect("index");
	}

}
?>