<?php

class IndexAction extends AppAction{
    public function index() {
        $this->display();
    }
    private function writeLoginInfo(){
        $model=M("user");
        $data["user_lastlogindate"]=date("Y-m-d H:i:s");
        $data["user_lastloginip"]=$_SERVER["REMOTE_ADDR"];
        $model->where(array("user_id"=>$_SESSION['user']['user_id']))->save($data);
    }
    public function verify(){
        $type=isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Util.Image");
        Image::buildImageVerify(4,1,$type);
    }
    public function login(){
        $this->display('login');
    }

    public function main(){
        Load('extend');
        $model_insub=M("instore_sub");
        $model_outsub=M("outstore_sub");
        $today_start=date("Y-m-d")." 00:00:00";
        $today_end=date("Y-m-d")." 59:59:59";
        $this_month_start=date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y'))).' 00:00:00';
        $this_month_end=date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y'))).' 59:59:59';
        $instore_month=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("ism_status_time>'$this_month_start' and ism_status_time<'$this_month_end' and b.ism_status>0 and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_month['count']=$instore_month['count']==null?0:$instore_month['count'];
        $instore_month['total']=$instore_month['total']==null?0:$instore_month['total'];
        $this->assign("instore_month",$instore_month);

        $outstore_month=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("osm_status_time>'$this_month_start' and osm_status_time<'$this_month_end' and b.osm_status>0")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_month['count']=$outstore_month['count']==null?0:$outstore_month['count'];
        $outstore_month['total']=$outstore_month['total']==null?0:$outstore_month['total'];
        $this->assign("outstore_month",$outstore_month);
        
        $instore_count=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
		
        $instore_count['count']=$instore_count['count']==null?0:$instore_count['count'];
        $instore_count['total']=$instore_count['total']==null?0:$instore_count['total'];
        $this->assign("instore_count",$instore_count);
        
        $instore_toady_count=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("ism_status_time>'$today_start' and ism_status_time<'$today_end' and b.ism_status>0 and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();

        $instore_toady_count['count']=$instore_toady_count['count']==null?0:$instore_toady_count['count'];
        $instore_toady_count['total']=$instore_toady_count['total']==null?0:$instore_toady_count['total'];
        $this->assign("instore_toady_count",$instore_toady_count);
        
        $outstore_count=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count['count']=$outstore_count['count']==null?0:$outstore_count['count'];
        $outstore_count['total']=$outstore_count['total']==null?0:$outstore_count['total'];
        $this->assign("outstore_count",$outstore_count);
        
        $outstore_today_count=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("osm_status_time>'$today_start' and osm_status_time<'$today_end' and b.osm_status>0")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_today_count['count']=$outstore_today_count['count']==null?0:$outstore_today_count['count'];
        $outstore_today_count['total']=$outstore_today_count['total']==null?0:$outstore_today_count['total'];
        $this->assign("outstore_today_count",$outstore_today_count);
        
        $time=time();
        $date_re_1=date('Y-m-d',$time-3600*24*1);
        $date_re_2=date('Y-m-d',$time-3600*24*2);
        $date_re_3=date('Y-m-d',$time-3600*24*3);
        $date_re_4=date('Y-m-d',$time-3600*24*4);
        $date_re_5=date('Y-m-d',$time-3600*24*5);
        $date_re_6=date('Y-m-d',$time-3600*24*6);
        $date_today=date('Y-m-d');
        $instore_count_date_re_6=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and ism_status_time>='$date_re_6 00:00:00' and ism_status_time<='$date_re_6 59:59:59' and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_count_date_re_5=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and ism_status_time>='$date_re_5 00:00:00' and ism_status_time<='$date_re_5 59:59:59' and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_count_date_re_4=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and ism_status_time>='$date_re_4 00:00:00' and ism_status_time<='$date_re_4 59:59:59' and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_count_date_re_3=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and ism_status_time>='$date_re_3 00:00:00' and ism_status_time<='$date_re_3 59:59:59' and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_count_date_re_2=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and ism_status_time>='$date_re_2 00:00:00' and ism_status_time<='$date_re_2 59:59:59' and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_count_date_re_1=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and ism_status_time>='$date_re_1 00:00:00' and ism_status_time<='$date_re_1 59:59:59' and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_count_date_doday=$model_insub->alias('a')->join('twms_instore_main b on a.iss_mainid	=b.ism_id')->where("b.ism_status>0 and ism_status_time>='$date_today 00:00:00' and ism_status_time<='$date_today 59:59:59' and a.iss_id_p>=0")->field("sum(iss_count) as count,sum(iss_total) as total")->find();
        $instore_count_date_re_6['count']=$instore_count_date_re_6['count']==null?0:$instore_count_date_re_6['count'];
        $instore_count_date_re_5['count']=$instore_count_date_re_5['count']==null?0:$instore_count_date_re_5['count'];
        $instore_count_date_re_4['count']=$instore_count_date_re_4['count']==null?0:$instore_count_date_re_4['count'];
        $instore_count_date_re_3['count']=$instore_count_date_re_3['count']==null?0:$instore_count_date_re_3['count'];
        $instore_count_date_re_2['count']=$instore_count_date_re_2['count']==null?0:$instore_count_date_re_2['count'];
        $instore_count_date_re_1['count']=$instore_count_date_re_1['count']==null?0:$instore_count_date_re_1['count'];
        $instore_count_date_doday['count']=$instore_count_date_doday['count']==null?0:$instore_count_date_doday['count'];
        $this->assign("line_count_in","[{$instore_count_date_re_6['count']},{$instore_count_date_re_5['count']},{$instore_count_date_re_4['count']},{$instore_count_date_re_3['count']},{$instore_count_date_re_2['count']},{$instore_count_date_re_1['count']},{$instore_count_date_doday['count']}]");
        $instore_count_date_re_6['total']=$instore_count_date_re_6['total']==null?0:$instore_count_date_re_6['total'];
        $instore_count_date_re_5['total']=$instore_count_date_re_5['total']==null?0:$instore_count_date_re_5['total'];
        $instore_count_date_re_4['total']=$instore_count_date_re_4['total']==null?0:$instore_count_date_re_4['total'];
        $instore_count_date_re_3['total']=$instore_count_date_re_3['total']==null?0:$instore_count_date_re_3['total'];
        $instore_count_date_re_2['total']=$instore_count_date_re_2['total']==null?0:$instore_count_date_re_2['total'];
        $instore_count_date_re_1['total']=$instore_count_date_re_1['total']==null?0:$instore_count_date_re_1['total'];
        $instore_count_date_doday['total']=$instore_count_date_doday['total']==null?0:$instore_count_date_doday['total'];
        $this->assign("line_total_in","[{$instore_count_date_re_6['total']},{$instore_count_date_re_5['total']},{$instore_count_date_re_4['total']},{$instore_count_date_re_3['total']},{$instore_count_date_re_2['total']},{$instore_count_date_re_1['total']},{$instore_count_date_doday['total']}]");
        $outstore_count_date_re_6=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0 and osm_status_time>='$date_re_6 00:00:00' and osm_status_time<='$date_re_6 59:59:59'")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count_date_re_5=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0 and osm_status_time>='$date_re_5 00:00:00' and osm_status_time<='$date_re_5 59:59:59'")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count_date_re_4=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0 and osm_status_time>='$date_re_4 00:00:00' and osm_status_time<='$date_re_4 59:59:59'")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count_date_re_3=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0 and osm_status_time>='$date_re_3 00:00:00' and osm_status_time<='$date_re_3 59:59:59'")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count_date_re_2=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0 and osm_status_time>='$date_re_2 00:00:00' and osm_status_time<='$date_re_2 59:59:59'")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count_date_re_1=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0 and osm_status_time>='$date_re_1 00:00:00' and osm_status_time<='$date_re_1 59:59:59'")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count_date_today=$model_outsub->alias('a')->join('twms_outstore_main b on a.oss_mainid	=b.osm_id')->where("b.osm_status>0 and osm_status_time>='$date_today 00:00:00' and osm_status_time<='$date_today 59:59:59'")->field("sum(oss_count) as count,sum(oss_total) as total")->find();
        $outstore_count_date_re_6['count']=$outstore_count_date_re_6['count']==null?0:$outstore_count_date_re_6['count'];
        $outstore_count_date_re_5['count']=$outstore_count_date_re_5['count']==null?0:$outstore_count_date_re_5['count'];
        $outstore_count_date_re_4['count']=$outstore_count_date_re_4['count']==null?0:$outstore_count_date_re_4['count'];
        $outstore_count_date_re_3['count']=$outstore_count_date_re_3['count']==null?0:$outstore_count_date_re_3['count'];
        $outstore_count_date_re_2['count']=$outstore_count_date_re_2['count']==null?0:$outstore_count_date_re_2['count'];
        $outstore_count_date_re_1['count']=$outstore_count_date_re_1['count']==null?0:$outstore_count_date_re_1['count'];
        $outstore_count_date_today['count']=$outstore_count_date_today['count']==null?0:$outstore_count_date_today['count'];
        $this->assign("line_count_out","[{$outstore_count_date_re_6['count']},{$outstore_count_date_re_5['count']},{$outstore_count_date_re_4['count']},{$outstore_count_date_re_3['count']},{$outstore_count_date_re_2['count']},{$outstore_count_date_re_1['count']},{$outstore_count_date_today['count']}]");
        $outstore_count_date_re_6['total']=$outstore_count_date_re_6['total']==null?0:$outstore_count_date_re_6['total'];
        $outstore_count_date_re_5['total']=$outstore_count_date_re_5['total']==null?0:$outstore_count_date_re_5['total'];
        $outstore_count_date_re_4['total']=$outstore_count_date_re_4['total']==null?0:$outstore_count_date_re_4['total'];
        $outstore_count_date_re_3['total']=$outstore_count_date_re_3['total']==null?0:$outstore_count_date_re_3['total'];
        $outstore_count_date_re_2['total']=$outstore_count_date_re_2['total']==null?0:$outstore_count_date_re_2['total'];
        $outstore_count_date_re_1['total']=$outstore_count_date_re_1['total']==null?0:$outstore_count_date_re_1['total'];
        $outstore_count_date_today['total']=$outstore_count_date_today['total']==null?0:$outstore_count_date_today['total'];
        $this->assign("line_total_out","[{$outstore_count_date_re_6['total']},{$outstore_count_date_re_5['total']},{$outstore_count_date_re_4['total']},{$outstore_count_date_re_3['total']},{$outstore_count_date_re_2['total']},{$outstore_count_date_re_1['total']},{$outstore_count_date_today['total']}]");
        $date_re_6=date('m-d',strtotime($date_re_6));
        $date_re_5=date('m-d',strtotime($date_re_5));
        $date_re_4=date('m-d',strtotime($date_re_4));
        $date_re_3=date('m-d',strtotime($date_re_3));
        $date_re_2=date('m-d',strtotime($date_re_2));
        $date_re_1=date('m-d',strtotime($date_re_1));
        $date_today=date('m-d',strtotime($date_today));
        $this->assign("line_cate","['$date_re_6','$date_re_5','$date_re_4','$date_re_3','$date_re_2','$date_re_1','$date_today']");
        $list_notice=M("notice")->order("ntc_id desc")->limit(C('INDEX_NOTICE_PAGE_SIZE'))->select();
        $this->assign("list_notice",$list_notice);
        $this->assign("version","1.0");
        $trialEndDate=date("Y-m-d",$this->endStamp);
        $this->display('main');
    }

    public function doLogin(){
        header('Content-Type:text/html;charset=utf-8');
        $model=M("user");
        $user=$model->where(array("user_name"=>trim($_GET['user_name'])))->find();
        if($user==null){
            echo 1;
            die;
        }
        if($user["user_password"]!=md5(trim($_GET["user_password"]))){
            echo 2;
            die;
        }
        session_start();
        $_SESSION["user"]=$user;
        import('@.ORG.Util.SysLog');
        SysLog::writeLog('login succesfully');
        $this->writeLoginInfo();
        echo 4;
    }
    public function loginOut(){
        session_destroy();
        $this->redirect("index");
    }
    public function header(){
        $this->assign('user_realname',$_SESSION["user"]["user_realname"]);
        $this->display();
    }
    public function menu(){
        $this->display();
    }

    public function noticeView(){
        $model=M("notice");
        $one=$model->where(array('ntc_id'=>$_GET['ntc_id']))->find();
        echo json_encode($one);
    }
}
?>