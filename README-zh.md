[Open Sesame](http://liuxd.github.io/OpenSesame)
============

## 概述
+ 两个文件：程序文件，数据文件。
+ 两个模式：网页模式，命令模式。
+ 数据安全：每个程序的秘钥都不同。即使数据文件被别人拷贝走，即使别人能够看到程序代码，也没用。

## 需求
+ PHP 5.4+
  + mbstring
  + mcrypt
  + zlib

## 安装

    git clone git@github.com:open-sesame/OpenSesame.git
    cp dev/config.ini.sample src/config.ini # 根据自己需求修改 src/config.ini
    cd open-sesame/dev
    php phar-packer.php --name=os --path=../src/
    nohup php -S 0.0.0.0:8000 os.phar > /dev/null &

可以访问<http://localhost:8000>了。

## 使用
本软件有两种模式：`服务器模式`、`命令行模式`

+ __服务器模式__ - 一目了然不解释。
+ __命令行模式__ - 见VCR：

[![asciicast](https://asciinema.org/a/b0rkuneybbvfwjjptv8yj9aor.png)](https://asciinema.org/a/b0rkuneybbvfwjjptv8yj9aor)

## 开发

#### - 调试模式 -
+ 方法：在页面URL中增加参数：`debug`。
+ 功能：可以显示本页面会显示的数据以及对应的页面模板文件。
+ 例子：<http://localhost:8000?debug=1>

#### - 代码规范 -
+ 说明：本项目PHP代码完全遵循`PSR-1`、`PSR-2`规范。
+ 安装：在`dev/`目录下运行`composer.phar install`安装代码扫描工具。
+ 运行：`./code-sniffer.sh`

#### - 辅助工具 -
+ 创建新的命令程序：`php index.php createCmd {$command_name}`
+ 创建新的控制器：`php index.php createController {$controller_name}`

#### - 打包发布 -
+ 需求：将`php.ini`的`phar.readonly`设置为`Off`。
+ 打包：运行`dev/phar-packer.php`。
+ 举例：`./phar-packer.php --name=opensesame --path=../src`

#### - 发新版本 -
+ 工具：`dev/release.sh`
+ 举例：`./release.sh v5.0.1`
