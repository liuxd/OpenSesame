# 芝麻开门 #

## 描述 ##

我的帐号管理工具。可以录入、修改、删除帐号信息，可以搜索帐号信息。

## 需求 ##
### 1.WebServer ###
随意


### 2.PHP ###
* 版本：5.3+
* 扩展：zlib

## 安装 ##

* 第一步：部署代码

        cd $document_root
        git clone git@bitbucket.org:liuxd/open-sesame.git
        cd open-sesame/res/ini/
        cp web.ini.sample web.ini

* 第二步：修改配置
    
        设置数据文件路径，并确保其可写。确保[db]的两个文件路径可写。

## 技术 ##
* [PHP](http://php.net/)
* [Twitter Bootstrap](http://twitter.github.io/bootstrap/)
* [jQuery](http://jquery.com/)
* [keypress.js](http://dmauro.github.io/Keypress/)
* [Google Font API](http://www.google.com/fonts/)
