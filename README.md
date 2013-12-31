Open Sesame
============
[![Build Status](https://travis-ci.org/liuxd/open-sesame.png)](https://travis-ci.org/liuxd/open-sesame)
[![Build Status](https://drone.io/github.com/liuxd/open-sesame/status.png)](https://drone.io/github.com/liuxd/open-sesame/latest)

## 功能
基于Web的帐号管理工具。

## 背景
2011年12月，CSDN泄露600多万用户信息，引爆一系列的用户信息泄露事件。

这个事件让我深深意识到多个帐号使用相同的密码是多么不靠谱的一件事。于是，我在看了CSDN事件后的当天，下班后加班两个小时用我熟悉的PHP编写了一个基于Web的帐号管理工具，记录我众多的帐号信息，每个都用不同的随机密码。

经过一系列的折腾（svn到git，bitbucket到github，项目名称变更等等），最终落户[github](https://github.com/liuxd/open-sesame)，并命名__Open Sesame__，一直发展到今天。现在，我几乎每天都要打开这个系统来查看我的各种帐号信息。

__Open Sesame__，芝麻开门。意指这里的东西可以打开一扇扇门。如果说各个网站的用户验证是门的话，那这里的密码就是“芝麻开门”这个咒语，用来打开一扇扇门。

## 需求
+ Nginx
+ PHP
    + 版本：5.4.17+
    + 扩展：zlib
