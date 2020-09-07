<?php

namespace app\common\controller;

use think\Controller;
use think\Request;

class Backend extends Controller

{
    protected $row = [];


    public function _initialize()
    {
        $this->row = input('post.row/a');

        if (!empty($this->row)) {
            foreach ($this->row as $k => $v) {
                if (empty($v)) {
                    unset($this->row[$k]);
                }
            }
        }



        # code...
    }
    public function inser()
    {

        exec("D:\phpstudy\phpstudy_pro\Extensions\php\php7.3.4nts\php.exe think  make:model " . $this->request->module() . "/" .  $this->request->controller());
        # code...
    }
}
