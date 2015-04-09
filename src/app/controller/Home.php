<?php
namespace controller;

use core as c;
use util as u;
use model as m;

class Home extends Base
{
    public function run()
    {
        $oAccount = new m\Account;
        $iTotal = $oAccount->getTotal();

        if ($iTotal === false) {
            $oAccount->createTable();
        }

        $aData = [
            'page_title' => 'Open Sesame',
            'form_action_add' => c\Router::genURL('AddAccount'),
            'site_total' => $iTotal,
            'recomm' => (new m\Recommand)->get(4)
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Home';
    }
}

# end of this file
