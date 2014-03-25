<?php

namespace controller;

use core as c;
use model as m;
use util as u;

class Detail extends Base
{
    public function run()
    {
        $iAccountID = $this->get('id');
        $oAccount = new m\Account;
        $aDetail = $oAccount->getAccountDetail($iAccountID);
        $aFields = $oAccount->getAccountFields($iAccountID);

        $oUser = new m\User;
        $sDefaultPassword = $oUser->getDefaultPassword();
        $aEmails = $oUser->getEmails();

        foreach ($aFields as $k => $v) {
            $aFields[$k]['display'] = u\Str::partCover($v['value'], 2, 1);
        }

        $aAccountAll = $oAccount->getAllAccount();
        $aSiteList = [];

        foreach ($aAccountAll as $aAccountDetail) {
            $aSiteList[] = ['name' => 'link:' . $aAccountDetail['name']];
        }

        $aData = [
            'page_title' => $aDetail['name'],
            'app' => $aDetail,
            'fields' => $aFields,
            'form_action_add' => c\Router::genURL('AddField'),
            'form_action_del' => c\Router::genURL('DeleteField'),
            'site_list' => json_encode($aSiteList),
            'default_password' => $sDefaultPassword['data'],
            'emails' => $aEmails['data']
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Detail';
    }
}

# end of this file
