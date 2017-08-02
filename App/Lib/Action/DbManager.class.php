<?php

class DbManager
{
    private $dbname;
    private $link;
	private $cang7_tables;
    public function __construct() {
        $this->link=mysql_connect(C('DB_HOST'),C('DB_USER'),C('DB_PWD'));
        $this->dbname=C('DB_NAME');
        mysql_select_db($this->dbname,$this->link);
        mysql_query("set names 'utf8'");
		$this->cang7_tables=mysql_query("show tables");
    }
	
	public function repair(){
		while($cang7_table=mysql_fetch_array($this->cang7_tables)){
			$check_rs = mysql_query("check table `$cang7_table[0]`");
			$check_arr = mysql_fetch_array($check_rs);
			echo "check table $cang7_table[0], table status: $check_arr[3] <br>";
			if($check_arr[3]!="OK"){
				$repair_rs = mysql_query("repair table `$cang7_table[0]`"); 
				$repir_arr=mysql_fetch_array($rs);
				echo "repair table $cang7_table[0] , result: $repir_arr[3] <br>";
			}
		}
	}
	
    public function backup()
    {
        $r1=mysql_query("SHOW TABLES");
        while($row=mysql_fetch_array($r1)){
            $table=$row[0];
            $mysql.="DROP TABLE IF EXISTS `".$table."`;";
            $r2=mysql_query("SHOW CREATE TABLE `$table`");
            $sql=mysql_fetch_array($r2);
            $mysql.=$sql['Create Table'].";";
            $r3=mysql_query("SELECT * FROM `$table`");
            while($data=mysql_fetch_assoc($r3)){
                $keys=array_keys($data);
                $keys=array_map('addslashes',$keys);
                $keys=join('`,`',$keys);
                $keys="`".$keys."`";
                $vals=array_values($data);
                $vals=array_map('addslashes',$vals);
                $vals=join("','",$vals);
                $vals="'".$vals."'";
                $mysql.="insert into `$table`($keys) values($vals);";
            }
        }
        $filename=date("Y-m-d__H-i-s").".sql";
        $fp = fopen(APP_PATH.'/Backup/'.$filename,'w');
        fputs($fp,$mysql);
        $n=filesize($filename)/1024;
        fclose($fp);
        $result_array=array("name"=>$filename,"path"=>APP_PATH.'/Backup/'.$filename);
        return $result_array;
    }
    public function resume($file)
    {
        import('AdvModel');
        $str=file_get_contents($file);
        $str=trim(str_replace("\r","\n",$str));
        $arr=explode(";\n",trim($str));
        foreach($arr as $k =>$v){
            if($v!=''){
                $a=explode("\n",$v);
                foreach($a as $k1=>$v1){
                    if($v1!=''){
                        $oSql.=str_replace(strstr($v1,'--'),'',$v1);
                    }
                }
                if($oSql!=''){
                    $sql_array=explode(";",$oSql);
                    unset($sql_array[count($sql_array)-1]);
                    $advModel=new AdvModel();
                    $advModel->patchQuery($sql_array);
                }
            }
        }
    }
}
?>