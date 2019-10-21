PHP-MVC-Frameworker +  Workerman/GatewayWorker



![Workerman/GatewayWorker](http://doc2.workerman.net/work-with-other-frameworks.html)


## 总体原则：

- 现有 MVC 框架项目与 GatewayWorker 独立部署、互不干扰；

- 现有的业务逻辑（登入、打开频道/发送信息等），都由网站页面 post/get 到 mvc 框架中完成；

- GatewayWorker 不接受客户端发来的数据，即 GatewayWorker 不处理任何业务逻辑，仅作为一个单向的推送通道；

- 仅当 mvc 框架需要向浏览器主动推送数据时，在 MVC 框架中调用 Gateway 的 API（GatewayClient）完成推送；


## ip 监听

- 0.0.0.0 代表监听本机所有网卡，就是内网、外网、本机都可以访问到；

- 127.0.0.1，代表只能本机通过 127.0.0.1 访问，外网和内网都访问不到；

- 内网 ip，例如：192.168.10.11，代表只能通过 192.168.10.11 访问，也就是只能内网访问。本机 127.0.0.1 也访问不了。

- 外网 ip，例如：110.110.141.110，代表只能通过外网 ip 110.110.141.110 访问，内网和本机 127.0.0.1 都访问不了。

- 如果监听的 ip 不属于本机，则会报错；


## port：

	端口不能大于 65535，确认端口没被其它程序占用，否则启动会报错。
	
	端口小于 1024，需要 root 权限运行 GatewayWorker，才能有权限监听，否则报错-没有权限。
	

































