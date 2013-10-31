Open Sesame
============

基于Web的帐号管理工具。

##需求
+ Nginx + PHP
+ PHP要求
    + 版本：5.3+
    + 扩展：zlib

##安装
```
cd $document_root
git clone git@github.com:liuxd/open-sesame.git
cd open-sesame/ini/
cp web.ini.sample web.ini
```
配置web.ini中的[db]栏，确保路径可写。
