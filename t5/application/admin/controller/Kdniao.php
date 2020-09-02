<?php

namespace app\admin\controller;

use PHPExcel;
use think\Controller;
use app\common\controller\Backend;

use PHPExcel_IOFactory;


class Kdniao extends Backend
{
   public function index()
   {

      return $this->fetch();
      # code...
   }

   public function demo()
   {
      $data = $this->readExcel($_FILES['file']);
      halt($data);
      /* include_once(EXTEND_PATH . 'PHPExcel/Classes/PHPExcel/IOFactory.php'); //静态类
      $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

      $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']); //$file_url即Excel文件的路径

      // $obj = $objRead->load($_FILES['file'], $encode = 'utf-8'); //$file 为解读的excel文件
      $sheet = $objPHPExcel->getSheet(0); //获取第一个工作表
      $rowCnt = $sheet->getHighestRow(); //取得总行数
      $columnH = $sheet->getHighestColumn();   //取得最大的列号  
      $columnCnt = array_search($columnH, $cellName);
      $cols = $sheet->getHighestColumn(); //取得总列数

      $data = [];
      for ($_row = 1; $_row <= $rowCnt; $_row++) {  //读取内容  
         for ($_column = 0; $_column <= $columnCnt; $_column++) {
            $cellId = $cellName[$_column] . $_row;
            $cellValue = $sheet->getCell($cellId)->getValue();
            if ($cellValue instanceof \PHPExcel_RichText) {   //富文本转换字符串  
               $cellValue = $cellValue->__toString();
            }
            $data[$_row][$cellName[$_column]] = $cellValue;
         }
      }

      dump($data);*/
   }



   # code...



   public function readExcel($data)
   {
      include_once(EXTEND_PATH . 'PHPExcel/Classes/PHPExcel/IOFactory.php'); //静态类
      $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
      $objPHPExcel = PHPExcel_IOFactory::load($data['tmp_name']); //$file_url即Excel文件的路径
      $sheet = $objPHPExcel->getSheet(0); //获取第一个工作表
      $rowCnt = $sheet->getHighestRow(); //取得总行数
      $columnH = $sheet->getHighestColumn();   //取得最大的列号  
      $columnCnt = array_search($columnH, $cellName);
      $cols = $sheet->getHighestColumn(); //取得总列数

      $data = [];
      for ($_row = 1; $_row <= $rowCnt; $_row++) {  //读取内容  
         for ($_column = 0; $_column <= $columnCnt; $_column++) {
            $cellId = $cellName[$_column] . $_row;
            $cellValue = $sheet->getCell($cellId)->getValue();
            if ($cellValue instanceof \PHPExcel_RichText) {   //富文本转换字符串  
               $cellValue = $cellValue->__toString();
            }
            $data[$_row][$cellName[$_column]] = $cellValue;
         }
      }
      return $data;
   }
}
