<?php

class SettingAction extends AppAction{
    public function index() {
        $model=M('user');
        $one=$model->where(array('user_id'=>$_SESSION['user']['user_id']))->find();
        $this->assign('one',$one);
        $this->display();
    }
    public function doEdit(){
        $model=M('user');
        $data['user_id']=$_POST['user_id'];
        $data['user_name']=$_POST['user_name'];
        $data['user_realname']=$_POST['user_realname'];
        if($_POST['user_password']!=''){
            $data['user_password']=md5($_POST['user_password']);
        }
        $model->save($data);
        $user=$model->where(array('user_id'=>$_SESSION['user']['user_id']))->find();
        session_start();
        $_SESSION['user']=$user;
        echo json_encode($user);
    }
}
?>