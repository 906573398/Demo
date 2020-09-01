<?php


p($_FILES);

/*
 *print_r 数据数组
*/
function p($data)

{
    if ($_FILES["file"]["error"] > 0) {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    } else {
       
        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/index' . date("Ymd", time());
        $name = $_FILES["file"]["name"];
        $type = strtolower(substr($name, strrpos($name, '.') + 1)); //得到文件类型，并且都转化成小写

        if (!is_dir($path)) { //判断目录是否存在 不存在就创建
            $data =  mkdir($path, 0777, true);
            var_dump($data);
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $imgurl = $path . '/' . rand(0000, 9999) . uniqid() . time() . '.' . $type)) {
        
         
            $url = explode('/public',$imgurl);
            $result["code"] = '0';
            $result["msg"] = "上传成功";
            $result['data']["src"] = $url[1];
            $result['data']["src_1"] = $url[1];
            
        } else {
    
            $result["code"] = '2';
            $result["msg"] = '文件移动失败';
         
        }
        return  json_encode($result);
    }
}
