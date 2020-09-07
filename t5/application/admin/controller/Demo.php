<?php

namespace app\admin\controller;

use think\Controller;

use app\common\controller\Backend;
use app\common\model\Admin;
use think\Db;
use think\Config;
use think\Request;
use Exception;

require  EXTEND_PATH . "Form.php";

class Demo extends Backend

{



    public function index()
    {
        if (Request::instance()->isAjax()){
                return $this->row;
        }



        return $this->fetch();
        # code...
    }

    public function select()
    {

        $list = [['id' => 1, 'name' => '芝加哥公牛', 'desc' => 1], ['id' => 2, 'name' => '克里夫兰', 'desc' => 2], ['id' => 3, 'name' => '底特律活塞', 'desc' => 3]];

        return   $list;

        # code...
    }

    public function upload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            // 成功上传后 获取上传信息
            // 输出 jpg
            //    echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getFilename(); 
            $this->success($info->getSaveName(), '', ['url' => $info->getSaveName()]);
        } else {
            // 上传失败获取错误信息
            $this->error('图片上传失败', '', ['info' => $file->getError()]);
            // echo $file->getError();
        }
    }
}
