#!/bin/bash

#检查 & 过滤
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

cp $cur/web.ini ./ini/web.ini

#打包
cd /Users/liuxd/Documents/github.com/phar-packer
php phar-packer.php --name=open-sesame --path=/Users/liuxd/Documents/github.com/open-sesame/src --init=index.php

#部署
mv open-sesame.phar /Users/liuxd/Documents/web/

#恢复开发环境
cd $cur/../src/
git reset --hard
cp ini/web.ini.sample ini/web.ini
