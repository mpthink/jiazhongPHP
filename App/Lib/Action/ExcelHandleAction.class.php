<?php

vendor('PHPExcel.PHPExcel');

class ExcelHandleAction extends AppAction{

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
}
?>