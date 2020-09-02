<?php
namespace app\common\controller;
use think\Controller;
use think\Request;
class Backend extends Controller

{
    public function _initialize()
    {
        // $this->request = Request::instance();
        // $this->request->module();
        // $this->request->controller();
        // var_dump( $this->request->module(), $this->request->controller());exit;
    
        // $this->data =1;
    //   $this->data = 
    //    exec("D:\phpstudy\phpstudy_pro\Extensions\php\php7.3.4nts\php.exe think  make:model ".$this->request->module()."/".  $this->request->controller());
      
        # code...
    }
    public function inser()
    {
       
        exec("D:\phpstudy\phpstudy_pro\Extensions\php\php7.3.4nts\php.exe think  make:model ".$this->request->module()."/".  $this->request->controller());
        # code...
    }

   

}