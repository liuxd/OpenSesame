#!/bin/bash

# 正式环境使用的web.ini。
config_path=`pwd`

# 代码所在的路径
release_path=/Users/liuxd/Documents/web/

############# 以上是配置区 #############

# 检查 & 过滤
base_str='No syntax errors detected in '
cur=`pwd`
cd ../src/

find . -name "*.php" | while read php_file
do
    ret=`php -l $php_file`
    msg="$base_str$php_file"

    if [ "$msg" != "$ret" ]; then
        echo $msg
        exit
    fi

    cp -R $php_file{,.bak}
    php -w $php_file.bak > $php_file
done

git clean -df

cp $config_path/web.ini ./ini/web.ini

# 打包
cd $cur
php phar-packer.php --name=open-sesame --path=/Users/liuxd/Documents/github.com/open-sesame/src --init=index.php

# 部署
mv open-sesame.phar $release_path

# 恢复开发环境
cd $cur/../src/
git reset --hard
cp ini/web.ini.sample ini/web.ini
