Open Sesame
============
[![Build Status](https://drone.io/github.com/liuxd/open-sesame/status.png)](https://drone.io/github.com/liuxd/open-sesame/latest)

## 功能
基于Web的帐号管理工具。

## 背景
2011年12月，CSDN泄露600多万用户信息，引爆一系列的用户信息泄露事件。

这个事件让我深深意识到 —— __多个帐号使用相同的密码太危险了！__

可是不同帐号都用不同密码的话又太难记了，这怎么办？

... ...

太傻了，劳资不是程序员吗？自己写个程序来管理密码不就得了！我咋这笨！

于是两个小时后，__本系统第一版诞生了！__

我立刻把我所有帐号密码都录入到这个系统里，并且用了不同的随机密码，这才安心去睡。

> 时光飞逝ING

这个小软件经过了一系列的折腾：

+ 从svn到git
+ 从bitbucket到github
+ 项目名称多次变更

#####最终落户github，并定名__Open Sesame__。

现在，我几乎每天都要打开这个系统来查看我的各种帐号信息。

__Open Sesame__是什么意思呢？翻译成中文是

> 芝麻开门

## 需求
+ Nginx
+ PHP
    + 版本：5.4.17+
    + 扩展：zlib

## 部署
+ 下载 && 解压。
+ 修改`dev/release.sh`的前三个变量的值。
+ 拷贝`src/config/web.ini.sample`到release.sh里config_path指定的路径，命名`web.ini`。
+ 根据自己的需求修改web.ini的配置。
+ 拷贝`dev/open-sesame.conf`到nginx包含的配置目录下(include /path/*.conf 语句指定的路径)。
+ 修改open-sesame.conf里的路径。
+ 执行`dev/release.sh`
+ 修改`/etc/hosts`
+ 启动nginx & php-fpm