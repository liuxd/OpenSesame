<?php
namespace controller;

use core as c;
use model as m;

class DeleteField extends Base
{
    public function run()
    {
        $iID = $this->post('id');
        $iAccountID = $this->post('account_id');
        (new m\Account)->del($iID);
        c\Router::redirect(c\Router::genURL('Detail', ['id' => $iAccountID]));
    }
}

# end of this file
