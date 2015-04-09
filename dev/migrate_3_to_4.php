#!/usr/bin/env php
<?php
use core as c;
use util as u;
use model as m;

include '../src/core/Bootstrap.php';

$aConfig = c\Config::get('dsn');
u\DB::getInstance($aConfig['data']);

$sSQL = 'select *,rowid from account where parent != 0';
$all = u\DB::getList($sSQL);
$oAccount = new m\Account;

foreach ($all as $k => $v) {
    echo $v['rowid'], ' -- ', $v['name'], ' -- ' , $oAccount->decrypt($v['value']), PHP_EOL;
    $oAccount->update($v['name'], $oAccount->decrypt($v['value']), $v['rowid']);
}
