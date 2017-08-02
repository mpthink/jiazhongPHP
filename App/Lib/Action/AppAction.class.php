<?php

class AppAction extends Action{
    function __construct(){
        parent::__construct();
        session_start();
        if($_SESSION["user"]==null &&MODULE_NAME!='Index'&&(ACTION_NAME!='login'||ACTION_NAME!='doLogin'||ACTION_NAME!='verify')){
            echo "<script>window.parent.location='".U('Index/login')."'</script>";
            die;
        }elseif($_SESSION["user"]==null &&MODULE_NAME=='Index'&&(ACTION_NAME=='header'||ACTION_NAME=='menu'||ACTION_NAME=='main')){
            echo "<script>window.parent.location='".U('Index/login')."'</script>";
            die;
        }
    }
}
?>