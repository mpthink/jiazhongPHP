<?php

Vendor('PHPExcel.PHPExcel');
vendor("PHPExcel.IOFactory");
class CommonAction extends AppAction{
    /**
    +----------------------------------------------------------
     * Export Excel
     * Author:mpthink <46913825@qq.com>
    +----------------------------------------------------------
     * @param $expTitle     string File name
    +----------------------------------------------------------
     * @param $expCellName  array  Column name
    +----------------------------------------------------------
     * @param $expTableData array  Table data
    +----------------------------------------------------------
     */
    public function exportExcel($expTitle,$expCellName,$expTableData){


		set_time_limit(0);


        function loader($class) {
            $file = $class . '.php';
            if (is_file($file))
            {require_once($file);}
        }
        spl_autoload_register('loader');
		
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;  
		$cacheSettings = array(' memoryCacheSize'  => '8MB');  
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $_SESSION['user']['user_type'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  导出时间:'.date('Y-m-d H:i:s'));
		
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]],PHPExcel_Cell_DataType::TYPE_STRING);
            }
        }
		
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
    +----------------------------------------------------------
     * Import Excel
     * Author:mpthink <46913825@qq.com>
    +----------------------------------------------------------
     * @param  $file   upload file $_FILES
    +----------------------------------------------------------
     * @return array   array("error","message")
    +----------------------------------------------------------
     */
    public function importExecl($file){
        if(!file_exists($file)){
            return array("error"=>0,'message'=>'file not found!');
        }
        
		$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		if ($extension =='xlsx') {
			$objReader = new PHPExcel_Reader_Excel2007();
		} else if ($extension =='xls') {
			$objReader = new PHPExcel_Reader_Excel5();
		}else{
			var_dump("导入失败，不支持的文件");
			die;
		}
		
        try{
            $PHPReader = $objReader->load($file);
        }catch(Exception $e){}
        if(!isset($PHPReader)) return array("error"=>0,'message'=>'read error!');
        $allWorksheets = $PHPReader->getAllSheets();
        $i = 0;
        foreach($allWorksheets as $objWorksheet){
            $sheetname=$objWorksheet->getTitle();
            $allRow = $objWorksheet->getHighestRow();//how many rows
            $highestColumn = $objWorksheet->getHighestColumn();//how many columns
            $allColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $array[$i]["Title"] = $sheetname;
            $array[$i]["Cols"] = $allColumn;
            $array[$i]["Rows"] = $allRow;
            $arr = array();
            $isMergeCell = array();
            foreach ($objWorksheet->getMergeCells() as $cells) {//merge cells
                foreach (PHPExcel_Cell::extractAllCellReferencesInRange($cells) as $cellReference) {
                    $isMergeCell[$cellReference] = true;
                }
            }
            for($currentRow = 1 ;$currentRow<=$allRow;$currentRow++){
                $row = array();
                for($currentColumn=0;$currentColumn<$allColumn;$currentColumn++){;
                    $cell =$objWorksheet->getCellByColumnAndRow($currentColumn, $currentRow);
                    $afCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn+1);
                    $bfCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn-1);
                    $col = PHPExcel_Cell::stringFromColumnIndex($currentColumn);
                    $address = $col.$currentRow;
                    $value = $objWorksheet->getCell($address)->getValue();
                    if(substr($value,0,1)=='='){
                        return array("error"=>0,'message'=>'can not use the formula!');
                        exit;
                    }
                    if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){
                        $cellstyleformat=$cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();
                        $formatcode=$cellstyleformat->getFormatCode();
                        if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)) {
                            $value=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));
                        }else{
                            $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatcode);
                        }
                    }
                    if($isMergeCell[$col.$currentRow]&&$isMergeCell[$afCol.$currentRow]&&!empty($value)){
                        $temp = $value;
                    }elseif($isMergeCell[$col.$currentRow]&&$isMergeCell[$col.($currentRow-1)]&&empty($value)){
                        $value=$arr[$currentRow-1][$currentColumn];
                    }elseif($isMergeCell[$col.$currentRow]&&$isMergeCell[$bfCol.$currentRow]&&empty($value)){
                        $value=$temp;
                    }
                    $row[$currentColumn] = $value;
                }
                $arr[$currentRow] = $row;
            }
            $array[$i]["Content"] = $arr;
            $i++;
        }
        spl_autoload_register(array('Think','autoload'));//must, resolve ThinkPHP and PHPExcel conflicts
        unset($objWorksheet);
        unset($PHPReader);
        unset($PHPExcel);
        unlink($file);
        return array("error"=>1,"data"=>$array);
    }
}
?>