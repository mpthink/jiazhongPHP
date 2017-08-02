<?php

class UserManageAction extends AppAction{
    public function index() {
        if($_SESSION['user']['user_type']!=1){
            echo "<script>alert('您不是管理员，没有访问权限！');window.history.back();</script>";
            die;
        }
        import("@.ORG.Util.Page");
        $model=M("user");
        $count=$model->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->order("user_id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("list",$list);
        $this->display();
    }
    public function view(){
        $model=M("user");
        $map["user_id"]=$_GET["user_id"];
        $one=$model->where($map)->find();
        echo json_encode($one);
    }
    public function delete(){
        $model=M("User");
        $model->where(array('user_id'=>$_GET["user_id"]))->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("删除用户");
        $this->redirect("index");
    }
    public function doAdd(){
        $model=M("User");
        $_GET['user_password']=md5($_GET['user_password']);
        $model->add($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("添加用户");
        $this->redirect("index");
    }
    public function toEdit(){
        $model=M("User");
        $one=$model->where(array('user_id'=>$_GET['user_id']))->find();
        $this->assign("one",$one);
        $this->display();
    }
    public function doEdit(){
        $model=M("User");
        if($_GET['user_password']==''){
            unset($_GET['user_password']);
        }else{
            $_GET['user_password']=md5($_GET['user_password']);
        }
        $one=$model->save($_GET);
        $user=$model->where(array('user_id'=>$_GET['user_id']))->find();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("编辑用户");
        $this->redirect("index");
    }
}
?>