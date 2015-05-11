#!/usr/bin/env bash

phpcs='vendor/squizlabs/php_codesniffer/scripts/phpcs'

$phpcs ../src/app --standard=PSR1
$phpcs ../src/core --standard=PSR1
$phpcs ../src/util --standard=PSR1
$phpcs ../src/index.php --standard=PSR1

$phpcs ../src/app --standard=PSR2
$phpcs ../src/core --standard=PSR2
$phpcs ../src/util --standard=PSR2
$phpcs ../src/index.php --standard=PSR2

echo 'Finished!'
