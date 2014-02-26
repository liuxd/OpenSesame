#!/bin/bash

# 检查 & 过滤
base_str='No syntax errors detected in '
cur=`pwd`
code_path=$cur/../src

cd $code_path 

find . -name "*.php" | while read php_file
do
    ret=`php -l $php_file`
    msg="$base_str$php_file"

    if [ "$msg" != "$ret" ]; then
        echo $msg
        exit
    fi

    cp $php_file{,.bak}
    php -w $php_file.bak > $php_file
done

git clean -dfq

# 打包
cd $cur
php phar-packer.php --name=open-sesame --path=$code_path --init=index.php

# 恢复开发环境
cd $code_path
git reset --hard -q

echo "发布完成！"
