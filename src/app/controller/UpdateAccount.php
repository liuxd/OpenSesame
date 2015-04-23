<?php
namespace controller;

use core as c;
use model as m;

class UpdateAccount extends Base
{
    public function run()
    {
        $sAccountName = $this->post('account_name');
        $sAccountURL = 'http://' . parse_url($this->post('account_url'))['host'];
        $iAccountID = $this->post('account_id');

        (new m\Account)->updateAccount($sAccountName, parse_url($sAccountURL)['host'], $iAccountID, false);
        c\Router::redirect(c\Router::genURL('Detail', ['id' => $iAccountID]));
    }
}

# end of this file
