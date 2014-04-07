<?php
namespace controller;

use core as c;
use model as m;

class UpdateAccount extends Base
{
    public function run()
    {
        $sAccountName = $this->post('account_name');
        $sAccountURL = $this->post('account_url');
        $iAccountID = $this->post('account_id');

        (new m\Account)->update($sAccountName, parse_url($sAccountURL)['host'], $iAccountID);
        c\Router::redirect(c\Router::genURL('Detail', ['id' => $iAccountID]));
    }
}

# end of this file
