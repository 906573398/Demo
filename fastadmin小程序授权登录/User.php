<?php

namespace app\api\controller;

use Miniapp;
use think\Db;
use think\Hook;
use fast\Random;
use think\Validate;
use app\common\library\Ems;
use app\common\library\Sms;
use app\common\controller\Api;
use app\api\controller\Wechat;
use app\common\model\User as UserModel;
use app\admin\model\Admin;

/**
 * 会员接口
 */
class User extends Api
{
    protected $noNeedLogin = ['login', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third', 'mini_app_auth'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }

    /**
     * 原会员登录
     *
     * @param string $account  账号
     * @param string $password 密码
     */
    // public function login()
    // {
    //     $account = $this->request->request('account');
    //     $password = $this->request->request('password');
    //     if (!$account || !$password) {
    //         $this->error(__('Invalid parameters'));
    //     }
    //     $ret = $this->auth->login($account, $password);
    //     if ($ret) {
    //         $data = ['userinfo' => $this->auth->getUserinfo()];
    //         $this->success(__('Logged in successful'), $data);
    //     } else {
    //         $this->error($this->auth->getError());
    //     }
    // }
    /**
     * 小程序会员登录/注册
     *
     * @param string $code  code
     * @param string $user_info user_info
     * @param string $encrypted_data encrypted_data
     * @param string $iv iv
     * @param string $signature 签名
     */
    // public function login()
    // {
    //     // $account = $this->request->request('account');
    //     // $password = $this->request->request('password');
    //     // if (!$account || !$password) {
    //     //     $this->error(__('Invalid parameters'));
    //     // }
    //     $code = $this->request->request('code');
    //     $rawData = $this->request->request('rawData');
    //     $encryptedData = $this->request->request('encryptedData');
    //     $iv = $this->request->request('iv');
    //     $signature = $this->request->request('signature');
    //     if(!$code || !$rawData or !$encryptedData){
    //         $this->error('缺少参数!','',1);
    //     }
    //     if(!$iv || !$signature){
    //         $this->error('缺少参数!','',1);
    //     }
    //     $wechat = new Wechat();
    //     $res = json_decode($wechat->xcxlogin($code,$rawData,$encryptedData,$iv,$signature),true);
    //     if(!$res){
    //         $this->error('登录失败!');
    //     }
    //     if($res['code'] == 200 && $res['msg'] == 'ok'){
    //         $openid = isset($res['openId']) ? $res['openId'] : '';
    //         if(empty($openid)){
    //             $this->error('OPENID NULL');
    //         }
    //         if(!$wechat->is_openid($openid)){
    //             //注册
    //             $register = $this->auth->register($res,$openid);
    //             if(!$register){
    //                 $this->error('Register Fail');
    //             }
    //         }
    //         if ($ret) {
    //             $data = ['userinfo' => $this->auth->getUserinfo()];
    //             $this->success(__('Logged in successful'), $data);
    //         } else {
    //             $this->error($this->auth->getError());
    //         }
    //     }else{
    //         $this->error($res['msg']);
    //     }

    // }

    /**
     * 手机验证码登录
     *
     * @param string $mobile  手机号
     * @param string $captcha 验证码
     */
    // public function mobilelogin()
    // {
    //     $mobile = $this->request->request('mobile');
    //     $captcha = $this->request->request('captcha');
    //     if (!$mobile || !$captcha) {
    //         $this->error(__('Invalid parameters'));
    //     }
    //     if (!Validate::regex($mobile, "^1\d{10}$")) {
    //         $this->error(__('Mobile is incorrect'));
    //     }
    //     if (!Sms::check($mobile, $captcha, 'mobilelogin')) {
    //         $this->error(__('Captcha is incorrect'));
    //     }
    //     $user = \app\common\model\User::getByMobile($mobile);
    //     if ($user) {
    //         if ($user->status != 'normal') {
    //             $this->error(__('Account is locked'));
    //         }
    //         //如果已经有账号则直接登录
    //         $ret = $this->auth->direct($user->id);
    //     } else {
    //         $ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
    //     }
    //     if ($ret) {
    //         Sms::flush($mobile, 'mobilelogin');
    //         $data = ['userinfo' => $this->auth->getUserinfo()];
    //         $this->success(__('Logged in successful'), $data);
    //     } else {
    //         $this->error($this->auth->getError());
    //     }
    // }

    /**
     * 注册会员
     *
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email    邮箱
     * @param string $mobile   手机号
     * @param string $code   验证码
     */
    // public function register()
    // {
    //     $username = $this->request->request('username');
    //     $password = $this->request->request('password');
    //     $email = $this->request->request('email');
    //     $mobile = $this->request->request('mobile');
    //     $code = $this->request->request('code');
    //     if (!$username || !$password) {
    //         $this->error(__('Invalid parameters'));
    //     }
    //     if ($email && !Validate::is($email, "email")) {
    //         $this->error(__('Email is incorrect'));
    //     }
    //     if ($mobile && !Validate::regex($mobile, "^1\d{10}$")) {
    //         $this->error(__('Mobile is incorrect'));
    //     }
    //     $ret = Sms::check($mobile, $code, 'register');
    //     if (!$ret) {
    //         $this->error(__('Captcha is incorrect'));
    //     }
    //     $ret = $this->auth->register($username, $password, $email, $mobile, []);
    //     if ($ret) {
    //         $data = ['userinfo' => $this->auth->getUserinfo()];
    //         $this->success(__('Sign up successful'), $data);
    //     } else {
    //         $this->error($this->auth->getError());
    //     }
    // }

    /**
     * 注销登录
     */
    public function logout()
    {
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }

    /**
     * 修改会员个人信息
     *
     * @param string $avatar   头像地址//不用
     * @param string $username 用户名//不用
     * @param string $region 区域
     * @param string $address 地址
     * @param string $nickname 昵称
     * @param string $bio      个人简介
     */
    public function profile()
    {
        $user = $this->auth->getUser();
        //$username = $this->request->request('username');
        $region = $this->request->request('region'); //区域
        $address = $this->request->request('address'); //详细地址
        $nickname = $this->request->request('nickname');
        $bio = $this->request->request('bio');
        //$avatar = $this->request->request('avatar', '', 'trim,strip_tags,htmlspecialchars');
        // if ($nickname) {
        //     $exists = \app\common\model\User::where('id', '<>', $this->auth->id)->find();//where('username', $username)
        //     if ($exists) {
        //         $this->error(__('Username already exists'));
        //     }
        //$user->username = $username;
        //}
        $user->nickname = $nickname;
        $user->region = $region;
        $user->address = $address;
        $user->bio = $bio;
        //$user->avatar = $avatar;
        $user->save();
        $this->success();
    }
    /**
     * 查看个人信息
     */
    public function userInfo()
    {
        $uinfo = $this->auth->getUserinfo();
        // halt($uinfo);


        $uinfo['works'] = Db::table('fa_user_work')->alias('u')
            ->join('fa_role_work k', 'u.work_id=k.id')
            ->where('u.mobile', $uinfo['mobile'])
            ->field('k.name')
            ->select();
        $this->success('ok', $uinfo);
    }

    /**
     * 修改邮箱
     *
     * @param string $email   邮箱
     * @param string $captcha 验证码
     */
    // public function changeemail()
    // {
    //     $user = $this->auth->getUser();
    //     $email = $this->request->post('email');
    //     $captcha = $this->request->request('captcha');
    //     if (!$email || !$captcha) {
    //         $this->error(__('Invalid parameters'));
    //     }
    //     if (!Validate::is($email, "email")) {
    //         $this->error(__('Email is incorrect'));
    //     }
    //     if (\app\common\model\User::where('email', $email)->where('id', '<>', $user->id)->find()) {
    //         $this->error(__('Email already exists'));
    //     }
    //     $result = Ems::check($email, $captcha, 'changeemail');
    //     if (!$result) {
    //         $this->error(__('Captcha is incorrect'));
    //     }
    //     $verification = $user->verification;
    //     $verification->email = 1;
    //     $user->verification = $verification;
    //     $user->email = $email;
    //     $user->save();

    //     Ems::flush($email, 'changeemail');
    //     $this->success();
    // }

    /**
     * 修改手机号
     *
     * @param string $mobile   手机号
     * @param string $captcha 验证码
     */
    public function changemobile($type = 1)
    {
        $user = $this->auth->getUser();
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');
        if (!$mobile || !$captcha) {
            $this->error(__('手机号或验证码不能为空'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$")) {
            $this->error('手机号格式不正确');
        }
        if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find()) {
            $this->error('手机号已被其他用户绑定');
        }

        // $mobile1 =  \app\common\model\Admin::where('username', $mobile)->find();

        // if (!$mobile1) {
        //     $this->error('请先找管理员录入手机号');
        // }
      
        $result = Sms::check($mobile, $captcha, 'moblesms'); //changemobile
        $result = true;
        // halt($result);
        if (!$result) {
            $this->error(__('验证码不正确'));
        }

        //验证码通过后

        $is_distributor = Admin::where(['status' => 'normal', 'username' => $mobile])->find();
        
         if ($is_distributor) {
            $rrr = db('auth_group_access')->where(['uid'=>$is_distributor->id])->find();

            if($rrr){
           

                $user->group_id = $rrr['group_id'];
            }

           
        } 
        $verification = $user->verification;
        $verification->mobile = 1;
        $user->verification = $verification;
        $user->mobile = $mobile;
        $user->save();
        Sms::flush($mobile, 'changemobile');
        $this->success();
    }

    /**
     * 第三方登录
     *
     * @param string $platform 平台名称
     * @param string $code     Code码
     */
    // public function third()
    // {
    //     $url = url('user/index');
    //     $platform = $this->request->request("platform");
    //     $code = $this->request->request("code");
    //     $config = get_addon_config('third');
    //     if (!$config || !isset($config[$platform])) {
    //         $this->error(__('Invalid parameters'));
    //     }
    //     $app = new \addons\third\library\Application($config);
    //     //通过code换access_token和绑定会员
    //     $result = $app->{$platform}->getUserInfo(['code' => $code]);
    //     if ($result) {
    //         $loginret = \addons\third\library\Service::connect($platform, $result);
    //         if ($loginret) {
    //             $data = [
    //                 'userinfo'  => $this->auth->getUserinfo(),
    //                 'thirdinfo' => $result
    //             ];
    //             $this->success(__('Logged in successful'), $data);
    //         }
    //     }
    //     $this->error(__('Operation failed'), $url);
    // }

    /**
     * 重置密码
     *
     * @param string $mobile      手机号
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     */
    // public function resetpwd()
    // {
    //     $type = $this->request->request("type");
    //     $mobile = $this->request->request("mobile");
    //     $email = $this->request->request("email");
    //     $newpassword = $this->request->request("newpassword");
    //     $captcha = $this->request->request("captcha");
    //     if (!$newpassword || !$captcha) {
    //         $this->error(__('Invalid parameters'));
    //     }
    //     if ($type == 'mobile') {
    //         if (!Validate::regex($mobile, "^1\d{10}$")) {
    //             $this->error(__('Mobile is incorrect'));
    //         }
    //         $user = \app\common\model\User::getByMobile($mobile);
    //         if (!$user) {
    //             $this->error(__('User not found'));
    //         }
    //         $ret = Sms::check($mobile, $captcha, 'resetpwd');
    //         if (!$ret) {
    //             $this->error(__('Captcha is incorrect'));
    //         }
    //         Sms::flush($mobile, 'resetpwd');
    //     } else {
    //         if (!Validate::is($email, "email")) {
    //             $this->error(__('Email is incorrect'));
    //         }
    //         $user = \app\common\model\User::getByEmail($email);
    //         if (!$user) {
    //             $this->error(__('User not found'));
    //         }
    //         $ret = Ems::check($email, $captcha, 'resetpwd');
    //         if (!$ret) {
    //             $this->error(__('Captcha is incorrect'));
    //         }
    //         Ems::flush($email, 'resetpwd');
    //     }
    //     //模拟一次登录
    //     $this->auth->direct($user->id);
    //     $ret = $this->auth->changepwd($newpassword, '', true);
    //     if ($ret) {
    //         $this->success(__('Reset password successful'));
    //     } else {
    //         $this->error($this->auth->getError());
    //     }
    // }


    /**
     * 微信小程序授权
     */
    public function mini_app_auth()
    {
        $code = $this->request->request('code', '');
        $encryptedData = $this->request->request('data', '');
        $iv = $this->request->request('iv', '');
        $auth = \app\common\library\Auth::instance();
        // $parent_id = $this->request->request('parent_id/d', 0);

        try {
            Db::startTrans();
            $userdata = Miniapp::getUserInfo($code, $encryptedData, $iv);
            // halt($userdata);
            //dump($userdata);exit;
            $user = UserModel::getByOpenid($userdata['openId']);
            if (!$user) {
                $extend = [
                    'openid' => $userdata['openId'],
                    'gender' => $userdata['gender'],
                    'nickname' => $userdata['nickName'],
                    'avatar' => $userdata['avatarUrl'],
                    // 'parent_id' => $parent_id
                ];
                $password = Random::alnum(6);
                $domain   = request()->host();
                $result = $auth->register($userdata['openId'], $password, '', '', $extend);
                if (!$result) {
                    throw new \Exception('登录失败！');
                }
                $user = $auth->getUser();

                Hook::listen('user_register_success', $user);
            }
            // $uu = UserModel::get($user->id);
            // $uu->avatar = $userdata['avatarUrl'];
            // $uu->save();
            $auth->direct($user->id);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $auth->logout();
            return $this->error($e->getMessage());
        }
        return $this->success('登陆成功', $auth->getUserinfo());
    }
}
