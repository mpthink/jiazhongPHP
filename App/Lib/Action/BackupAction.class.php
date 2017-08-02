<?php

import('AdvModel');
import("@.Action.DbManager");
class BackupAction extends AppAction{
    public function index() {
        if($_SESSION['user']['user_type']!=1&&$_SESSION['user']['user_type']!=5){
            echo "<script>alert('user type is wrong');window.history.back();</script>";
            die;
        }
        import("@.ORG.Util.Page");
        $model=M("backup");
        $count = $model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order('back_id desc')->select();
        $this->assign("list",$list);
        $this->display();
    }
    public function backup(){
        $dbmanage=new DbManager();
        $result_array=$dbmanage->backup();
        $model=M("backup");
        $data["back_name"]=$result_array["name"];
        $data["back_path"]=$result_array["path"];
        $model->add($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("backup");
        $this->redirect('index');
    }
	
	//http://localhost/cang/index.php?s=/Backup/repair
	public function repair(){
        $dbmanage=new DbManager();
        $dbmanage->repair();
    }
	
    public function resume(){
        $dbmanage=new DbManager();
        $model=M("backup");
        $one=$model->where(array('back_id'=>$_GET['back_id']))->find();
        $dbmanage->resume($one["back_path"]);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("resume");
        $this->redirect('index');
    }
    public function delete(){
        $model=M("backup");
        $one=$model->where(array('back_id'=>$_GET['back_id']))->find();
        unlink($one["back_path"]);
        $model->where(array('back_id'=>$_GET['back_id']))->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("delete");
        $this->redirect('index');
    }
}
?>