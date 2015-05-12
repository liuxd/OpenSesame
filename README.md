Open Sesame
============

> 使用`PHP`和`SQLite`开发的帐号管理工具。用PHP的内置服务器就可启动。

## 需求
+ PHP5.4+
	+ mbstring
    + zlib

## 安装

    git clone git@github.com:open-sesame/open-sesame.git
    cp dev/config.ini.sample src/config.ini # 根据自己需求修改 src/config.ini
    cd open-sesame/dev
    php phar-packer.php --name=os --path=../src/
    nohup php -S 0.0.0.0:8000 os.phar > /dev/null &

可以访问`localhost:8000`了。

## 开发

#### 调试模式
+ 方法：在页面URL中增加参数：`debug`。随便设定一个非空值即可进入调试模式。
+ 功能：可以显示本页面会显示的数据以及对应的页面模板文件。
+ 例子：<http://localhost:8000?debug=1>
