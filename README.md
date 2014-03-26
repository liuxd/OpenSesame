Open Sesame
============
[![Build Status](https://drone.io/github.com/liuxd/open-sesame/status.png)](https://drone.io/github.com/liuxd/open-sesame/latest)
[![wercker status](https://app.wercker.com/status/e235d5b6a0dc8cfaf7199fe18a074ded/s/ "wercker status")](https://app.wercker.com/project/bykey/e235d5b6a0dc8cfaf7199fe18a074ded)

## 环境需求
+ nginx
+ php-fpm

## 安装步骤
#### 1. 下载程序包
到[下载地址](https://github.com/liuxd/open-sesame/releases)下载最新版本的`open-sesame.phar`，放到你的路径($path)。

#### 2. 配置文件
拷贝[配置模板](https://raw.github.com/liuxd/open-sesame/master/dev/config.ini.sample)到`open-sesame.phar`相同目录下并取名`config.ini`。根据需求修改配置项。

#### 3. 修改hosts
添加`127.0.0.1 www.open-sesame.com`

#### 4. 运行环境
+ 拷贝[open-sesame.conf](https://raw.github.com/liuxd/open-sesame/master/dev/open-sesame.conf)到nginx配置文件包含的路径。
+ 将里面的`root`变量的值修改为`open-sesame.phar`所在的路径。

#### 5. 启动
+ 启动nginx & php-fpm
+ 浏览器里访问<http://www.open-sesame.com>
