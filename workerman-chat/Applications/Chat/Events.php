<?php

/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

/**
 * 聊天主逻辑
 * 主要是处理 onMessage onClose 
 */

use \GatewayWorker\Lib\Gateway;

class Events
{

    public static function onConnect($client_id)
    {
        $new_message = [
            'type' => 'connect',
            'msg' => 'success'
        ];
        Gateway::sendToCurrentClient(json_encode($new_message));
    }

    /**
     * 有消息时
     * @param int $client_id
     * @param mixed $message
     */
    public static function onMessage($client_id, $message)
    {
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:" . json_encode($_SESSION) . " onMessage:" . $message . "\n";

        // 客户端传递的是json数据
        $message_data = json_decode($message, true);
        if (!$message_data) {
            return;
        }

        // 根据类型执行不同的业务
        switch ($message_data['type']) {
                // 客户端回应服务端的心跳
            case 'pong':
                return;
                // 客户端登录 message格式: {type:login, client_name:xx,avatar:'.png', room_id:1} ，添加到客户端，广播给所有客户端xx进入聊天室
            case 'login':
                // 判断是否有房间号
                if (!isset($message_data['room_id'])) {
                    return self::error("\$message_data['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }

                // 把房间号昵称放到session中
                $room_id = $message_data['room_id'];
                $client_name = htmlspecialchars($message_data['client_name'] ?? '用户：' . mt_rand(10000, 99999));
                $_SESSION['room_id'] = $room_id;
                $_SESSION['client_name'] = $client_name;
                $_SESSION['avatar'] = $message_data['avatar'] ?? 'http://off.qianniangy.net/uploads/20200422/bf81be0f634912a927de87b2a4f416cf.png';

                // 转播给当前房间的所有客户端，xx进入聊天室 message {type:login, client_id:xx, name:xx} 
                $new_message = array('type' => 'join', 'client_name' => htmlspecialchars($client_name), 'avatar' => $_SESSION['avatar'], 'time' => date('Y-m-d H:i:s'));
                Gateway::sendToGroup($room_id, json_encode($new_message));
                Gateway::joinGroup($client_id, $room_id);

                return;

                // 客户端发言 message: {type:say, to_client_id:xx, content:xx}
            case 'say':
                // 非法请求
                if (!isset($_SESSION['room_id'])) {
                    return self::error("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']}");
                }
                $room_id = $_SESSION['room_id'];
                $client_name = $_SESSION['client_name'];
                $avatar = $_SESSION['avatar'];
                $new_message = array(
                    'type' => 'say',
                    // 'from_client_id'=>$client_id,
                    'from_client_name' => $client_name,
                    'avatar' => $avatar,
                    // 'to_client_id'=>'all',
                    'content' => nl2br(htmlspecialchars($message_data['content'])),
                    'time' => date('Y-m-d H:i:s'),
                );
                return Gateway::sendToGroup($room_id, json_encode($new_message));
        }
    }

    /**
     * 当客户端断开连接时
     * @param integer $client_id 客户端id
     */
    public static function onClose($client_id)
    {
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";

        // 从房间的客户端列表中删除
        if (isset($_SESSION['room_id'])) {
            $room_id = $_SESSION['room_id'];
            $new_message = array('type' => 'logout', 'avatar' => $_SESSION['avatar'], 'client_name' => $_SESSION['client_name'], 'time' => date('Y-m-d H:i:s'));
            Gateway::sendToGroup($room_id, json_encode($new_message));
        }
    }

    public static function error($msg = '')
    {
        $new_message = [
            'type' => 'error',
            'msg' => $msg
        ];
        return Gateway::closeCurrentClient(json_encode($new_message));
    }
}
