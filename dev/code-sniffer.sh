#!/usr/bin/env bash

cd ../src

# The path of code sniffer.
phpcs='../dev/vendor/squizlabs/php_codesniffer/scripts/phpcs'

for target in app core util index.php;do
    for mode in PSR1 PSR2;do
        sniffer="$phpcs -p --colors --tab-width=4 --encoding=utf8 $target --standard=$mode"
        echo $sniffer
        $sniffer
    done
done

echo 'Finished!'
