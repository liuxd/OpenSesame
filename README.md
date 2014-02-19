Open Sesame
============
[![Build Status](https://drone.io/github.com/liuxd/open-sesame/status.png)](https://drone.io/github.com/liuxd/open-sesame/latest)
[![wercker status](https://app.wercker.com/status/e235d5b6a0dc8cfaf7199fe18a074ded/s/ "wercker status")](https://app.wercker.com/project/bykey/e235d5b6a0dc8cfaf7199fe18a074ded)

基于Web的帐号管理工具。

## 环境需求
+ Nginx
+ PHP
    + 版本：5.4.17+
    + 扩展：zlib
    + 模式：php-fpm

## 安装步骤
#### 0. 运行环境
nginx + php-fpm

#### 1. 下载程序包
到<https://github.com/liuxd/open-sesame/releases>，下载最新版本的`open-sesame.phar`，放到你的路径($path)。

#### 2. 配置文件
配置模板：<https://raw.github.com/liuxd/open-sesame/master/src/config/web.ini.sample>，拷贝出来放到open-sesame.phar文件相同路径。取名`web.ini`。根据需求修改配置项。

#### 3. 修改hosts
添加`127.0.0.1 www.open-sesame.com`

#### 4. 运行环境
+ nginx + php-fpm
+ 拷贝<https://raw.github.com/liuxd/open-sesame/master/dev/open-sesame.conf>到nginx配置文件包含的路径。 记得将里面的`root`修改为`open-sesame.phar`所在的路径。

#### 5. 启动
+ 启动nginx & php-fpm
+ 浏览器里访问<http://www.open-sesame.com>
