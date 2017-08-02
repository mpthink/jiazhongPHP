<?php

class NoticeManageAction extends AppAction{
    public function index() {
        Load('extend');
        import("@.ORG.Util.Page");
        $model=M("notice");
        if($_GET["searchBy"]!=""){
            switch($_GET["searchBy"]){
                case "0":
                    $where["ntc_title"]=array("like","%{$_GET['keyword']}%");
                    $where["ntc_content"]=array("like","%{$_GET['keyword']}%");
                    $where["ntc_author"]=array("like","%{$_GET['keyword']}%");
                    $where["_logic"]="or";
                    $map["_complex"]=$where;
                    break;
                case "1":
                    $map["ntc_title"]=array("like","%{$_GET['keyword']}%");
                    break;
                case "2":
                    $map["ntc_content"]=array("like","%{$_GET['keyword']}%");
                    break;
                case "3":
                    $map["ntc_author"]=array("like","%{$_GET['keyword']}%");
            }
        };
        $count = $model->where($map)->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $this->assign('page',$show);
        $list=$model->limit($Page->firstRow.','.$Page->listRows)->order("ntc_id desc")->where($map)->select();
        $this->assign("searchBy",$_GET["searchBy"]);
        $this->assign("keyword",$_GET["keyword"]);
        $this->assign("list",$list);
        $this->display();
    }
    public function add(){
        $this->display();
    }
    public function doAdd(){
        $model=M("notice");
        $model->add($_GET);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("add notice");
        $this->redirect("index");
    }
    public function toEdit(){
        $model=M("notice");
        $this->assign("one",$model->where($_GET)->find());
        $this->display();
    }
    public function doEdit(){
        $model=M("notice");
        $data['ntc_title']=$_GET['ntc_title'];
        $data['ntc_content']=$_GET['ntc_content'];
        $data['ntc_author']=$_GET['ntc_author'];
        $model->where(array('ntc_id'=>$_GET['ntc_id']))->save($data);
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("edit notice");
        $this->redirect("index");
    }
    public function delete(){
        $model=M("notice");
        $model->where($_GET)->delete();
        import('@.ORG.Util.SysLog');
        SysLog::writeLog("delete notice");
        $this->redirect("index");
    }
    public function view(){
        $model=M("notice");
        $one=$model->where(array('ntc_id'=>$_GET['ntc_id']))->find();
        echo json_encode($one);
    }
}
?>