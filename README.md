Open Sesame
============
[![Build Status](https://drone.io/github.com/liuxd/open-sesame/status.png)](https://drone.io/github.com/liuxd/open-sesame/latest)
[![wercker status](https://app.wercker.com/status/e235d5b6a0dc8cfaf7199fe18a074ded/m/ "wercker status")](https://app.wercker.com/project/bykey/e235d5b6a0dc8cfaf7199fe18a074ded)

基于Web的帐号管理工具。

## 环境需求
+ Nginx
+ PHP
    + 版本：5.4.17+
    + 扩展：zlib

## 安装步骤
1. wget https://github.com/liuxd/open-sesame/archive/v1.0.0.tar.gz
1. tar zxvf v1.0.0.tar.gz
1. cd open-sesame-1.0.0
1. cp src/config/web.ini.sample /tmp/web.ini
1. ./dev/release.sh
1. 修改`/etc/hosts`，添加`127.0.0.1 www.open-sesame.com`。
1. 根据自己的需求修改`/tmp/web.ini`的配置。
1. 拷贝`dev/open-sesame.conf`到nginx包含的配置目录下(include /path/*.conf 语句指定的路径)。
1. 修改open-sesame.conf里的`root`为`open-sesame-1.0.0/dev`的绝对路径。
1. 启动nginx & php-fpm
1. 浏览器里访问<http://www.open-sesame.com>
