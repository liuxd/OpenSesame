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
        git reset --hard
        exit
    fi

    php -w $php_file > $php_file
done

#打包
cd /Users/liuxd/Documents/github.com/phar-packer
php phar-packer.php --name=open-sesame --path=/Users/liuxd/Documents/github.com/open-sesame/src --init=index.php
cd $cur/../src/
git reset --hard

#部署
mv open-sesame.phar /Users/liuxd/Documents/web/
