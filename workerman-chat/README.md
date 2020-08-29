workerman-chat
=======
基于workerman的GatewayWorker框架开发的一款高性能支持分布式部署的聊天室系统。

GatewayWorker框架文档：http://www.workerman.net/gatewaydoc/

 特性
======
 * 使用websocket协议
 * 多浏览器支持（浏览器支持html5或者flash任意一种即可）
 * 多房间支持
 * 私聊支持
 * 掉线自动重连
 * 微博图片自动解析
 * 聊天内容支持微博表情
 * 支持多服务器部署
 * 业务逻辑全部在一个文件中，快速入门可以参考这个文件[Applications/Chat/Event.php](https://github.com/walkor/workerman-chat/blob/master/Applications/Chat/Event.php)   
  
下载安装
=====
1、git clone https://github.com/2320142695/workerman-chat.git

2、composer install

启动停止(Linux系统)
=====
以debug方式启动  
```php start.php start  ```

以daemon方式启动  
```php start.php start -d ```

启动(windows系统)
======
双击start_for_win.bat  

注意：  
windows系统下无法使用 stop reload status 等命令  
如果无法打开页面请尝试关闭服务器防火墙  

可能会遇到的bug
=====
* 如果是宝塔面板会提示函数被禁用，根据提示报错信息关闭禁用的函数即可
* 安装php的event扩展提高系统响应能力 `pecl install event`
* 开启wss服务可以使用nginx进行代理，可以快速的启用wss服务  [创建wss服务](http://doc.workerman.net/faq/secure-websocket-server.html)
* 外部端口为 `65531` 可在  [./Applications/Chat/start_gateway.php](./Applications/Chat/start_gateway.php) 进行修改，修改后nginx代理的端口也需要变更

测试
=======
浏览器访问 http://服务器ip或域:65531,例如http://127.0.0.1:65531

 [更多请访问www.workerman.net](http://www.workerman.net/workerman-chat)
