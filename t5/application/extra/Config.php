<?php

namespace app\extra;

class Config{

      //将下划线命名转换为驼峰式命名
      function convertUnderline1($str, $ucfirst = true)
      {
          while (($pos = strpos($str, '_')) !== false)
              $str = substr($str, 0, $pos) . ucfirst(substr($str, $pos + 1));
  
          return $ucfirst ? ucfirst($str) : $str;
      }
}