Open Seseame
============

<img src="www/img/web.png" />

##简介
+ __基于Web__的密码管理系统。
+ __独特的身份验证__，让暴力破解无效。
+ __原创的DB封装__，完全屏蔽SQL注入u。

##需求
+ LNMP环境
+ PHP要求
    + 版本：5.3+
    + 扩展：zlib

##安装

###下载
```
cd $document_root
git clone git@github.com:liuxd/open-sesame.git
```

###配置
```
cd open-sesame/ini/
cp web.ini.sample web.ini
```
配置web.ini中的[db]栏，确保路径可写。

##技术
* [PHP](http://php.net/)
* [Twitter Bootstrap](http://twitter.github.io/bootstrap/)
* [jQuery](http://jquery.com/)
* [keypress.js](http://dmauro.github.io/Keypress/)
* [Google Font API](http://www.google.com/fonts/)
* [Gravatar](http://cn.gravatar.com/)
