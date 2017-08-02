<?php
/**
 * Think仓储管理系统
 * @author:duncan
 * @date:2011-11-7
 * @qq:575773080
 * @email:575773080@qq.com
 */
class SysLog{
	public static function writeLog($action){
		$model=M("log");
		$data["log_operator_name"]=$_SESSION['user']["user_name"];
		$data["log_operator_realname"]=$_SESSION['user']["user_realname"];
		$data["log_datetime"]=date("Y-m-d H:i:s");
		$data["log_action"]=$action;
		$data["log_ip"]=$_SERVER["REMOTE_ADDR"];
		$model->add($data);
	}
}
?>
