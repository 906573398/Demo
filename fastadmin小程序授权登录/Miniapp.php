<?php

use think\Request;
use think\Config;
class Miniapp
{
    //const MINIAPP_ID = '';
    //const APP_SECRET = '';
    public static $MINIAPP_ID;
    public static $APP_SECRET;
    /**
     * 登录凭证校验。通过 wx.login 接口获得临时登录凭证 code 后传到开发者服务器调用此接口完成登录流程。更多使用方法详见 小程序登录。
     */
    const AUTH_CODE2SESSION = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';

    /**
     * 获取access_tokenuri
     */
    const ACCESS_TOKEN_URI = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';

    /**
     * 获取数量较多的小程序码uri 适用于需要的码数量极多的业务场景
     */
    const UNLIMIT_URI = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=%s';

    public function _initialize()
    {
        self::$MINIAPP_ID = Config::get('site.appid');
        self::$APP_SECRET = Config::get('site.app_secret');
    }
    
    /**
     * 获取SessionKey
     * @param string $code 微信小程序code
     * @return array
     * @throws Exception
     */
    public static function getSessionKey($code = '')
    {
        if (empty($code)) {
            throw new \Exception('code不合法');
        }
        self::$MINIAPP_ID = Config::get('site.appid');
        self::$APP_SECRET = Config::get('site.app_secret');

        $result = \fast\Http::get(sprintf(self::AUTH_CODE2SESSION, self::$MINIAPP_ID, self::$APP_SECRET, $code));
        $jscode2session = json_decode($result, true);

        if (isset($jscode2session['errcode']) && $jscode2session['errcode'] != 0) {
            halt($jscode2session);
            throw new \Exception('服务器错误，请重试！');
            // throw new \Exception($jscode2session['errcode'].' : '.$jscode2session['errmsg']);
        }
        return $jscode2session;
    }

    /**
     * 获取access_token
     */
    public static function getAccessToken()
    {
        $access_token = \think\Cache::get('access_token');
        if (!$access_token) {
            $appid = self::$MINIAPP_ID;
            $secret = self::$APP_SECRET;
            $token = json_decode(\fast\Http::get(sprintf(self::ACCESS_TOKEN_URI, $appid, $secret)), true);
            $access_token = $token['access_token'];
            \think\Cache::set('access_token', $access_token, 7100);
        }
        return $access_token;
    }

    /**
     * 获取小程序码
     * @link https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.getUnlimited.html
     * @param array $data 微信生成小程序码需要的参数
     * @return string|boole
     */
    public static function getUnlimited($data = [])
    {
        if (empty($data)) {
            return false;
        }
        $token = self::getAccessToken();
        $data = \fast\Http::post(sprintf(self::UNLIMIT_URI, $token), json_encode($data));
        $result = json_decode($data, true);
        if (isset($result['errcode'])) {
            return false;
        }
        return $data;
    }

    /**
     * 获取用户信息
     * @throws \Exception
     */
    public static function getUserInfo($code = '', $encryptedData = '', $iv = '')
    {
        if (empty($code)) {
            throw new \Exception('参数错误');
        }
    
        $jscode2session = self::getSessionKey($code);
        // halt($jscode2session);
        $encryptedData =  $encryptedData ?: Request::instance()->request('data');
        $iv = $iv ?: Request::instance()->request('iv');

        $pc = new WXBizDataCrypt(self::$MINIAPP_ID, $jscode2session['session_key']);
     
        $data = null;
        $errCode = $pc->decryptData($encryptedData, $iv, $data);
        if ($errCode != 0) {
            throw new \Exception($errCode);
        }
        return json_decode($data, true);
    }

    /**
     * 检测图片是否合法
     * @param string image_url 图片路径
     * @return bool
     * @throws Exception
     */
    public static function imgSecCheck($image_url)
    {
        if (empty($image_url)) {
            throw new \Exception('图片文件为空！');
        }
        $token = self::getAccessToken();
        $post_data = [
            'media' => $image_url
        ];
        $data = \fast\Http::post('https://api.weixin.qq.com/wxa/img_sec_check?access_token=' . $token, json_encode($post_data, JSON_UNESCAPED_UNICODE));
        $result = json_decode($data, true);
        if ($result['errcode'] != 0) {
            throw new \Exception('存在违法词汇，请重新输入');
        }
        return true;
    }

    /**
     * 异步校验图片/音频是否含有违法违规内容。
     */
    public static function mediaCheckAsync($file, $media_type = 1)
    {
        if (empty($file)) {
            throw new \Exception('资源不存在');
        }
        $token = self::getAccessToken();
        $post_data = [
            'media_url' => $file,
            'media_type' => $media_type
        ];
        $data = \fast\Http::post('https://api.weixin.qq.com/wxa/media_check_async?access_token=' . $token, json_encode($post_data, JSON_UNESCAPED_UNICODE));
        $result = json_decode($data, true);
        if ($result['errcode'] != 0) {
            throw new \Exception('存在违法词汇，请重新输入');
        }
        return true;
    }

    /**
     * 检查一段文本是否含有违法违规内容。
     * @throws \Exception
     */
    public static function msgSecCheck($content)
    {
        if (empty($content)) {
            throw new \Exception('内容为空！');
        }
        $token = self::getAccessToken();
        $post_data = [
            'content' => $content
        ];
        $url = 'https://api.weixin.qq.com/wxa/msg_sec_check?access_token=' . $token;
        $data = \fast\Http::post($url, json_encode($post_data, JSON_UNESCAPED_UNICODE));
        $result = json_decode($data, true);
        if ($result['errcode'] != 0) {
            throw new \Exception('存在违法词汇，请重新输入');
        }
        return true;
    }
}
