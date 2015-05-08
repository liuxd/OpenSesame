Open Sesame
============

> 使用`PHP`和`SQLite`开发的帐号管理工具。用PHP的内置服务器就可启动。

## 需求
+ PHP5.4+
	+ mbstring
    + zlib

## 安装

```
git clone git@github.com:open-sesame/open-sesame.git
# 根据自己需求修改config.ini，并放到src下。

cd open-sesame/dev
php phar-packer.php --name=os --path=../src/ --init=index.php
nohup php -S 0.0.0.0:8000 os.phar > /dev/null &
```

可以访问`localhost:8000`了。