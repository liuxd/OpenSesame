<?php

namespace cmd;

use core as c;
use model as m;
use util as u;

class Search
{
    public function run()
    {
        global $argv;

        if (!isset($argv[2])) {
            c\cecho('搜索词呢？', 'error');
            return false;
        }

        $aConfig = c\Config::get('dsn');
        u\DB::connect($aConfig['data']);

        $sKeyword = $argv[2];
        $aList = (new m\Search)->handle($sKeyword);
        $aNumberMapping = [];

        foreach ($aList as $iIndex => $aAccount) {
            $iIndexNumber = $iIndex + 1;
            $sAccountInfo = ' (' . $aAccount['rowid'] . ') ' . $aAccount['name'] . ' - http://' . $aAccount['value'];
            $sMsg = str_pad($iIndexNumber, 4) . $sAccountInfo;
            $aNumberMapping[$iIndexNumber] = $aAccount['rowid'];
            c\cecho($sMsg, 'notice');
        }

        c\cecho("你要搜索啥？（请输入行首序号）");
        $iNumber = trim(fread(STDIN, 5));

        if (empty($iNumber)) {
            return false;
        }

        while (!empty($iNumber) && !is_numeric($iNumber)) {
            c\cecho('What are you 弄啥累', 'error');
            c\cecho("你要搜索啥？（请输入行首序号）");
            $iNumber = trim(fread(STDIN, 5));
        }

        $iNumber = (int)$iNumber;

        if ($iNumber > 0 && isset($aNumberMapping[$iNumber])) {
            $iAccountID = $aNumberMapping[$iNumber];
            $oAccount = new m\Account;
            $aDetail = $oAccount->getAccountDetail($iAccountID);
            $aFields = $oAccount->getAccountFields($iAccountID);

            c\cecho($aDetail['name'], 'error');

            foreach ($aFields as $aField) {
                $sMsg = $aField['name'] . ' ---- ' . $aField['value'];
                c\cecho($sMsg, 'notice');
            }
        }
    }
}

# end of this file
