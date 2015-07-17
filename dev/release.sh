#!/usr/bin/env bash

# Colorful printing.
# Demo:
#     _cecho 'hello' error
function _cecho {
    if [ "$is_cmd" = "log" ];then
        echo $1
        return
    fi

    case $2 in
        info )
            color=33;;
        error )
            color=31;;
        success )
            color=32;;
        *)
            color=1;;
    esac

    echo -e "\033["$color"m$1\033[0m"
}

cur=`dirname $0`
cd $cur

if [ $# -eq 0 ];then
    _cecho '请输入版本号' error
    exit
fi

cd ..

ver=$1

echo $ver > src/VERSION

git commit -am '修改版本号'
git tag $ver

git push origin master
git push --tags

_cecho '发布成功：'$ver

# end of this file.
