<?php

namespace app\admin\controller;

use think\Controller;

use app\common\controller\Backend;
use app\common\model\Admin;
use think\Db;
use think\Config;
use think\Request;
use Exception;

class Index extends Backend

{
    public function _initialize()
    {
        $this->inser();
    }

    public function index()
    {


        $this->assign('admin', json_encode($this->request->module()));
        return $this->fetch();
    }


    public function makemodel()
    {

        if (Request::instance()->isAjax()) {

            try {

                $data = input('post.row/a');

                if (empty($data['model_name'])) {
                    throw new \Exception("生成名称不得为空");
                }


                $url = APP_PATH . 'common/model';
                if (!is_dir($url)) {
                    $res = mkdir($url, 0777, true);
                    if (!$res) {
                        throw new \Exception("目录创建失败");
                    }
                };

                $url = APP_PATH . 'common/model/' . $data['model_name'] . '.php';

                if (file_exists($url)) {
                    throw new \Exception("模型已存在");
                }


                $myfile = fopen($url, "w+");
                $txt = $this->getModel($data);
                $result =  fwrite($myfile, $txt);

                if (!$result) {
                    throw new \Exception("生成错误");
                }
                fclose($myfile);


                if (!empty($data['optionsRadios']) && $data['optionsRadios'] == 1) {

                    $url =  APP_PATH . 'admin/controller/' . $data['model_name'] . '.php';

                    $myfile = fopen($url, "w+");

                    $txt = $this->getController($data);

                    $result =  fwrite($myfile, $txt);

                    if (!$result) {
                        throw new \Exception("生成错误");
                    }
                    fclose($myfile);
                }
            } catch (Exception $e) {

                $this->error($e->getMessage());
            }

            return  $this->success('生成成功');
        }
        // halt(APP_PATH.'../public/static');

        $result = Db::query('show tables');

        $select = array_column($result, 'Tables_in_' . Config::get('database.database'));

        $arr = $select;
        $d = Config::get('database.prefix');
        // halt($d);

        array_walk($select, function (&$val) use ($d) {
            $val = ucfirst(str_replace($d, "", $val));
            $val = $this->convertUnderline1($val);
        });



        $NewSelect = array_combine($select, $arr);

        $this->assign('new_select', $NewSelect);
        return $this->fetch();
        # code...
    }

    //将下划线命名转换为驼峰式命名
    function convertUnderline1($str, $ucfirst = true)
    {
        while (($pos = strpos($str, '_')) !== false)
            $str = substr($str, 0, $pos) . ucfirst(substr($str, $pos + 1));

        return $ucfirst ? ucfirst($str) : $str;
    }

    public function getController($data)
    {
        $txt = "<?php\nnamespace app\admin\controller;\nuse think\Controller;\nuse app\common\controller\Backend;\nclass " . $data['model_name'] . " extends Backend{ \n   }";

        return $txt;
        # code...
    }

    public function getModel($data)
    {

        return
            $txt = "<?php\nnamespace app\common\model;\nuse think\Model;\nclass " . $data['model_name'] . " extends Model{ \n  protected \$table =  \"$data[db_name]\"  ;\n }            ";
        # code...
    }
}
