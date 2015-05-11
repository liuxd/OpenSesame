#!/usr/bin/env php
<?php
/**
 * 将PHP项目文件夹打包程“.phar”格式的压缩包。
 */

$longopts = array(
    'name::',
    'path::',
    'init:'
);
 
$opts = getopt('', $longopts);
 
$name = (isset($opts['name'])) ? $opts['name'] . '.phar' : '';
$path = (isset($opts['path'])) ? $opts['path'] : '';
$init = (isset($opts['init'])) ? $opts['init'] : 'index.php';
 
if (empty($name) && empty($path)) {
echo <<<HELP
phar packer 1.0
 
eg : php phar-packer.php --name=test --path=/project/to/ --init=index.php
 
--name    the name of the .phar file.
--path    the path of the project.
--init    the init file.
 
HELP;
echo PHP_EOL;
return;
}
 
if (empty($name) || empty($path)) {
    echo 'Options invalid!' . PHP_EOL;
    return;
}
 
$phar = new Phar($name, 0);
$phar->buildFromDirectory($path);
 
$stub = <<< EOF
<?php
Phar::mapPhar('{$name}');
require 'phar://{$name}/{$init}';
__HALT_COMPILER();
EOF;
 
$phar->setStub($stub);
$phar->compressFiles(Phar::GZ);
$phar->stopBuffering();
 
# end of this file
