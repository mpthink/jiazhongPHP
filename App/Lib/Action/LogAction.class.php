<?php

class LogAction extends AppAction{
    public function index() {
        if($_SESSION['user']['user_type']!=1&&$_SESSION['user']['user_type']!=5){
            echo "<script>alert('您不是管理员，没有访问权限！');window.history.back();</script>";
            die;
        }
        import("@.ORG.Util.Page");
        $model=M("log");
        if($_GET["keyword"]!=''){
            $map[$_GET["searchBy"]]=array("like","%{$_GET['keyword']}%");
        }
        $count=$model->where($map)->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->where($map)->order("log_id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("list",$list);
        $this->assign("searchBy",$_GET['searchBy']);
        $this->assign("keyword",$_GET['keyword']);
        $this->display();
    }
    public function clearLog(){
        $model=M("log");
        $model->where(array("log_id"=>array("neq","")))->delete();
        $this->redirect("index");
    }
}
?>