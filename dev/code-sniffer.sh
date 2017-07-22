#!/usr/bin/env bash

currentPath=`dirname $0`
cd $currentPath/../
currentRealPath=`pwd`

# The path of code sniffer.
phpcs=$currentRealPath'/dev/vendor/squizlabs/php_codesniffer/scripts/phpcs'
cd $currentRealPath/src

phpcsName=`basename $phpcs`

for target in app core util index.php;do
    for mode in PSR1 PSR2;do
        sniffer="$phpcsName -p --colors --tab-width=4 --encoding=utf8 $target --standard=$mode"
        echo $sniffer
        $phpcs -p --colors --tab-width=4 --encoding=utf8 $target --standard=$mode
    done
done

echo 'Finished!'

# end of this file